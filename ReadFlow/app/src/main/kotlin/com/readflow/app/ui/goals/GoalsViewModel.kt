package com.readflow.app.ui.goals

import androidx.lifecycle.ViewModel
import androidx.lifecycle.viewModelScope
import com.readflow.app.data.local.db.entity.BookStatus
import com.readflow.app.data.repository.BookRepository
import com.readflow.app.data.repository.ReadingGoalRepository
import com.readflow.app.domain.ProgressCalculator
import dagger.hilt.android.lifecycle.HiltViewModel
import kotlinx.coroutines.flow.SharingStarted
import kotlinx.coroutines.flow.StateFlow
import kotlinx.coroutines.flow.combine
import kotlinx.coroutines.flow.stateIn
import javax.inject.Inject

data class BookGoalUiModel(
    val bookId: Long,
    val title: String,
    val targetPagesPerDay: Int?,
    val progressPercent: Float,
    val currentPageDisplay: Int,
    val pageCount: Int,
    val remainingPages: Int
)

data class GoalsUiState(
    val isLoading: Boolean = true,
    val booksWithGoals: List<BookGoalUiModel> = emptyList(),
    val booksWithoutGoals: List<BookGoalUiModel> = emptyList()
)

@HiltViewModel
class GoalsViewModel @Inject constructor(
    bookRepository: BookRepository,
    goalRepository: ReadingGoalRepository
) : ViewModel() {

    val uiState: StateFlow<GoalsUiState> = combine(
        bookRepository.observeBooks(),
        goalRepository.observeAllEnabled()
    ) { books, goals ->
        val goalsByBook = goals.associateBy { it.bookId }
        val readingOrNotStarted = books.filter {
            val status = runCatching { BookStatus.valueOf(it.status) }.getOrDefault(BookStatus.NOT_STARTED)
            status != BookStatus.COMPLETED
        }
        val withGoals = readingOrNotStarted.filter { goalsByBook.containsKey(it.id) }.map { book ->
            val goal = goalsByBook[book.id]
            BookGoalUiModel(
                bookId = book.id,
                title = book.title,
                targetPagesPerDay = goal?.targetPagesPerDay,
                progressPercent = ProgressCalculator.percentComplete(book.currentPage, book.pageCount),
                currentPageDisplay = ProgressCalculator.displayPage(book.currentPage),
                pageCount = book.pageCount,
                remainingPages = (book.pageCount - ProgressCalculator.displayPage(book.currentPage)).coerceAtLeast(0)
            )
        }
        val withoutGoals = readingOrNotStarted.filter { !goalsByBook.containsKey(it.id) }.map { book ->
            BookGoalUiModel(
                bookId = book.id,
                title = book.title,
                targetPagesPerDay = null,
                progressPercent = ProgressCalculator.percentComplete(book.currentPage, book.pageCount),
                currentPageDisplay = ProgressCalculator.displayPage(book.currentPage),
                pageCount = book.pageCount,
                remainingPages = (book.pageCount - ProgressCalculator.displayPage(book.currentPage)).coerceAtLeast(0)
            )
        }
        GoalsUiState(isLoading = false, booksWithGoals = withGoals, booksWithoutGoals = withoutGoals)
    }.stateIn(viewModelScope, SharingStarted.WhileSubscribed(5000), GoalsUiState())
}
