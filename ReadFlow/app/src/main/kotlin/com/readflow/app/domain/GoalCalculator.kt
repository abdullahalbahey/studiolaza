package com.readflow.app.domain

import java.time.Instant
import java.time.ZoneId
import kotlin.math.ceil

data class GoalProgress(
    val pagesReadToday: Int,
    val remainingPages: Int,
    val estimatedCompletionDate: Long?,
    val onTrackToday: Boolean
)

/** Pure goal math: today's progress against a target, and a completion estimate. */
object GoalCalculator {

    fun compute(
        currentPage: Int,
        pageCount: Int,
        targetPagesPerDay: Int?,
        pagesReadToday: Int,
        historicalPagesPerDay: Double,
        nowMillis: Long
    ): GoalProgress {
        val remaining = (pageCount - (currentPage + 1)).coerceAtLeast(0)
        val pace = if (historicalPagesPerDay > 0.0) historicalPagesPerDay else (targetPagesPerDay?.toDouble() ?: 0.0)
        val estimatedCompletion = if (pace > 0.0 && remaining > 0) {
            val daysNeeded = ceil(remaining / pace).toLong().coerceAtLeast(1)
            nowMillis + daysNeeded * ONE_DAY_MILLIS
        } else null
        val onTrack = targetPagesPerDay == null || targetPagesPerDay <= 0 || pagesReadToday >= targetPagesPerDay
        return GoalProgress(pagesReadToday, remaining, estimatedCompletion, onTrack)
    }

    fun isReachableByTargetDate(remainingPages: Int, targetDateMillis: Long?, nowMillis: Long, zoneId: ZoneId = ZoneId.systemDefault()): Boolean {
        if (targetDateMillis == null || remainingPages <= 0) return true
        val daysLeft = daysBetween(nowMillis, targetDateMillis, zoneId)
        return daysLeft > 0
    }

    fun requiredPagesPerDay(remainingPages: Int, targetDateMillis: Long?, nowMillis: Long, zoneId: ZoneId = ZoneId.systemDefault()): Int? {
        if (targetDateMillis == null || remainingPages <= 0) return null
        val daysLeft = daysBetween(nowMillis, targetDateMillis, zoneId).coerceAtLeast(1)
        return ceil(remainingPages.toDouble() / daysLeft).toInt()
    }

    private fun daysBetween(fromMillis: Long, toMillis: Long, zoneId: ZoneId): Long {
        val from = Instant.ofEpochMilli(fromMillis).atZone(zoneId).toLocalDate()
        val to = Instant.ofEpochMilli(toMillis).atZone(zoneId).toLocalDate()
        return to.toEpochDay() - from.toEpochDay()
    }

    private const val ONE_DAY_MILLIS = 24 * 60 * 60 * 1000L
}
