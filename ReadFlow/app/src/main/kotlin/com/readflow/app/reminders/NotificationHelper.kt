package com.readflow.app.reminders

import android.Manifest
import android.app.Notification
import android.app.NotificationManager
import android.app.PendingIntent
import android.content.Context
import android.content.Intent
import android.content.pm.PackageManager
import android.os.Build
import androidx.core.app.ActivityCompat
import androidx.core.app.NotificationCompat
import com.readflow.app.MainActivity
import com.readflow.app.R
import com.readflow.app.data.local.db.entity.BookEntity
import com.readflow.app.data.local.db.entity.ReminderEntity
import dagger.hilt.android.qualifiers.ApplicationContext
import javax.inject.Inject
import javax.inject.Singleton

const val EXTRA_OPEN_BOOK_ID = "extra_open_book_id"

@Singleton
class NotificationHelper @Inject constructor(
    @ApplicationContext private val context: Context,
    private val notificationManager: NotificationManager
) {
    companion object {
        const val REMINDER_CHANNEL_ID = "reading_reminders"
    }

    fun showReminderNotification(reminder: ReminderEntity, book: BookEntity?) {
        if (Build.VERSION.SDK_INT >= Build.VERSION_CODES.TIRAMISU) {
            val granted = ActivityCompat.checkSelfPermission(context, Manifest.permission.POST_NOTIFICATIONS) ==
                PackageManager.PERMISSION_GRANTED
            if (!granted) return
        }

        val contentIntent = Intent(context, MainActivity::class.java).apply {
            flags = Intent.FLAG_ACTIVITY_NEW_TASK or Intent.FLAG_ACTIVITY_CLEAR_TOP
            if (book != null) putExtra(EXTRA_OPEN_BOOK_ID, book.id)
        }
        val pendingIntent = PendingIntent.getActivity(
            context,
            reminder.id.toInt(),
            contentIntent,
            PendingIntent.FLAG_UPDATE_CURRENT or PendingIntent.FLAG_IMMUTABLE
        )

        val title = context.getString(R.string.notification_reminder_title)
        val body = reminder.message?.takeIf { it.isNotBlank() } ?: buildDefaultBody(book)

        val notification: Notification = NotificationCompat.Builder(context, REMINDER_CHANNEL_ID)
            .setSmallIcon(R.drawable.ic_notification_book)
            .setContentTitle(title)
            .setContentText(body)
            .setStyle(NotificationCompat.BigTextStyle().bigText(body))
            .setContentIntent(pendingIntent)
            .setAutoCancel(true)
            .addAction(0, context.getString(R.string.notification_action_read_now), pendingIntent)
            .build()

        notificationManager.notify(reminder.id.toInt(), notification)
    }

    private fun buildDefaultBody(book: BookEntity?): String {
        if (book == null) {
            return context.getString(R.string.notification_reminder_body_generic)
        }
        val page = book.currentPage + 1
        return context.getString(R.string.notification_reminder_body_book, book.title, page, book.pageCount)
    }
}
