@file:OptIn(androidx.compose.material3.ExperimentalMaterial3Api::class)

package com.readflow.app.ui.notes

import androidx.compose.foundation.clickable
import androidx.compose.foundation.layout.Box
import androidx.compose.foundation.layout.Column
import androidx.compose.foundation.layout.Row
import androidx.compose.foundation.layout.fillMaxSize
import androidx.compose.foundation.layout.fillMaxWidth
import androidx.compose.foundation.layout.padding
import androidx.compose.foundation.lazy.LazyColumn
import androidx.compose.foundation.lazy.items
import androidx.compose.material.icons.Icons
import androidx.compose.material.icons.automirrored.filled.ArrowBack
import androidx.compose.material.icons.filled.Delete
import androidx.compose.material.icons.filled.Edit
import androidx.compose.material3.AlertDialog
import androidx.compose.material3.Icon
import androidx.compose.material3.IconButton
import androidx.compose.material3.MaterialTheme
import androidx.compose.material3.OutlinedTextField
import androidx.compose.material3.Scaffold
import androidx.compose.material3.Text
import androidx.compose.material3.TextButton
import androidx.compose.material3.TopAppBar
import androidx.compose.runtime.Composable
import androidx.compose.runtime.getValue
import androidx.compose.runtime.mutableStateOf
import androidx.compose.runtime.remember
import androidx.compose.runtime.setValue
import androidx.compose.ui.Alignment
import androidx.compose.ui.Modifier
import androidx.compose.ui.text.style.TextOverflow
import androidx.compose.ui.unit.dp
import androidx.hilt.navigation.compose.hiltViewModel
import androidx.lifecycle.compose.collectAsStateWithLifecycle
import com.readflow.app.data.local.db.entity.NoteEntity
import com.readflow.app.ui.common.formatDate

@Composable
fun NotesScreen(
    bookId: Long,
    onBack: () -> Unit,
    onJumpToPage: (Int) -> Unit,
    viewModel: NotesViewModel = hiltViewModel()
) {
    val notes by viewModel.notes.collectAsStateWithLifecycle()
    var editingNote by remember { mutableStateOf<NoteEntity?>(null) }

    Scaffold(
        topBar = {
            TopAppBar(
                title = { Text("Notes") },
                navigationIcon = { IconButton(onClick = onBack) { Icon(Icons.AutoMirrored.Filled.ArrowBack, contentDescription = "Back") } }
            )
        }
    ) { padding ->
        if (notes.isEmpty()) {
            Box(Modifier.fillMaxSize().padding(padding), contentAlignment = Alignment.Center) {
                Text("No notes yet. Add one from the reader.", color = MaterialTheme.colorScheme.onSurfaceVariant)
            }
        } else {
            LazyColumn(modifier = Modifier.fillMaxSize().padding(padding)) {
                items(notes, key = { it.id }) { note ->
                    Column(
                        modifier = Modifier
                            .fillMaxWidth()
                            .clickable { onJumpToPage(note.pageNumber) }
                            .padding(horizontal = 20.dp, vertical = 12.dp)
                    ) {
                        Row(modifier = Modifier.fillMaxWidth()) {
                            Column(modifier = Modifier.weight(1f)) {
                                Text("Page ${note.pageNumber + 1} · ${formatDate(note.createdAt)}", style = MaterialTheme.typography.bodyMedium, color = MaterialTheme.colorScheme.onSurfaceVariant)
                                if (!note.selectedText.isNullOrBlank()) {
                                    Text("\"${note.selectedText}\"", style = MaterialTheme.typography.bodyMedium, maxLines = 2, overflow = TextOverflow.Ellipsis, modifier = Modifier.padding(top = 4.dp))
                                }
                                Text(note.noteText, style = MaterialTheme.typography.titleMedium, modifier = Modifier.padding(top = 4.dp))
                            }
                            IconButton(onClick = { editingNote = note }) { Icon(Icons.Filled.Edit, contentDescription = "Edit note") }
                            IconButton(onClick = { viewModel.deleteNote(note) }) { Icon(Icons.Filled.Delete, contentDescription = "Delete note") }
                        }
                    }
                }
            }
        }
    }

    editingNote?.let { note ->
        var text by remember(note.id) { mutableStateOf(note.noteText) }
        AlertDialog(
            onDismissRequest = { editingNote = null },
            title = { Text("Edit note") },
            text = {
                OutlinedTextField(value = text, onValueChange = { text = it }, minLines = 3)
            },
            confirmButton = {
                TextButton(onClick = {
                    viewModel.updateNote(note, text)
                    editingNote = null
                }) { Text("Save") }
            },
            dismissButton = { TextButton(onClick = { editingNote = null }) { Text("Cancel") } }
        )
    }
}
