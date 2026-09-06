package com.readflow.app.ui.reader

import androidx.compose.foundation.clickable
import androidx.compose.foundation.layout.Box
import androidx.compose.foundation.layout.Column
import androidx.compose.foundation.layout.fillMaxWidth
import androidx.compose.foundation.layout.height
import androidx.compose.foundation.layout.padding
import androidx.compose.foundation.lazy.LazyColumn
import androidx.compose.foundation.lazy.items
import androidx.compose.material3.CircularProgressIndicator
import androidx.compose.material3.Icon
import androidx.compose.material3.MaterialTheme
import androidx.compose.material3.OutlinedTextField
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
import com.readflow.app.data.repository.BookContentRepository
import com.readflow.app.data.repository.SearchResult
import dagger.hilt.android.lifecycle.HiltViewModel
import kotlinx.coroutines.Job
import kotlinx.coroutines.delay
import kotlinx.coroutines.flow.MutableStateFlow
import kotlinx.coroutines.flow.StateFlow
import kotlinx.coroutines.flow.asStateFlow
import kotlinx.coroutines.launch
import javax.inject.Inject

@HiltViewModel
class SearchViewModel @Inject constructor(
    savedStateHandle: SavedStateHandle,
    private val bookContentRepository: BookContentRepository
) : ViewModel() {
    private val bookId: Long = checkNotNull(savedStateHandle["bookId"])

    private val _query = MutableStateFlow("")
    val query: StateFlow<String> = _query.asStateFlow()

    private val _results = MutableStateFlow<List<SearchResult>>(emptyList())
    val results: StateFlow<List<SearchResult>> = _results.asStateFlow()

    private val _isSearching = MutableStateFlow(false)
    val isSearching: StateFlow<Boolean> = _isSearching.asStateFlow()

    private var searchJob: Job? = null

    fun setQuery(text: String, filePath: String) {
        _query.value = text
        searchJob?.cancel()
        if (text.isBlank()) {
            _results.value = emptyList()
            return
        }
        searchJob = viewModelScope.launch {
            delay(350)
            _isSearching.value = true
            _results.value = bookContentRepository.search(bookId, filePath, text)
            _isSearching.value = false
        }
    }
}

@Composable
fun SearchSheetContent(
    bookId: Long,
    filePath: String,
    hasExtractableText: Boolean,
    onJump: (Int) -> Unit,
    viewModel: SearchViewModel = hiltViewModel()
) {
    val query by viewModel.query.collectAsStateWithLifecycle()
    val results by viewModel.results.collectAsStateWithLifecycle()
    val isSearching by viewModel.isSearching.collectAsStateWithLifecycle()

    Column(modifier = Modifier.fillMaxWidth().height(460.dp).padding(16.dp)) {
        if (!hasExtractableText) {
            Text(
                "Search isn't available for this book. It doesn't have extractable text, likely because it's a scanned PDF.",
                style = MaterialTheme.typography.bodyMedium,
                color = MaterialTheme.colorScheme.onSurfaceVariant
            )
            return@Column
        }

        OutlinedTextField(
            value = query,
            onValueChange = { viewModel.setQuery(it, filePath) },
            modifier = Modifier.fillMaxWidth(),
            placeholder = { Text("Search in this book") },
            singleLine = true,
            trailingIcon = { if (isSearching) CircularProgressIndicator(modifier = Modifier.padding(4.dp)) }
        )

        Box(modifier = Modifier.fillMaxWidth().padding(top = 8.dp)) {
            when {
                query.isBlank() -> Text(
                    "Type to search this book's text.",
                    style = MaterialTheme.typography.bodyMedium,
                    color = MaterialTheme.colorScheme.onSurfaceVariant
                )
                !isSearching && results.isEmpty() -> Text(
                    "No matches for \"$query\".",
                    style = MaterialTheme.typography.bodyMedium,
                    color = MaterialTheme.colorScheme.onSurfaceVariant
                )
                else -> LazyColumn {
                    items(results, key = { it.pageNumber }) { result ->
                        Column(
                            modifier = Modifier
                                .fillMaxWidth()
                                .clickable { onJump(result.pageNumber) }
                                .padding(vertical = 10.dp)
                        ) {
                            Text("Page ${result.pageNumber + 1}", style = MaterialTheme.typography.titleMedium)
                            Text(result.snippet, style = MaterialTheme.typography.bodyMedium, color = MaterialTheme.colorScheme.onSurfaceVariant)
                        }
                    }
                }
            }
        }
    }
}
