package com.readflow.app.domain

import com.google.common.truth.Truth.assertThat
import com.readflow.app.data.local.db.entity.BookStatus
import org.junit.Test

class ProgressCalculatorTest {

    @Test
    fun `percentComplete is zero for an empty book`() {
        assertThat(ProgressCalculator.percentComplete(currentPage = 0, pageCount = 0)).isEqualTo(0f)
    }

    @Test
    fun `percentComplete counts the current page as read`() {
        // page 0 of a 100-page book means 1 page has been read
        assertThat(ProgressCalculator.percentComplete(currentPage = 0, pageCount = 100)).isEqualTo(0.01f)
    }

    @Test
    fun `percentComplete is 100 percent on the last page`() {
        assertThat(ProgressCalculator.percentComplete(currentPage = 99, pageCount = 100)).isEqualTo(1f)
    }

    @Test
    fun `percentComplete is clamped even if currentPage overshoots`() {
        assertThat(ProgressCalculator.percentComplete(currentPage = 500, pageCount = 100)).isEqualTo(1f)
    }

    @Test
    fun `statusFor returns NOT_STARTED at page zero`() {
        assertThat(ProgressCalculator.statusFor(currentPage = 0, pageCount = 100)).isEqualTo(BookStatus.NOT_STARTED)
    }

    @Test
    fun `statusFor returns READING in the middle`() {
        assertThat(ProgressCalculator.statusFor(currentPage = 40, pageCount = 100)).isEqualTo(BookStatus.READING)
    }

    @Test
    fun `statusFor returns COMPLETED on the last page`() {
        assertThat(ProgressCalculator.statusFor(currentPage = 99, pageCount = 100)).isEqualTo(BookStatus.COMPLETED)
    }

    @Test
    fun `statusFor returns NOT_STARTED for a book with no pages`() {
        assertThat(ProgressCalculator.statusFor(currentPage = 0, pageCount = 0)).isEqualTo(BookStatus.NOT_STARTED)
    }

    @Test
    fun `displayPage is 1-based`() {
        assertThat(ProgressCalculator.displayPage(0)).isEqualTo(1)
        assertThat(ProgressCalculator.displayPage(41)).isEqualTo(42)
    }
}
