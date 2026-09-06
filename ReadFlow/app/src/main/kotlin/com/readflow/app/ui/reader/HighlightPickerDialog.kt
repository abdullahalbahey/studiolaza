package com.readflow.app.ui.reader

import androidx.compose.foundation.background
import androidx.compose.foundation.border
import androidx.compose.foundation.clickable
import androidx.compose.foundation.layout.Arrangement
import androidx.compose.foundation.layout.Column
import androidx.compose.foundation.layout.Row
import androidx.compose.foundation.layout.fillMaxWidth
import androidx.compose.foundation.layout.padding
import androidx.compose.foundation.layout.size
import androidx.compose.foundation.shape.CircleShape
import androidx.compose.material3.AlertDialog
import androidx.compose.material3.MaterialTheme
import androidx.compose.material3.OutlinedTextField
import androidx.compose.material3.Text
import androidx.compose.material3.TextButton
import androidx.compose.runtime.Composable
import androidx.compose.runtime.getValue
import androidx.compose.runtime.mutableStateOf
import androidx.compose.runtime.remember
import androidx.compose.runtime.setValue
import androidx.compose.ui.Modifier
import androidx.compose.ui.draw.clip
import androidx.compose.ui.graphics.Color
import androidx.compose.ui.text.style.TextOverflow
import androidx.compose.ui.unit.dp
import androidx.hilt.navigation.compose.hiltViewModel
import androidx.lifecycle.ViewModel
import androidx.lifecycle.viewModelScope
import com.readflow.app.data.local.db.entity.HighlightColor
import com.readflow.app.data.repository.HighlightRepository
import com.readflow.app.data.repository.NoteRepository
import dagger.hilt.android.lifecycle.HiltViewModel
import kotlinx.coroutines.launch
import javax.inject.Inject

@HiltViewModel
class HighlightActionsViewModel @Inject constructor(
    private val highlightRepository: HighlightRepository,
    private val noteRepository: NoteRepository
) : ViewModel() {
    fun saveHighlight(bookId: Long, pageNumber: Int, text: String, color: HighlightColor, noteText: String?) {
        viewModelScope.launch {
            val highlightId = highlightRepository.addHighlight(bookId, pageNumber, text, color)
            if (!noteText.isNullOrBlank()) {
                val noteId = noteRepository.addNote(bookId, pageNumber, text, noteText)
                // Best-effort link back; failure to link still leaves both records intact.
                runCatching {
                    highlightRepository.attachNote(
                        com.readflow.app.data.local.db.entity.HighlightEntity(
                            id = highlightId, bookId = bookId, pageNumber = pageNumber,
                            selectedText = text, color = color.name, createdAt = System.currentTimeMillis()
                        ),
                        noteId
                    )
                }
            }
        }
    }
}

private fun HighlightColor.toColor(): Color = when (this) {
    HighlightColor.YELLOW -> Color(0xFFFFE066)
    HighlightColor.GREEN -> Color(0xFFA6E3A1)
    HighlightColor.BLUE -> Color(0xFFA0C4FF)
    HighlightColor.PINK -> Color(0xFFFFADC6)
    HighlightColor.ORANGE -> Color(0xFFFFB870)
}

@Composable
fun HighlightPickerDialog(
    bookId: Long,
    pageNumber: Int,
    text: String,
    onDismiss: () -> Unit,
    viewModel: HighlightActionsViewModel = hiltViewModel()
) {
    var selectedColor by remember { mutableStateOf(HighlightColor.YELLOW) }
    var noteText by remember { mutableStateOf("") }

    AlertDialog(
        onDismissRequest = onDismiss,
        title = { Text("Highlight this paragraph") },
        text = {
            Column {
                Text(text, maxLines = 4, overflow = TextOverflow.Ellipsis, style = MaterialTheme.typography.bodyMedium)
                Row(modifier = Modifier.fillMaxWidth().padding(top = 12.dp), horizontalArrangement = Arrangement.spacedBy(10.dp)) {
                    HighlightColor.entries.forEach { color ->
                        androidx.compose.foundation.layout.Box(
                            modifier = Modifier
                                .size(32.dp)
                                .clip(CircleShape)
                                .background(color.toColor())
                                .border(
                                    width = if (selectedColor == color) 3.dp else 1.dp,
                                    color = MaterialTheme.colorScheme.outline,
                                    shape = CircleShape
                                )
                                .clickable { selectedColor = color }
                        )
                    }
                }
                OutlinedTextField(
                    value = noteText,
                    onValueChange = { noteText = it },
                    label = { Text("Add a note (optional)") },
                    modifier = Modifier.fillMaxWidth().padding(top = 12.dp),
                    minLines = 2
                )
            }
        },
        confirmButton = {
            TextButton(onClick = {
                viewModel.saveHighlight(bookId, pageNumber, text, selectedColor, noteText.ifBlank { null })
                onDismiss()
            }) { Text("Save highlight") }
        },
        dismissButton = { TextButton(onClick = onDismiss) { Text("Cancel") } }
    )
}
