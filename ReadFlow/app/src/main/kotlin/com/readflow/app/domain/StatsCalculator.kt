package com.readflow.app.domain

import com.readflow.app.data.local.db.entity.ReadingSessionEntity
import java.time.Instant
import java.time.ZoneId
import kotlin.math.ceil

data class BookStats(
    val totalPages: Int,
    val pagesRead: Int,
    val percentComplete: Float,
    val totalReadingTimeMillis: Long,
    val averagePagesPerSession: Float,
    val averageSessionDurationMillis: Long,
    val sessionCount: Int,
    val currentStreakDays: Int,
    val longestStreakDays: Int,
    val estimatedCompletionDate: Long?
)

/** Pure, testable statistics math over a book's reading session history. */
object StatsCalculator {

    fun compute(
        pageCount: Int,
        currentPage: Int,
        sessions: List<ReadingSessionEntity>,
        targetPagesPerDay: Int?,
        nowMillis: Long,
        zoneId: ZoneId = ZoneId.systemDefault()
    ): BookStats {
        val pagesRead = (currentPage + 1).coerceIn(0, pageCount.coerceAtLeast(0))
        val percent = ProgressCalculator.percentComplete(currentPage, pageCount)
        val totalTime = sessions.sumOf { it.durationMillis }
        val avgPagesPerSession = if (sessions.isNotEmpty()) {
            sessions.map { pagesInSession(it) }.average().toFloat()
        } else 0f
        val avgDuration = if (sessions.isNotEmpty()) totalTime / sessions.size else 0L

        val (currentStreak, longestStreak) = computeStreaks(sessions, nowMillis, zoneId)
        val historicalPace = averagePagesPerDay(sessions, zoneId)
        val remaining = (pageCount - pagesRead).coerceAtLeast(0)
        val pace = if (historicalPace > 0.0) historicalPace else (targetPagesPerDay?.toDouble() ?: 0.0)
        val estimatedCompletion = if (pace > 0.0 && remaining > 0) {
            val daysNeeded = ceil(remaining / pace).toLong().coerceAtLeast(1)
            nowMillis + daysNeeded * ONE_DAY_MILLIS
        } else null

        return BookStats(
            totalPages = pageCount,
            pagesRead = pagesRead,
            percentComplete = percent,
            totalReadingTimeMillis = totalTime,
            averagePagesPerSession = avgPagesPerSession,
            averageSessionDurationMillis = avgDuration,
            sessionCount = sessions.size,
            currentStreakDays = currentStreak,
            longestStreakDays = longestStreak,
            estimatedCompletionDate = estimatedCompletion
        )
    }

    private fun pagesInSession(session: ReadingSessionEntity): Int =
        (session.pagesEnded - session.pagesStarted).coerceAtLeast(0)

    private fun averagePagesPerDay(sessions: List<ReadingSessionEntity>, zoneId: ZoneId): Double {
        if (sessions.isEmpty()) return 0.0
        val byDay = sessions.groupBy { epochDay(it.startTime, zoneId) }
        val totalPages = sessions.sumOf { pagesInSession(it) }
        return totalPages.toDouble() / byDay.size
    }

    private fun epochDay(millis: Long, zoneId: ZoneId): Long =
        Instant.ofEpochMilli(millis).atZone(zoneId).toLocalDate().toEpochDay()

    private fun computeStreaks(
        sessions: List<ReadingSessionEntity>,
        nowMillis: Long,
        zoneId: ZoneId
    ): Pair<Int, Int> {
        if (sessions.isEmpty()) return 0 to 0
        val days = sessions.map { epochDay(it.startTime, zoneId) }.toSortedSet().toList()

        var longest = 1
        var run = 1
        for (i in 1 until days.size) {
            run = if (days[i] == days[i - 1] + 1) run + 1 else 1
            longest = maxOf(longest, run)
        }

        val today = epochDay(nowMillis, zoneId)
        val daySet = days.toHashSet()
        var anchor = if (daySet.contains(today)) today else if (daySet.contains(today - 1)) today - 1 else null
        var current = 0
        if (anchor != null) {
            var d = anchor
            while (daySet.contains(d)) {
                current++
                d--
            }
        }
        return current to longest
    }

    private const val ONE_DAY_MILLIS = 24 * 60 * 60 * 1000L
}
