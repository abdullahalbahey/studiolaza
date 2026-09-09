package com.readflow.app.ui.goals

import androidx.lifecycle.SavedStateHandle
import androidx.lifecycle.ViewModel
import androidx.lifecycle.viewModelScope
import com.readflow.app.data.repository.BookRepository
import com.readflow.app.data.repository.ReadingGoalRepository
import dagger.hilt.android.lifecycle.HiltViewModel
import kotlinx.coroutines.flow.MutableStateFlow
import kotlinx.coroutines.flow.StateFlow
import kotlinx.coroutines.flow.asStateFlow
import kotlinx.coroutines.flow.update
import kotlinx.coroutines.launch
import java.time.Instant
import java.time.ZoneId
import javax.inject.Inject

data class GoalEditorUiState(
    val bookTitle: String = "",
    val pageCount: Int = 0,
    val currentPage: Int = 0,
    val targetPagesPerDay: String = "",
    val targetMinutesPerDay: String = "",
    val targetDateMillis: Long? = null,
    val saved: Boolean = false,
    val hasExistingGoal: Boolean = false
)

@HiltViewModel
class GoalEditorViewModel @Inject constructor(
    savedStateHandle: SavedStateHandle,
    private val bookRepository: BookRepository,
    private val goalRepository: ReadingGoalRepository
) : ViewModel() {
    private val bookId: Long = checkNotNull(savedStateHandle["bookId"])

    private val _uiState = MutableStateFlow(GoalEditorUiState())
    val uiState: StateFlow<GoalEditorUiState> = _uiState.asStateFlow()

    init {
        viewModelScope.launch {
            val book = bookRepository.getBook(bookId)
            val goal = goalRepository.getForBook(bookId)
            _uiState.update {
                it.copy(
                    bookTitle = book?.title ?: "",
                    pageCount = book?.pageCount ?: 0,
                    currentPage = book?.currentPage ?: 0,
                    targetPagesPerDay = goal?.targetPagesPerDay?.toString() ?: "",
                    targetMinutesPerDay = goal?.targetMinutesPerDay?.toString() ?: "",
                    targetDateMillis = goal?.targetDate,
                    hasExistingGoal = goal != null
                )
            }
        }
    }

    fun setPagesPerDay(value: String) {
        _uiState.update { it.copy(targetPagesPerDay = value.filter { c -> c.isDigit() }) }
    }

    fun setMinutesPerDay(value: String) {
        _uiState.update { it.copy(targetMinutesPerDay = value.filter { c -> c.isDigit() }) }
    }

    fun setTargetDate(millis: Long?) {
        _uiState.update { it.copy(targetDateMillis = millis) }
    }

    fun save() {
        val state = _uiState.value
        viewModelScope.launch {
            goalRepository.setGoal(
                bookId = bookId,
                targetPagesPerDay = state.targetPagesPerDay.toIntOrNull(),
                targetMinutesPerDay = state.targetMinutesPerDay.toIntOrNull(),
                targetDate = state.targetDateMillis
            )
            _uiState.update { it.copy(saved = true) }
        }
    }

    fun clearGoal() {
        viewModelScope.launch {
            goalRepository.clearGoal(bookId)
            _uiState.update { it.copy(saved = true) }
        }
    }
}
