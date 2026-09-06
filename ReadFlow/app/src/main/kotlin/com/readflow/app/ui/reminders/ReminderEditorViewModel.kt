package com.readflow.app.ui.reminders

import androidx.lifecycle.SavedStateHandle
import androidx.lifecycle.ViewModel
import androidx.lifecycle.viewModelScope
import com.readflow.app.data.local.datastore.SettingsDataStore
import com.readflow.app.data.repository.BookRepository
import com.readflow.app.data.repository.ReminderRepository
import com.readflow.app.domain.ReminderScheduleCalculator
import com.readflow.app.reminders.AlarmScheduler
import dagger.hilt.android.lifecycle.HiltViewModel
import kotlinx.coroutines.flow.MutableStateFlow
import kotlinx.coroutines.flow.StateFlow
import kotlinx.coroutines.flow.asStateFlow
import kotlinx.coroutines.flow.first
import kotlinx.coroutines.flow.update
import kotlinx.coroutines.launch
import javax.inject.Inject

data class ReminderEditorUiState(
    val isLoading: Boolean = true,
    val isEditing: Boolean = false,
    val hour: Int = 20,
    val minute: Int = 0,
    val selectedDays: Set<Int> = emptySet(),
    val enabled: Boolean = true,
    val message: String = "",
    val dailyTargetPages: String = "",
    val selectedBookId: Long? = null,
    val selectedBookTitle: String? = null,
    val availableBooks: List<Pair<Long, String>> = emptyList(),
    val canScheduleExactAlarms: Boolean = true,
    val saved: Boolean = false,
    val deleted: Boolean = false
)

@HiltViewModel
class ReminderEditorViewModel @Inject constructor(
    savedStateHandle: SavedStateHandle,
    private val reminderRepository: ReminderRepository,
    private val bookRepository: BookRepository,
    private val settingsDataStore: SettingsDataStore,
    private val alarmScheduler: AlarmScheduler
) : ViewModel() {

    private val bookIdArg: Long? = (savedStateHandle.get<Long>("bookId"))?.takeIf { it > 0 }
    private val reminderIdArg: Long? = (savedStateHandle.get<Long>("reminderId"))?.takeIf { it > 0 }

    private val _uiState = MutableStateFlow(ReminderEditorUiState())
    val uiState: StateFlow<ReminderEditorUiState> = _uiState.asStateFlow()

    init {
        viewModelScope.launch {
            val defaults = settingsDataStore.settings.first()
            var hour = defaults.defaultReminderHour
            var minute = defaults.defaultReminderMinute
            var days = emptySet<Int>()
            var enabled = true
            var message = ""
            var dailyTarget = ""
            var bookId = bookIdArg

            if (reminderIdArg != null) {
                reminderRepository.getById(reminderIdArg)?.let { existing ->
                    hour = existing.hour
                    minute = existing.minute
                    days = ReminderScheduleCalculator.parseDaysOfWeek(existing.daysOfWeek)
                    enabled = existing.enabled
                    message = existing.message ?: ""
                    dailyTarget = existing.dailyTargetPages?.toString() ?: ""
                    bookId = existing.bookId
                }
            }

            val books = bookRepository.observeBooks().first().map { it.id to it.title }
            val bookTitle = bookId?.let { id -> books.firstOrNull { it.first == id }?.second }

            _uiState.update {
                it.copy(
                    isLoading = false,
                    isEditing = reminderIdArg != null,
                    hour = hour,
                    minute = minute,
                    selectedDays = days,
                    enabled = enabled,
                    message = message,
                    dailyTargetPages = dailyTarget,
                    selectedBookId = bookId,
                    selectedBookTitle = bookTitle,
                    availableBooks = books,
                    canScheduleExactAlarms = alarmScheduler.canScheduleExactAlarms()
                )
            }
        }
    }

    fun setTime(hour: Int, minute: Int) = _uiState.update { it.copy(hour = hour, minute = minute) }

    fun toggleDay(day: Int) = _uiState.update {
        val newDays = if (it.selectedDays.contains(day)) it.selectedDays - day else it.selectedDays + day
        it.copy(selectedDays = newDays)
    }

    fun setEnabled(enabled: Boolean) = _uiState.update { it.copy(enabled = enabled) }
    fun setMessage(message: String) = _uiState.update { it.copy(message = message) }
    fun setDailyTargetPages(value: String) = _uiState.update { it.copy(dailyTargetPages = value.filter { c -> c.isDigit() }) }
    fun setSelectedBook(bookId: Long?, title: String?) = _uiState.update { it.copy(selectedBookId = bookId, selectedBookTitle = title) }

    fun save() {
        val state = _uiState.value
        viewModelScope.launch {
            reminderRepository.saveReminder(
                id = reminderIdArg,
                bookId = state.selectedBookId,
                hour = state.hour,
                minute = state.minute,
                daysOfWeek = ReminderScheduleCalculator.formatDaysOfWeek(state.selectedDays),
                enabled = state.enabled,
                message = state.message.ifBlank { null },
                dailyTargetPages = state.dailyTargetPages.toIntOrNull()
            )
            _uiState.update { it.copy(saved = true) }
        }
    }

    fun delete() {
        val id = reminderIdArg ?: return
        viewModelScope.launch {
            reminderRepository.getById(id)?.let { reminderRepository.deleteReminder(it) }
            _uiState.update { it.copy(deleted = true) }
        }
    }
}
