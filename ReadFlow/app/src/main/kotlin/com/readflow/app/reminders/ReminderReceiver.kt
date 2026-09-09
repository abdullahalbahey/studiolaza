package com.readflow.app.reminders

import android.content.BroadcastReceiver
import android.content.Context
import android.content.Intent
import com.readflow.app.data.local.db.dao.BookDao
import com.readflow.app.data.local.db.dao.ReminderDao
import dagger.hilt.android.AndroidEntryPoint
import kotlinx.coroutines.CoroutineScope
import kotlinx.coroutines.Dispatchers
import kotlinx.coroutines.launch
import javax.inject.Inject

@AndroidEntryPoint
class ReminderReceiver : BroadcastReceiver() {

    @Inject lateinit var reminderDao: ReminderDao
    @Inject lateinit var bookDao: BookDao
    @Inject lateinit var notificationHelper: NotificationHelper
    @Inject lateinit var alarmScheduler: AlarmScheduler

    override fun onReceive(context: Context, intent: Intent) {
        val reminderId = intent.getLongExtra(EXTRA_REMINDER_ID, -1L)
        if (reminderId < 0) return

        val pendingResult = goAsync()
        CoroutineScope(Dispatchers.IO).launch {
            try {
                val reminder = reminderDao.getById(reminderId)
                if (reminder != null && reminder.enabled) {
                    val book = reminder.bookId?.let { bookDao.getBook(it) }
                    notificationHelper.showReminderNotification(reminder, book)
                    // Recurring reminders: schedule the next occurrence right away.
                    alarmScheduler.schedule(reminder)
                }
            } finally {
                pendingResult.finish()
            }
        }
    }
}
