package com.readflow.app

import android.app.Application
import android.app.NotificationChannel
import android.app.NotificationManager
import android.media.AudioAttributes
import android.net.Uri
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
            val soundUri = Uri.parse("android.resource://$packageName/${R.raw.reminder_tone}")
            val audioAttributes = AudioAttributes.Builder()
                .setUsage(AudioAttributes.USAGE_NOTIFICATION)
                .setContentType(AudioAttributes.CONTENT_TYPE_SONIFICATION)
                .build()
            val channel = NotificationChannel(
                NotificationHelper.REMINDER_CHANNEL_ID,
                getString(R.string.notification_channel_reminders_name),
                // HIGH is required for a heads-up pop-up banner + sound; DEFAULT only shows
                // silently in the shade on most OEM skins (notably Samsung One UI).
                NotificationManager.IMPORTANCE_HIGH
            ).apply {
                description = getString(R.string.notification_channel_reminders_description)
                enableVibration(true)
                setSound(soundUri, audioAttributes)
            }
            manager.createNotificationChannel(channel)
        }
    }
}
