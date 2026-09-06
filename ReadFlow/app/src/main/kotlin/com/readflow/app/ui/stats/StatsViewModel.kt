package com.readflow.app.ui.stats

import androidx.lifecycle.SavedStateHandle
import androidx.lifecycle.ViewModel
import androidx.lifecycle.viewModelScope
import com.readflow.app.data.repository.BookRepository
import com.readflow.app.data.repository.ReadingGoalRepository
import com.readflow.app.data.repository.ReadingSessionRepository
import com.readflow.app.domain.BookStats
import com.readflow.app.domain.StatsCalculator
import dagger.hilt.android.lifecycle.HiltViewModel
import kotlinx.coroutines.flow.SharingStarted
import kotlinx.coroutines.flow.StateFlow
import kotlinx.coroutines.flow.combine
import kotlinx.coroutines.flow.stateIn
import javax.inject.Inject

data class StatsUiState(
    val isLoading: Boolean = true,
    val bookTitle: String = "",
    val stats: BookStats? = null
)

@HiltViewModel
class StatsViewModel @Inject constructor(
    savedStateHandle: SavedStateHandle,
    bookRepository: BookRepository,
    sessionRepository: ReadingSessionRepository,
    goalRepository: ReadingGoalRepository
) : ViewModel() {
    private val bookId: Long = checkNotNull(savedStateHandle["bookId"])

    val uiState: StateFlow<StatsUiState> = combine(
        bookRepository.observeBook(bookId),
        sessionRepository.observeForBook(bookId),
        goalRepository.observeForBook(bookId)
    ) { book, sessions, goal ->
        if (book == null) return@combine StatsUiState(isLoading = false)
        val stats = StatsCalculator.compute(
            pageCount = book.pageCount,
            currentPage = book.currentPage,
            sessions = sessions,
            targetPagesPerDay = goal?.targetPagesPerDay,
            nowMillis = System.currentTimeMillis()
        )
        StatsUiState(isLoading = false, bookTitle = book.title, stats = stats)
    }.stateIn(viewModelScope, SharingStarted.WhileSubscribed(5000), StatsUiState())
}
