package com.readflow.app.domain

import com.readflow.app.data.local.db.entity.BookStatus

/** Pure progress math shared by the reader, library cards, and book details screen. */
object ProgressCalculator {

    /** Fraction complete in [0,1], treating [currentPage] (0-based) as the last page read. */
    fun percentComplete(currentPage: Int, pageCount: Int): Float {
        if (pageCount <= 0) return 0f
        return (((currentPage + 1).toFloat()) / pageCount).coerceIn(0f, 1f)
    }

    fun statusFor(currentPage: Int, pageCount: Int): BookStatus = when {
        pageCount <= 0 -> BookStatus.NOT_STARTED
        currentPage <= 0 -> BookStatus.NOT_STARTED
        currentPage >= pageCount - 1 -> BookStatus.COMPLETED
        else -> BookStatus.READING
    }

    /** Display-friendly "page N of M", 1-based. */
    fun displayPage(currentPage: Int): Int = currentPage + 1
}
