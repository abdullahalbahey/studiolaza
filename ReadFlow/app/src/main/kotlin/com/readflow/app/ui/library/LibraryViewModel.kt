package com.readflow.app.ui.library

import android.net.Uri
import androidx.lifecycle.ViewModel
import androidx.lifecycle.viewModelScope
import com.readflow.app.data.local.datastore.LibraryFilter
import com.readflow.app.data.local.datastore.LibrarySortOrder
import com.readflow.app.data.local.datastore.LibraryViewType
import com.readflow.app.data.local.datastore.SettingsDataStore
import com.readflow.app.data.local.db.entity.BookEntity
import com.readflow.app.data.local.db.entity.BookStatus
import com.readflow.app.data.repository.BookRepository
import com.readflow.app.data.repository.DuplicateResolution
import com.readflow.app.data.repository.ImportOutcome
import com.readflow.app.domain.ProgressCalculator
import dagger.hilt.android.lifecycle.HiltViewModel
import kotlinx.coroutines.flow.MutableStateFlow
import kotlinx.coroutines.flow.SharingStarted
import kotlinx.coroutines.flow.StateFlow
import kotlinx.coroutines.flow.combine
import kotlinx.coroutines.flow.stateIn
import kotlinx.coroutines.flow.update
import kotlinx.coroutines.launch
import javax.inject.Inject

data class BookUiModel(
    val id: Long,
    val title: String,
    val author: String?,
    val coverPath: String?,
    val progressPercent: Float,
    val currentPageDisplay: Int,
    val pageCount: Int,
    val lastOpened: Long?,
    val status: BookStatus
)

data class DuplicatePromptState(val existingBookId: Long, val uri: Uri, val displayName: String?)

data class BatchImportProgress(val done: Int, val total: Int, val currentName: String)
data class BatchImportSummary(val filesPicked: Int, val added: Int, val duplicates: Int, val failed: Int)

data class LibraryUiState(
    val books: List<BookUiModel> = emptyList(),
    val isLoading: Boolean = true,
    val sortOrder: LibrarySortOrder = LibrarySortOrder.RECENTLY_READ,
    val filter: LibraryFilter = LibraryFilter.ALL,
    val viewType: LibraryViewType = LibraryViewType.GRID,
    val searchQuery: String = "",
    val duplicatePrompt: DuplicatePromptState? = null,
    val errorMessage: String? = null,
    val isImporting: Boolean = false,
    val justImportedBookId: Long? = null,
    val batchImportProgress: BatchImportProgress? = null,
    val batchImportSummary: BatchImportSummary? = null
)

