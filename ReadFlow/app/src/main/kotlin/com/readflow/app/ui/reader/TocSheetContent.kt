package com.readflow.app.ui.reader

import androidx.compose.foundation.clickable
import androidx.compose.foundation.layout.Box
import androidx.compose.foundation.layout.fillMaxWidth
import androidx.compose.foundation.layout.height
import androidx.compose.foundation.layout.padding
import androidx.compose.foundation.lazy.LazyColumn
import androidx.compose.foundation.lazy.items
import androidx.compose.material3.MaterialTheme
import androidx.compose.material3.Text
import androidx.compose.runtime.Composable
import androidx.compose.runtime.getValue
import androidx.compose.ui.Alignment
import androidx.compose.ui.Modifier
import androidx.compose.ui.unit.dp
import androidx.hilt.navigation.compose.hiltViewModel
import androidx.lifecycle.SavedStateHandle
import androidx.lifecycle.ViewModel
import androidx.lifecycle.compose.collectAsStateWithLifecycle
import androidx.lifecycle.viewModelScope
import com.readflow.app.data.local.db.entity.TocEntryEntity
import com.readflow.app.data.repository.BookContentRepository
import dagger.hilt.android.lifecycle.HiltViewModel
import kotlinx.coroutines.flow.SharingStarted
import kotlinx.coroutines.flow.StateFlow
import kotlinx.coroutines.flow.stateIn
import javax.inject.Inject

@HiltViewModel
class TocViewModel @Inject constructor(
    savedStateHandle: SavedStateHandle,
    bookContentRepository: BookContentRepository
) : ViewModel() {
    private val bookId: Long = checkNotNull(savedStateHandle["bookId"])
    val toc: StateFlow<List<TocEntryEntity>> = bookContentRepository.observeToc(bookId)
        .stateIn(viewModelScope, SharingStarted.WhileSubscribed(5000), emptyList())
}

@Composable
fun TocSheetContent(bookId: Long, onJump: (Int) -> Unit, viewModel: TocViewModel = hiltViewModel()) {
    val toc by viewModel.toc.collectAsStateWithLifecycle()

    Box(modifier = Modifier.fillMaxWidth().height(420.dp).padding(16.dp)) {
        if (toc.isEmpty()) {
            Text(
                "No table of contents was found in this PDF.",
                style = MaterialTheme.typography.bodyMedium,
                color = MaterialTheme.colorScheme.onSurfaceVariant,
                modifier = Modifier.align(Alignment.Center)
            )
        } else {
            LazyColumn {
                items(toc, key = { it.id }) { entry ->
                    Text(
                        text = entry.title,
                        style = if (entry.level == 0) MaterialTheme.typography.titleMedium else MaterialTheme.typography.bodyLarge,
                        modifier = Modifier
                            .fillMaxWidth()
                            .clickable { onJump(entry.pageNumber) }
                            .padding(start = (entry.level * 16).dp, top = 10.dp, bottom = 10.dp)
                    )
                }
            }
        }
    }
}
