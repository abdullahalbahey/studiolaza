package com.readflow.app.domain

import com.google.common.truth.Truth.assertThat
import com.readflow.app.data.local.db.entity.ReadingSessionEntity
import org.junit.Test
import java.time.ZoneId
import java.time.ZonedDateTime

class StatsCalculatorTest {

    private val zone = ZoneId.of("UTC")

    private fun atDay(day: String, hour: Int = 12): Long =
        ZonedDateTime.parse("${day}T${"%02d".format(hour)}:00:00Z").toInstant().toEpochMilli()

    @Test
    fun `compute with no sessions returns zeroed stats`() {
        val stats = StatsCalculator.compute(
            pageCount = 300,
            currentPage = 0,
            sessions = emptyList(),
            targetPagesPerDay = null,
            nowMillis = atDay("2024-01-10"),
            zoneId = zone
        )
        assertThat(stats.sessionCount).isEqualTo(0)
        assertThat(stats.totalReadingTimeMillis).isEqualTo(0)
        assertThat(stats.currentStreakDays).isEqualTo(0)
        assertThat(stats.longestStreakDays).isEqualTo(0)
        assertThat(stats.estimatedCompletionDate).isNull()
    }

    @Test
    fun `compute averages pages and duration across sessions`() {
        val sessions = listOf(
            ReadingSessionEntity(bookId = 1, startTime = atDay("2024-01-01"), endTime = atDay("2024-01-01") + 600_000, pagesStarted = 0, pagesEnded = 10, durationMillis = 600_000),
            ReadingSessionEntity(bookId = 1, startTime = atDay("2024-01-02"), endTime = atDay("2024-01-02") + 1_200_000, pagesStarted = 10, pagesEnded = 30, durationMillis = 1_200_000)
        )
        val stats = StatsCalculator.compute(
            pageCount = 300,
            currentPage = 29,
            sessions = sessions,
            targetPagesPerDay = null,
            nowMillis = atDay("2024-01-02", 23),
            zoneId = zone
        )
        assertThat(stats.sessionCount).isEqualTo(2)
        assertThat(stats.averagePagesPerSession).isEqualTo(15f) // (10 + 20) / 2
        assertThat(stats.averageSessionDurationMillis).isEqualTo(900_000L)
        assertThat(stats.totalReadingTimeMillis).isEqualTo(1_800_000L)
    }

    @Test
    fun `compute finds a streak across consecutive days and breaks on a gap`() {
        val sessions = listOf(
            ReadingSessionEntity(bookId = 1, startTime = atDay("2024-01-01"), endTime = atDay("2024-01-01") + 1000, pagesStarted = 0, pagesEnded = 5, durationMillis = 1000),
            ReadingSessionEntity(bookId = 1, startTime = atDay("2024-01-02"), endTime = atDay("2024-01-02") + 1000, pagesStarted = 5, pagesEnded = 10, durationMillis = 1000),
            ReadingSessionEntity(bookId = 1, startTime = atDay("2024-01-03"), endTime = atDay("2024-01-03") + 1000, pagesStarted = 10, pagesEnded = 15, durationMillis = 1000),
            // gap on Jan 4
            ReadingSessionEntity(bookId = 1, startTime = atDay("2024-01-05"), endTime = atDay("2024-01-05") + 1000, pagesStarted = 15, pagesEnded = 20, durationMillis = 1000)
        )
        val stats = StatsCalculator.compute(
            pageCount = 300,
            currentPage = 19,
            sessions = sessions,
            targetPagesPerDay = null,
            nowMillis = atDay("2024-01-05", 23),
            zoneId = zone
        )
        assertThat(stats.longestStreakDays).isEqualTo(3)
        assertThat(stats.currentStreakDays).isEqualTo(1) // only Jan 5 is consecutive up to "today"
    }

    @Test
    fun `compute estimates completion using actual historical pace over the target`() {
        val sessions = listOf(
            ReadingSessionEntity(bookId = 1, startTime = atDay("2024-01-01"), endTime = atDay("2024-01-01") + 1000, pagesStarted = 0, pagesEnded = 20, durationMillis = 1000)
        )
        // historical pace is 20 pages/day (one day of history), target says 5/day - actual history should win
        val stats = StatsCalculator.compute(
            pageCount = 120,
            currentPage = 19,
            sessions = sessions,
            targetPagesPerDay = 5,
            nowMillis = atDay("2024-01-01", 23),
            zoneId = zone
        )
        // remaining = 120 - 20 = 100 pages, at 20/day = 5 days
        val expected = atDay("2024-01-01", 23) + 5 * 24 * 60 * 60 * 1000L
        assertThat(stats.estimatedCompletionDate).isEqualTo(expected)
    }

    @Test
    fun `compute falls back to the target pace when there is no history`() {
        val stats = StatsCalculator.compute(
            pageCount = 100,
            currentPage = 0,
            sessions = emptyList(),
            targetPagesPerDay = 10,
            nowMillis = atDay("2024-01-01"),
            zoneId = zone
        )
        // remaining = 99 pages at 10/day = 10 days (ceil)
        val expected = atDay("2024-01-01") + 10 * 24 * 60 * 60 * 1000L
        assertThat(stats.estimatedCompletionDate).isEqualTo(expected)
    }

    @Test
    fun `compute returns no estimate once the book is finished`() {
        val stats = StatsCalculator.compute(
            pageCount = 100,
            currentPage = 99,
            sessions = emptyList(),
            targetPagesPerDay = 10,
            nowMillis = atDay("2024-01-01"),
            zoneId = zone
        )
        assertThat(stats.estimatedCompletionDate).isNull()
        assertThat(stats.percentComplete).isEqualTo(1f)
    }
}
