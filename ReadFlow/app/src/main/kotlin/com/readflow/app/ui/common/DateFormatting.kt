package com.readflow.app.ui.common

import java.time.Instant
import java.time.ZoneId
import java.time.format.DateTimeFormatter

/** "Today" / "Yesterday" / "3 days ago" / a short date, matching the library card mock in the spec. */
fun formatRelativeDate(millis: Long?, zoneId: ZoneId = ZoneId.systemDefault()): String {
    if (millis == null) return "Never"
    val date = Instant.ofEpochMilli(millis).atZone(zoneId).toLocalDate()
    val today = Instant.now().atZone(zoneId).toLocalDate()
    val days = today.toEpochDay() - date.toEpochDay()
    return when {
        days <= 0L -> "Today"
        days == 1L -> "Yesterday"
        days in 2..6 -> "$days days ago"
        else -> date.format(DateTimeFormatter.ofPattern("MMM d, yyyy"))
    }
}

fun formatDuration(millis: Long): String {
    val totalMinutes = millis / 60_000
    val hours = totalMinutes / 60
    val minutes = totalMinutes % 60
    return when {
        hours > 0 -> "${hours}h ${minutes}m"
        else -> "${minutes}m"
    }
}

fun formatDate(millis: Long, zoneId: ZoneId = ZoneId.systemDefault()): String {
    val date = Instant.ofEpochMilli(millis).atZone(zoneId).toLocalDate()
    return date.format(DateTimeFormatter.ofPattern("MMM d, yyyy"))
}
