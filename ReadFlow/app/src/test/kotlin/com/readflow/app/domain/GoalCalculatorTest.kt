package com.readflow.app.domain

import com.google.common.truth.Truth.assertThat
import org.junit.Test
import java.time.ZoneId
import java.time.ZonedDateTime

class GoalCalculatorTest {

    private val zone = ZoneId.of("UTC")

    private fun atDay(day: String): Long = ZonedDateTime.parse("${day}T00:00:00Z").toInstant().toEpochMilli()

    @Test
    fun `compute reports remaining pages`() {
        val progress = GoalCalculator.compute(
            currentPage = 49,
            pageCount = 300,
            targetPagesPerDay = 10,
            pagesReadToday = 10,
            historicalPagesPerDay = 0.0,
            nowMillis = atDay("2024-01-01")
        )
        assertThat(progress.remainingPages).isEqualTo(250)
    }

    @Test
    fun `compute is on track when today's pages meet the target`() {
        val progress = GoalCalculator.compute(
            currentPage = 9,
            pageCount = 300,
            targetPagesPerDay = 10,
            pagesReadToday = 10,
            historicalPagesPerDay = 0.0,
            nowMillis = atDay("2024-01-01")
        )
        assertThat(progress.onTrackToday).isTrue()
    }

    @Test
    fun `compute is not on track when behind the daily target`() {
        val progress = GoalCalculator.compute(
            currentPage = 4,
            pageCount = 300,
            targetPagesPerDay = 10,
            pagesReadToday = 4,
            historicalPagesPerDay = 0.0,
            nowMillis = atDay("2024-01-01")
        )
        assertThat(progress.onTrackToday).isFalse()
    }

    @Test
    fun `compute with no target is always on track`() {
        val progress = GoalCalculator.compute(
            currentPage = 0,
            pageCount = 300,
            targetPagesPerDay = null,
            pagesReadToday = 0,
            historicalPagesPerDay = 0.0,
            nowMillis = atDay("2024-01-01")
        )
        assertThat(progress.onTrackToday).isTrue()
    }

    @Test
    fun `requiredPagesPerDay divides remaining pages by days left`() {
        val required = GoalCalculator.requiredPagesPerDay(
            remainingPages = 100,
            targetDateMillis = atDay("2024-01-11"),
            nowMillis = atDay("2024-01-01"),
            zoneId = zone
        )
        // 10 days between Jan 1 and Jan 11 -> 10 pages/day
        assertThat(required).isEqualTo(10)
    }

    @Test
    fun `requiredPagesPerDay is null without a target date`() {
        val required = GoalCalculator.requiredPagesPerDay(
            remainingPages = 100,
            targetDateMillis = null,
            nowMillis = atDay("2024-01-01"),
            zoneId = zone
        )
        assertThat(required).isNull()
    }

    @Test
    fun `isReachableByTargetDate is false once the date has passed`() {
        val reachable = GoalCalculator.isReachableByTargetDate(
            remainingPages = 50,
            targetDateMillis = atDay("2024-01-01"),
            nowMillis = atDay("2024-01-05"),
            zoneId = zone
        )
        assertThat(reachable).isFalse()
    }

    @Test
    fun `isReachableByTargetDate is true when already finished`() {
        val reachable = GoalCalculator.isReachableByTargetDate(
            remainingPages = 0,
            targetDateMillis = atDay("2024-01-01"),
            nowMillis = atDay("2024-01-05"),
            zoneId = zone
        )
        assertThat(reachable).isTrue()
    }
}
