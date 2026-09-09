package com.readflow.app.reminders

import android.content.BroadcastReceiver
import android.content.Context
import android.content.Intent
import com.readflow.app.data.local.db.dao.ReminderDao
import dagger.hilt.android.AndroidEntryPoint
import kotlinx.coroutines.CoroutineScope
import kotlinx.coroutines.Dispatchers
import kotlinx.coroutines.launch
import javax.inject.Inject

/** Exact alarms don't survive a reboot, so every enabled reminder is rescheduled here. */
@AndroidEntryPoint
class BootCompletedReceiver : BroadcastReceiver() {

    @Inject lateinit var reminderDao: ReminderDao
    @Inject lateinit var alarmScheduler: AlarmScheduler

    override fun onReceive(context: Context, intent: Intent) {
        if (intent.action != Intent.ACTION_BOOT_COMPLETED && intent.action != Intent.ACTION_MY_PACKAGE_REPLACED) return

        val pendingResult = goAsync()
        CoroutineScope(Dispatchers.IO).launch {
            try {
                reminderDao.getAllEnabled().forEach { alarmScheduler.schedule(it) }
            } finally {
                pendingResult.finish()
            }
        }
    }
}
