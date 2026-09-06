package com.readflow.app

import android.app.Application
import android.app.NotificationChannel
import android.app.NotificationManager
import android.os.Build
import com.readflow.app.reminders.NotificationHelper
import dagger.hilt.android.HiltAndroidApp

@HiltAndroidApp
class ReadFlowApplication : Application() {

    override fun onCreate() {
        super.onCreate()
        createNotificationChannel()
    }

    private fun createNotificationChannel() {
        if (Build.VERSION.SDK_INT >= Build.VERSION_CODES.O) {
            val manager = getSystemService(NotificationManager::class.java)
            val channel = NotificationChannel(
                NotificationHelper.REMINDER_CHANNEL_ID,
                getString(R.string.notification_channel_reminders_name),
                NotificationManager.IMPORTANCE_DEFAULT
            ).apply {
                description = getString(R.string.notification_channel_reminders_description)
            }
            manager.createNotificationChannel(channel)
        }
    }
}
