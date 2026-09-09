package com.readflow.app.reminders

import android.app.AlarmManager
import android.app.PendingIntent
import android.content.Context
import android.content.Intent
import android.os.Build
import android.os.PowerManager
import com.readflow.app.data.local.db.entity.ReminderEntity
import com.readflow.app.domain.ReminderScheduleCalculator
import dagger.hilt.android.qualifiers.ApplicationContext
import javax.inject.Inject
import javax.inject.Singleton

const val EXTRA_REMINDER_ID = "extra_reminder_id"

@Singleton
class AlarmScheduler @Inject constructor(
    @ApplicationContext private val context: Context,
    private val alarmManager: AlarmManager
) {

    fun canScheduleExactAlarms(): Boolean =
        if (Build.VERSION.SDK_INT >= Build.VERSION_CODES.S) alarmManager.canScheduleExactAlarms() else true

    /**
     * Whether this app is exempt from system battery optimization. When it isn't, OEM battery
     * managers (Samsung's "Put unused apps to sleep" especially) can silently kill the process
     * or defer/drop the alarm before it ever reaches [ReminderReceiver], with no error anywhere -
     * the reminder just never fires. This is the most common real-world cause of "I set a
     * reminder and nothing happened" on Android, independent of whether the alarm itself was
     * scheduled correctly.
     */
    fun isIgnoringBatteryOptimizations(): Boolean {
        val powerManager = context.getSystemService(Context.POWER_SERVICE) as? PowerManager ?: return true
        return powerManager.isIgnoringBatteryOptimizations(context.packageName)
    }

    fun schedule(reminder: ReminderEntity) {
        if (!reminder.enabled) {
            cancel(reminder.id)
            return
        }
        val days = ReminderScheduleCalculator.parseDaysOfWeek(reminder.daysOfWeek)
        val triggerAt = ReminderScheduleCalculator.nextTriggerMillis(
            hour = reminder.hour,
            minute = reminder.minute,
            daysOfWeek = days,
            nowMillis = System.currentTimeMillis()
        )
        val pendingIntent = buildPendingIntent(reminder.id)
        try {
            if (canScheduleExactAlarms()) {
                alarmManager.setExactAndAllowWhileIdle(AlarmManager.RTC_WAKEUP, triggerAt, pendingIntent)
            } else {
                alarmManager.setAndAllowWhileIdle(AlarmManager.RTC_WAKEUP, triggerAt, pendingIntent)
            }
        } catch (e: SecurityException) {
            // Exact alarm permission revoked between the check and the call; fall back silently.
            alarmManager.setAndAllowWhileIdle(AlarmManager.RTC_WAKEUP, triggerAt, pendingIntent)
        }
    }

    fun cancel(reminderId: Long) {
        alarmManager.cancel(buildPendingIntent(reminderId))
    }

    private fun buildPendingIntent(reminderId: Long): PendingIntent {
        val intent = Intent(context, ReminderReceiver::class.java).apply {
            putExtra(EXTRA_REMINDER_ID, reminderId)
        }
        val flags = PendingIntent.FLAG_UPDATE_CURRENT or PendingIntent.FLAG_IMMUTABLE
        return PendingIntent.getBroadcast(context, reminderId.toInt(), intent, flags)
    }
}
