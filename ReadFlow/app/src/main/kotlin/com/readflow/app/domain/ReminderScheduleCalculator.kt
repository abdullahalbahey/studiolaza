package com.readflow.app.domain

import java.time.Instant
import java.time.ZoneId

/** Pure computation of "when does this reminder next fire", independent of AlarmManager. */
object ReminderScheduleCalculator {

    /**
     * @param daysOfWeek [java.time.DayOfWeek] values (1=Monday..7=Sunday). Empty means every day.
     */
    fun nextTriggerMillis(
        hour: Int,
        minute: Int,
        daysOfWeek: Set<Int>,
        nowMillis: Long,
        zoneId: ZoneId = ZoneId.systemDefault()
    ): Long {
        val now = Instant.ofEpochMilli(nowMillis).atZone(zoneId)
        val todayAtTime = now.withHour(hour).withMinute(minute).withSecond(0).withNano(0)

        if (daysOfWeek.isEmpty()) {
            val candidate = if (todayAtTime.isAfter(now)) todayAtTime else todayAtTime.plusDays(1)
            return candidate.toInstant().toEpochMilli()
        }

        for (offset in 0..7) {
            val candidate = todayAtTime.plusDays(offset.toLong())
            if (daysOfWeek.contains(candidate.dayOfWeek.value) && candidate.isAfter(now)) {
                return candidate.toInstant().toEpochMilli()
            }
        }
        // Unreachable given a non-empty daysOfWeek set, but keep a safe fallback.
        return todayAtTime.plusDays(7).toInstant().toEpochMilli()
    }

    fun parseDaysOfWeek(csv: String): Set<Int> =
        csv.split(",").mapNotNull { it.trim().toIntOrNull() }.filter { it in 1..7 }.toSet()

    fun formatDaysOfWeek(days: Set<Int>): String = days.sorted().joinToString(",")
}
