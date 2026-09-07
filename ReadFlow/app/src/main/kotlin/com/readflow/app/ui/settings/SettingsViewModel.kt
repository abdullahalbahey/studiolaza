package com.readflow.app.ui.settings

import androidx.lifecycle.ViewModel
import androidx.lifecycle.viewModelScope
import com.readflow.app.data.backup.BackupManager
import com.readflow.app.data.backup.ImportSummary
import com.readflow.app.data.local.datastore.AppSettings
import com.readflow.app.data.local.datastore.AppThemeMode
import com.readflow.app.data.local.datastore.DefaultReadingModeOption
import com.readflow.app.data.local.datastore.LibrarySortOrder
import com.readflow.app.data.local.datastore.LibraryViewType
import com.readflow.app.data.local.datastore.SettingsDataStore
import com.readflow.app.data.local.db.entity.ReminderEntity
import com.readflow.app.data.repository.BookRepository
import com.readflow.app.data.repository.ReminderRepository
import dagger.hilt.android.lifecycle.HiltViewModel
import kotlinx.coroutines.flow.MutableStateFlow
import kotlinx.coroutines.flow.SharingStarted
import kotlinx.coroutines.flow.StateFlow
import kotlinx.coroutines.flow.combine
import kotlinx.coroutines.flow.stateIn
import kotlinx.coroutines.launch
import javax.inject.Inject

data class SettingsUiState(
    val settings: AppSettings = AppSettings(),
    val reminders: List<ReminderEntity> = emptyList(),
    val exportedJson: String? = null,
    val importSummary: ImportSummary? = null,
    val statusMessage: String? = null
)

@HiltViewModel
class SettingsViewModel @Inject constructor(
    private val settingsDataStore: SettingsDataStore,
    private val reminderRepository: ReminderRepository,
    private val bookRepository: BookRepository,
    private val backupManager: BackupManager
) : ViewModel() {

    private val transient = MutableStateFlow(Pair<String?, ImportSummary?>(null, null))
    private val status = MutableStateFlow<String?>(null)

    val uiState: StateFlow<SettingsUiState> = combine(
        settingsDataStore.settings,
        reminderRepository.observeAll(),
        transient,
        status
    ) { settings, reminders, (exported, summary), statusMessage ->
        SettingsUiState(settings, reminders, exported, summary, statusMessage)
    }.stateIn(viewModelScope, SharingStarted.WhileSubscribed(5000), SettingsUiState())

    fun setAppTheme(mode: AppThemeMode) = viewModelScope.launch { settingsDataStore.setAppThemeMode(mode) }
    fun setDefaultReadingMode(mode: DefaultReadingModeOption) = viewModelScope.launch { settingsDataStore.setDefaultReadingMode(mode) }
    fun setPageAnimation(enabled: Boolean) = viewModelScope.launch { settingsDataStore.setPageAnimationEnabled(enabled) }
    fun setKeepScreenAwake(enabled: Boolean) = viewModelScope.launch { settingsDataStore.setKeepScreenAwake(enabled) }
    fun setRemindersEnabled(enabled: Boolean) = viewModelScope.launch { settingsDataStore.setRemindersEnabled(enabled) }
    fun setDefaultReminderTime(hour: Int, minute: Int) = viewModelScope.launch { settingsDataStore.setDefaultReminderTime(hour, minute) }
    fun setLibrarySortOrder(order: LibrarySortOrder) = viewModelScope.launch { settingsDataStore.setLibrarySortOrder(order) }
    fun setLibraryViewType(type: LibraryViewType) = viewModelScope.launch { settingsDataStore.setLibraryViewType(type) }
    fun setDriveApiKey(key: String?) = viewModelScope.launch { settingsDataStore.setDriveApiKey(key) }

    fun toggleReminder(reminder: ReminderEntity, enabled: Boolean) = viewModelScope.launch {
        reminderRepository.setEnabled(reminder, enabled)
    }

    fun deleteReminder(reminder: ReminderEntity) = viewModelScope.launch {
        reminderRepository.deleteReminder(reminder)
    }

    fun exportData() {
        viewModelScope.launch {
            val json = backupManager.export()
            transient.value = json to transient.value.second
        }
    }

    fun consumeExportedJson() {
        transient.value = null to transient.value.second
    }

    fun importData(json: String) {
        viewModelScope.launch {
            val summary = backupManager.import(json)
            transient.value = transient.value.first to summary
        }
    }

    fun consumeImportSummary() {
        transient.value = transient.value.first to null
    }

    fun deleteAllBooks() {
        viewModelScope.launch {
            bookRepository.deleteAllBooks()
            status.value = "All books removed."
        }
    }

    fun consumeStatusMessage() {
        status.value = null
    }
}
