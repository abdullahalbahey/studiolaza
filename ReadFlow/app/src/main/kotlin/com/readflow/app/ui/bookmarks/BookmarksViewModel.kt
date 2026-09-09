package com.readflow.app.ui.bookmarks

import androidx.lifecycle.SavedStateHandle
import androidx.lifecycle.ViewModel
import androidx.lifecycle.viewModelScope
import com.readflow.app.data.local.db.entity.BookmarkEntity
import com.readflow.app.data.repository.BookmarkRepository
import dagger.hilt.android.lifecycle.HiltViewModel
import kotlinx.coroutines.flow.SharingStarted
import kotlinx.coroutines.flow.StateFlow
import kotlinx.coroutines.flow.stateIn
import kotlinx.coroutines.launch
import javax.inject.Inject

@HiltViewModel
class BookmarksViewModel @Inject constructor(
    savedStateHandle: SavedStateHandle,
    private val bookmarkRepository: BookmarkRepository
) : ViewModel() {
    private val bookId: Long = checkNotNull(savedStateHandle["bookId"])

    val bookmarks: StateFlow<List<BookmarkEntity>> = bookmarkRepository.observeForBook(bookId)
        .stateIn(viewModelScope, SharingStarted.WhileSubscribed(5000), emptyList())

    fun delete(bookmark: BookmarkEntity) {
        viewModelScope.launch { bookmarkRepository.delete(bookmark) }
    }
}
