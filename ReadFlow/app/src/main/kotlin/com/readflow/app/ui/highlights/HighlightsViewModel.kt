package com.readflow.app.ui.highlights

import androidx.lifecycle.SavedStateHandle
import androidx.lifecycle.ViewModel
import androidx.lifecycle.viewModelScope
import com.readflow.app.data.local.db.entity.HighlightColor
import com.readflow.app.data.local.db.entity.HighlightEntity
import com.readflow.app.data.repository.HighlightRepository
import dagger.hilt.android.lifecycle.HiltViewModel
import kotlinx.coroutines.flow.SharingStarted
import kotlinx.coroutines.flow.StateFlow
import kotlinx.coroutines.flow.stateIn
import kotlinx.coroutines.launch
import javax.inject.Inject

@HiltViewModel
class HighlightsViewModel @Inject constructor(
    savedStateHandle: SavedStateHandle,
    private val highlightRepository: HighlightRepository
) : ViewModel() {
    private val bookId: Long = checkNotNull(savedStateHandle["bookId"])

    val highlights: StateFlow<List<HighlightEntity>> = highlightRepository.observeForBook(bookId)
        .stateIn(viewModelScope, SharingStarted.WhileSubscribed(5000), emptyList())

    fun setColor(highlight: HighlightEntity, color: HighlightColor) {
        viewModelScope.launch { highlightRepository.updateColor(highlight, color) }
    }

    fun delete(highlight: HighlightEntity) {
        viewModelScope.launch { highlightRepository.delete(highlight) }
    }
}