@HiltViewModel
class LibraryViewModel @Inject constructor(
    private val bookRepository: BookRepository,
    private val settingsDataStore: SettingsDataStore
) : ViewModel() {

    private val searchQuery = MutableStateFlow("")
    private val transientState = MutableStateFlow(TransientState())

    private data class TransientState(
        val duplicatePrompt: DuplicatePromptState? = null,
        val errorMessage: String? = null,
        val isImporting: Boolean = false,
        val justImportedBookId: Long? = null,
        val batchImportProgress: BatchImportProgress? = null,
        val batchImportSummary: BatchImportSummary? = null
    )

    val uiState: StateFlow<LibraryUiState> = combine(
        bookRepository.observeBooks(),
        settingsDataStore.settings,
        searchQuery,
        transientState
    ) { books, settings, query, transient ->
        val filtered = books
            .filter { matchesFilter(it, settings.libraryFilter) }
            .filter { matchesQuery(it, query) }
        val sorted = sortBooks(filtered, settings.librarySortOrder)
        LibraryUiState(
            books = sorted.map { it.toUiModel() },
            isLoading = false,
            sortOrder = settings.librarySortOrder,
            filter = settings.libraryFilter,
            viewType = settings.libraryViewType,
            searchQuery = query,
            duplicatePrompt = transient.duplicatePrompt,
            errorMessage = transient.errorMessage,
            isImporting = transient.isImporting,
            justImportedBookId = transient.justImportedBookId,
            batchImportProgress = transient.batchImportProgress,
            batchImportSummary = transient.batchImportSummary
        )
    }.stateIn(viewModelScope, SharingStarted.WhileSubscribed(5000), LibraryUiState())

    private fun matchesFilter(book: BookEntity, filter: LibraryFilter): Boolean = when (filter) {
        LibraryFilter.ALL -> true
        LibraryFilter.READING -> book.status == BookStatus.READING.name
        LibraryFilter.COMPLETED -> book.status == BookStatus.COMPLETED.name
        LibraryFilter.NOT_STARTED -> book.status == BookStatus.NOT_STARTED.name
    }

    private fun matchesQuery(book: BookEntity, query: String): Boolean {
        if (query.isBlank()) return true
        return book.title.contains(query, ignoreCase = true) ||
            (book.author?.contains(query, ignoreCase = true) == true)
    }

    private fun sortBooks(books: List<BookEntity>, order: LibrarySortOrder): List<BookEntity> = when (order) {
        LibrarySortOrder.RECENTLY_READ -> books.sortedByDescending { it.lastOpened ?: it.dateAdded }
        LibrarySortOrder.TITLE -> books.sortedBy { it.title.lowercase() }
        LibrarySortOrder.AUTHOR -> books.sortedBy { it.author?.lowercase() ?: "￿" }
        LibrarySortOrder.PROGRESS -> books.sortedByDescending { it.progressPercent }
        LibrarySortOrder.DATE_ADDED -> books.sortedByDescending { it.dateAdded }
    }

    private fun BookEntity.toUiModel() = BookUiModel(
        id = id,
        title = title,
        author = author,
        coverPath = coverPath,
        progressPercent = ProgressCalculator.percentComplete(currentPage, pageCount),
        currentPageDisplay = ProgressCalculator.displayPage(currentPage),
        pageCount = pageCount,
        lastOpened = lastOpened,
        status = runCatching { BookStatus.valueOf(status) }.getOrDefault(BookStatus.NOT_STARTED)
    )

    fun setSearchQuery(query: String) {
        searchQuery.value = query
    }

    fun setSort(order: LibrarySortOrder) {
        viewModelScope.launch { settingsDataStore.setLibrarySortOrder(order) }
    }

    fun setFilter(filter: LibraryFilter) {
        viewModelScope.launch { settingsDataStore.setLibraryFilter(filter) }
    }

    fun setViewType(type: LibraryViewType) {
        viewModelScope.launch { settingsDataStore.setLibraryViewType(type) }
    }

    fun importBook(uri: Uri, displayName: String?) {
        viewModelScope.launch {
            transientState.update { it.copy(isImporting = true, errorMessage = null) }
            val outcome = bookRepository.importBook(uri, displayName)
            applyOutcome(outcome)
        }
    }

    fun resolveDuplicate(resolution: DuplicateResolution) {
        val prompt = transientState.value.duplicatePrompt ?: return
        viewModelScope.launch {
            transientState.update { it.copy(duplicatePrompt = null, isImporting = true) }
            val outcome = bookRepository.resolveDuplicateImport(prompt.uri, prompt.displayName, resolution, prompt.existingBookId)
            applyOutcome(outcome)
        }
    }

    fun dismissDuplicatePrompt() {
        transientState.update { it.copy(duplicatePrompt = null) }
    }

    /**
     * Imports several PDFs picked at once (system file picker, multi-select). Unlike a single
     * [importBook], duplicates here are just counted rather than prompting per-file - popping a
     * modal for every duplicate in a batch of, say, twenty files would be unusable.
     */
    fun importMultipleBooks(uris: List<Uri>, displayNames: List<String?>) {
        if (uris.isEmpty()) return
        viewModelScope.launch {
            transientState.update { it.copy(isImporting = true, errorMessage = null, batchImportProgress = null) }
            var added = 0
            var duplicates = 0
            var failed = 0
            uris.forEachIndexed { index, uri ->
                val name = displayNames.getOrNull(index)
                transientState.update { it.copy(batchImportProgress = BatchImportProgress(index, uris.size, name ?: "")) }
                when (bookRepository.importBook(uri, name)) {
                    is ImportOutcome.Success -> added++
                    is ImportOutcome.Duplicate -> duplicates++
                    is ImportOutcome.Failed -> failed++
                }
            }
            transientState.update {
                it.copy(
                    isImporting = false,
                    batchImportProgress = null,
                    batchImportSummary = BatchImportSummary(uris.size, added, duplicates, failed)
                )
            }
        }
    }

    fun consumeBatchImportSummary() {
        transientState.update { it.copy(batchImportSummary = null) }
    }

    fun consumeError() {
        transientState.update { it.copy(errorMessage = null) }
    }

    fun consumeJustImported() {
        transientState.update { it.copy(justImportedBookId = null) }
    }

    private fun applyOutcome(outcome: ImportOutcome) {
        transientState.update {
            when (outcome) {
                is ImportOutcome.Success -> it.copy(isImporting = false, justImportedBookId = outcome.bookId)
                is ImportOutcome.Duplicate -> it.copy(
                    isImporting = false,
                    duplicatePrompt = DuplicatePromptState(outcome.existingBookId, outcome.pendingUri, outcome.pendingDisplayName)
                )
                is ImportOutcome.Failed -> it.copy(isImporting = false, errorMessage = outcome.message)
            }
        }
    }
}
