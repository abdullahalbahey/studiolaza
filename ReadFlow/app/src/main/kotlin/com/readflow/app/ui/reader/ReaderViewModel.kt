package com.readflow.app.ui.reader

import android.graphics.Bitmap
import androidx.compose.runtime.mutableStateMapOf
import androidx.lifecycle.SavedStateHandle
import androidx.lifecycle.ViewModel
import androidx.lifecycle.viewModelScope
import com.readflow.app.data.local.datastore.ReaderFontFamilyOption
import com.readflow.app.data.local.datastore.ReadingThemeMode
import com.readflow.app.data.local.datastore.SettingsDataStore
import com.readflow.app.data.local.db.entity.ReaderViewMode
import com.readflow.app.data.pdf.PdfException
import com.readflow.app.data.pdf.PdfPageRenderer
import com.readflow.app.data.repository.BookContentRepository
import com.readflow.app.data.repository.BookRepository
import com.readflow.app.data.repository.BookmarkRepository
import com.readflow.app.data.repository.ReadingSessionRepository
import com.readflow.app.di.ApplicationScope
import dagger.hilt.android.lifecycle.HiltViewModel
import kotlinx.coroutines.CoroutineScope
import kotlinx.coroutines.Dispatchers
import kotlinx.coroutines.flow.MutableStateFlow
import kotlinx.coroutines.flow.StateFlow
import kotlinx.coroutines.flow.asStateFlow
import kotlinx.coroutines.flow.update
import kotlinx.coroutines.launch
import javax.inject.Inject
import kotlin.math.abs

data class ReaderUiState(
    val isLoading: Boolean = true,
    val error: String? = null,
    val bookId: Long = 0,
    val filePath: String = "",
    val title: String = "",
    val pageCount: Int = 0,
    val currentPage: Int = 0,
    val viewMode: ReaderViewMode = ReaderViewMode.PAGE,
    val readingModeAvailable: Boolean = false,
    val readingModeEnabled: Boolean = false,
    val fitWholePage: Boolean = false,
    val controlsVisible: Boolean = true,
    val isBookmarked: Boolean = false,
    val readingTheme: ReadingThemeMode = ReadingThemeMode.LIGHT,
    val fontSizeSp: Float = 18f,
    val lineSpacingMultiplier: Float = 1.4f,
    val paragraphSpacingSp: Float = 12f,
    val fontFamily: ReaderFontFamilyOption = ReaderFontFamilyOption.DEFAULT,
    val readingWidthFraction: Float = 0.92f,
    val keepScreenAwake: Boolean = true
)

