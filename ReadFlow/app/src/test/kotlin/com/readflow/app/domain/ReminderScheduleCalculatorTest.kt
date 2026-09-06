package com.readflow.app.domain

import com.google.common.truth.Truth.assertThat
import org.junit.Test
import java.time.ZoneId
import java.time.ZonedDateTime

class ReminderScheduleCalculatorTest {

    private val zone = ZoneId.of("UTC")

    @Test
    fun `nextTrigger for every day picks later today when the time hasn't passed`() {
        // Monday 2024-01-01 at 10:00
        val now = ZonedDateTime.parse("2024-01-01T10:00:00Z").toInstant().toEpochMilli()
        val next = ReminderScheduleCalculator.nextTriggerMillis(hour = 20, minute = 0, daysOfWeek = emptySet(), nowMillis = now, zoneId = zone)
        val expected = ZonedDateTime.parse("2024-01-01T20:00:00Z").toInstant().toEpochMilli()
        assertThat(next).isEqualTo(expected)
    }

    @Test
    fun `nextTrigger for every day rolls to tomorrow when today's time already passed`() {
        // Monday 2024-01-01 at 21:00, target is 20:00
        val now = ZonedDateTime.parse("2024-01-01T21:00:00Z").toInstant().toEpochMilli()
        val next = ReminderScheduleCalculator.nextTriggerMillis(hour = 20, minute = 0, daysOfWeek = emptySet(), nowMillis = now, zoneId = zone)
        val expected = ZonedDateTime.parse("2024-01-02T20:00:00Z").toInstant().toEpochMilli()
        assertThat(next).isEqualTo(expected)
    }

    @Test
    fun `nextTrigger with specific days picks the next matching day of week`() {
        // Monday 2024-01-01. Days = Wed(3), Fri(5)
        val now = ZonedDateTime.parse("2024-01-01T08:00:00Z").toInstant().toEpochMilli()
        val next = ReminderScheduleCalculator.nextTriggerMillis(hour = 19, minute = 30, daysOfWeek = setOf(3, 5), nowMillis = now, zoneId = zone)
        val expected = ZonedDateTime.parse("2024-01-03T19:30:00Z").toInstant().toEpochMilli() // Wednesday
        assertThat(next).isEqualTo(expected)
    }

    @Test
    fun `nextTrigger with a single day wraps to next week when that day already passed this week`() {
        // Monday 2024-01-01 at 22:00. Only Monday(1) selected, and today's time has passed.
        val now = ZonedDateTime.parse("2024-01-01T22:00:00Z").toInstant().toEpochMilli()
        val next = ReminderScheduleCalculator.nextTriggerMillis(hour = 20, minute = 0, daysOfWeek = setOf(1), nowMillis = now, zoneId = zone)
        val expected = ZonedDateTime.parse("2024-01-08T20:00:00Z").toInstant().toEpochMilli() // next Monday
        assertThat(next).isEqualTo(expected)
    }

    @Test
    fun `nextTrigger on the selected day before the time fires today`() {
        // Wednesday 2024-01-03 at 08:00, days = Wed(3), time 19:30
        val now = ZonedDateTime.parse("2024-01-03T08:00:00Z").toInstant().toEpochMilli()
        val next = ReminderScheduleCalculator.nextTriggerMillis(hour = 19, minute = 30, daysOfWeek = setOf(3), nowMillis = now, zoneId = zone)
        val expected = ZonedDateTime.parse("2024-01-03T19:30:00Z").toInstant().toEpochMilli()
        assertThat(next).isEqualTo(expected)
    }

    @Test
    fun `parseDaysOfWeek and formatDaysOfWeek round-trip`() {
        val days = setOf(1, 3, 5)
        val formatted = ReminderScheduleCalculator.formatDaysOfWeek(days)
        assertThat(formatted).isEqualTo("1,3,5")
        assertThat(ReminderScheduleCalculator.parseDaysOfWeek(formatted)).isEqualTo(days)
    }

    @Test
    fun `parseDaysOfWeek ignores invalid values`() {
        assertThat(ReminderScheduleCalculator.parseDaysOfWeek("1, 9, abc, 4")).isEqualTo(setOf(1, 4))
    }

    @Test
    fun `parseDaysOfWeek of blank string is every day`() {
        assertThat(ReminderScheduleCalculator.parseDaysOfWeek("")).isEmpty()
    }
}
