package com.readflow.app.ui.bookdetails

import androidx.lifecycle.SavedStateHandle
import androidx.lifecycle.ViewModel
import androidx.lifecycle.viewModelScope
import com.readflow.app.data.local.db.entity.BookEntity
import com.readflow.app.data.local.db.entity.BookStatus
import com.readflow.app.data.local.db.entity.ReadingGoalEntity
import com.readflow.app.data.repository.BookRepository
import com.readflow.app.data.repository.ReadingGoalRepository
import com.readflow.app.data.repository.ReadingSessionRepository
import com.readflow.app.domain.GoalCalculator
import com.readflow.app.domain.ProgressCalculator
import com.readflow.app.domain.StatsCalculator
import dagger.hilt.android.lifecycle.HiltViewModel
import kotlinx.coroutines.flow.SharingStarted
import kotlinx.coroutines.flow.StateFlow
import kotlinx.coroutines.flow.combine
import kotlinx.coroutines.flow.stateIn
import kotlinx.coroutines.launch
import java.time.Instant
import java.time.ZoneId
import javax.inject.Inject

data class BookDetailsUiState(
    val isLoading: Boolean = true,
    val bookId: Long = 0,
    val title: String = "",
    val author: String? = null,
    val coverPath: String? = null,
    val pageCount: Int = 0,
    val currentPageDisplay: Int = 0,
    val progressPercent: Float = 0f,
    val status: BookStatus = BookStatus.NOT_STARTED,
    val totalReadingTimeMillis: Long = 0,
    val goalPagesPerDay: Int? = null,
    val goalPagesReadToday: Int = 0,
    val goalOnTrackToday: Boolean = true,
    val goalRemainingPages: Int = 0,
    val goalEstimatedCompletionMillis: Long? = null,
    val readingModeEnabled: Boolean = false,
    val hasExtractableText: Boolean = false,
    val deleted: Boolean = false
)

@HiltViewModel
class BookDetailsViewModel @Inject constructor(
    savedStateHandle: SavedStateHandle,
    private val bookRepository: BookRepository,
    private val readingGoalRepository: ReadingGoalRepository,
    private val sessionRepository: ReadingSessionRepository
) : ViewModel() {

    private val bookId: Long = checkNotNull(savedStateHandle["bookId"])

    val uiState: StateFlow<BookDetailsUiState> = combine(
        bookRepository.observeBook(bookId),
        readingGoalRepository.observeForBook(bookId),
        sessionRepository.observeForBook(bookId)
    ) { book, goal, sessions ->
        if (book == null) return@combine BookDetailsUiState(isLoading = false, deleted = true)
        val now = System.currentTimeMillis()
        val stats = StatsCalculator.compute(
            pageCount = book.pageCount,
            currentPage = book.currentPage,
            sessions = sessions,
            targetPagesPerDay = goal?.targetPagesPerDay,
            nowMillis = now
        )
        val today = Instant.ofEpochMilli(now).atZone(ZoneId.systemDefault()).toLocalDate()
        val pagesReadToday = sessions
            .filter { Instant.ofEpochMilli(it.startTime).atZone(ZoneId.systemDefault()).toLocalDate() == today }
            .sumOf { (it.pagesEnded - it.pagesStarted).coerceAtLeast(0) }
        val goalProgress = GoalCalculator.compute(
            currentPage = book.currentPage,
            pageCount = book.pageCount,
            targetPagesPerDay = goal?.targetPagesPerDay,
            pagesReadToday = pagesReadToday,
            historicalPagesPerDay = 0.0,
            nowMillis = now
        )
        BookDetailsUiState(
            isLoading = false,
            bookId = book.id,
            title = book.title,
            author = book.author,
            coverPath = book.coverPath,
            pageCount = book.pageCount,
            currentPageDisplay = ProgressCalculator.displayPage(book.currentPage),
            progressPercent = ProgressCalculator.percentComplete(book.currentPage, book.pageCount),
            status = runCatching { BookStatus.valueOf(book.status) }.getOrDefault(BookStatus.NOT_STARTED),
            totalReadingTimeMillis = book.totalReadingTimeMillis,
            goalPagesPerDay = goal?.targetPagesPerDay,
            goalPagesReadToday = goalProgress.pagesReadToday,
            goalOnTrackToday = goalProgress.onTrackToday,
            goalRemainingPages = stats.totalPages - stats.pagesRead,
            goalEstimatedCompletionMillis = stats.estimatedCompletionDate,
            readingModeEnabled = book.readingModeEnabled,
            hasExtractableText = book.hasExtractableText
        )
    }.stateIn(viewModelScope, SharingStarted.WhileSubscribed(5000), BookDetailsUiState())

    fun deleteBook() {
        viewModelScope.launch {
            bookRepository.deleteBook(bookId)
        }
    }

    fun setReadingModeEnabled(enabled: Boolean) {
        viewModelScope.launch {
            bookRepository.setReadingModeEnabled(bookId, enabled)
        }
    }
}