@HiltViewModel
class ReaderViewModel @Inject constructor(
    savedStateHandle: SavedStateHandle,
    private val bookRepository: BookRepository,
    private val bookContentRepository: BookContentRepository,
    private val bookmarkRepository: BookmarkRepository,
    private val sessionRepository: ReadingSessionRepository,
    settingsDataStore: SettingsDataStore,
    @ApplicationScope private val appScope: CoroutineScope
) : ViewModel() {

    private val bookId: Long = checkNotNull(savedStateHandle["bookId"])
    private val requestedStartPage: Int? = (savedStateHandle.get<Int>("startPage"))?.takeIf { it >= 0 }

    private val _uiState = MutableStateFlow(ReaderUiState(bookId = bookId))
    val uiState: StateFlow<ReaderUiState> = _uiState.asStateFlow()

    val pageBitmaps = mutableStateMapOf<Int, Bitmap>()
    val pageTexts = mutableStateMapOf<Int, String?>()

    private var renderer: PdfPageRenderer? = null
    private val loadingPages = mutableSetOf<Int>()
    private var sessionStartTime = System.currentTimeMillis()
    private var sessionStartPage = 0
    private var sessionSaved = false

    init {
        viewModelScope.launch {
            val book = bookRepository.getBook(bookId)
            if (book == null) {
                _uiState.update { it.copy(isLoading = false, error = "This book could not be found. It may have been removed.") }
                return@launch
            }
            val startPage = (requestedStartPage ?: book.currentPage).coerceIn(0, (book.pageCount - 1).coerceAtLeast(0))
            sessionStartPage = startPage
            _uiState.update {
                it.copy(
                    isLoading = false,
                    filePath = book.filePath,
                    title = book.title,
                    pageCount = book.pageCount,
                    currentPage = startPage,
                    viewMode = runCatching { ReaderViewMode.valueOf(book.viewMode) }.getOrDefault(ReaderViewMode.PAGE),
                    readingModeAvailable = book.hasExtractableText,
                    readingModeEnabled = book.readingModeEnabled && book.hasExtractableText
                )
            }
            bookRepository.markOpened(bookId)
            refreshBookmarkState(startPage)
            openRenderer(book.filePath)
        }
        viewModelScope.launch {
            settingsDataStore.settings.collect { s ->
                _uiState.update {
                    it.copy(
                        readingTheme = s.readingTheme,
                        fontSizeSp = s.fontSizeSp,
                        lineSpacingMultiplier = s.lineSpacingMultiplier,
                        paragraphSpacingSp = s.paragraphSpacingSp,
                        fontFamily = s.readerFontFamily,
                        readingWidthFraction = s.readingWidthFraction,
                        keepScreenAwake = s.keepScreenAwake
                    )
                }
            }
        }
    }

    private suspend fun openRenderer(filePath: String) {
        try {
            val r = PdfPageRenderer(filePath)
            r.open()
            renderer = r
        } catch (e: PdfException) {
            _uiState.update { it.copy(error = e.message) }
        } catch (e: Throwable) {
            _uiState.update { it.copy(error = "This PDF could not be opened.") }
        }
    }

    fun requestPageBitmap(index: Int, targetWidthPx: Int) {
        if (index < 0 || index >= _uiState.value.pageCount) return
        if (pageBitmaps.containsKey(index) || loadingPages.contains(index)) return
        val r = renderer ?: return
        loadingPages += index
        viewModelScope.launch(Dispatchers.Default) {
            try {
                val bitmap = r.renderPage(index, targetWidthPx)
                trimBitmapCache(index)
                pageBitmaps[index] = bitmap
            } catch (e: Throwable) {
                // Leave this page's slot empty; the UI shows a lightweight error placeholder.
                // Catching Throwable (not just Exception) matters here: a huge or malformed page
                // can make Bitmap.createBitmap throw OutOfMemoryError, which must not crash the app.
            } finally {
                loadingPages -= index
            }
        }
    }

    private fun trimBitmapCache(aroundIndex: Int) {
        val maxCached = 8
        if (pageBitmaps.size < maxCached) return
        val farthest = pageBitmaps.keys.maxByOrNull { abs(it - aroundIndex) } ?: return
        if (abs(farthest - aroundIndex) > 2) {
            pageBitmaps.remove(farthest)?.recycle()
        }
    }

    fun requestPageText(index: Int) {
        if (index < 0 || index >= _uiState.value.pageCount) return
        if (pageTexts.containsKey(index)) return
        pageTexts[index] = null
        viewModelScope.launch {
            val text = bookContentRepository.getPageText(bookId, _uiState.value.filePath, index)
            pageTexts[index] = text ?: ""
        }
    }

    fun onPageChanged(newPage: Int) {
        if (newPage == _uiState.value.currentPage) return
        _uiState.update { it.copy(currentPage = newPage) }
        appScope.launch { bookRepository.updateProgress(bookId, newPage) }
        viewModelScope.launch { refreshBookmarkState(newPage) }
    }

    fun jumpToPage(page: Int) {
        val clamped = page.coerceIn(0, (_uiState.value.pageCount - 1).coerceAtLeast(0))
        onPageChanged(clamped)
    }

    fun toggleControls() {
        _uiState.update { it.copy(controlsVisible = !it.controlsVisible) }
    }

    fun setControlsVisible(visible: Boolean) {
        _uiState.update { it.copy(controlsVisible = visible) }
    }

    fun setViewMode(mode: ReaderViewMode) {
        _uiState.update { it.copy(viewMode = mode) }
        appScope.launch { bookRepository.setViewMode(bookId, mode.name) }
    }

    fun setFitWholePage(fit: Boolean) {
        _uiState.update { it.copy(fitWholePage = fit) }
    }

    fun setReadingModeEnabled(enabled: Boolean) {
        _uiState.update { it.copy(readingModeEnabled = enabled && it.readingModeAvailable) }
        appScope.launch { bookRepository.setReadingModeEnabled(bookId, enabled) }
    }

    fun toggleBookmark() {
        viewModelScope.launch {
            val added = bookmarkRepository.toggleBookmark(bookId, _uiState.value.currentPage, null)
            _uiState.update { it.copy(isBookmarked = added) }
        }
    }

    private suspend fun refreshBookmarkState(page: Int) {
        val bookmarked = bookmarkRepository.isBookmarked(bookId, page)
        _uiState.update { it.copy(isBookmarked = bookmarked) }
    }

    /** Called when the reader leaves the foreground (paused, backgrounded, or closed) so progress
     * and time-on-book are never lost, even if the process is later killed. */
    fun saveSessionAndProgress() {
        if (sessionSaved) return
        sessionSaved = true
        val state = _uiState.value
        val start = sessionStartTime
        val end = System.currentTimeMillis()
        val startPage = sessionStartPage
        val endPage = state.currentPage
        appScope.launch {
            bookRepository.updateProgress(bookId, endPage)
            sessionRepository.recordSession(bookId, start, end, startPage, endPage)
            bookRepository.addReadingTime(bookId, end - start)
        }
    }

    /** Call when the reader returns to the foreground after [saveSessionAndProgress], to start a fresh session. */
    fun resumeSession() {
        sessionSaved = false
        sessionStartTime = System.currentTimeMillis()
        sessionStartPage = _uiState.value.currentPage
    }

    override fun onCleared() {
        saveSessionAndProgress()
        renderer?.close()
        pageBitmaps.values.forEach { it.recycle() }
        pageBitmaps.clear()
        super.onCleared()
    }
}
