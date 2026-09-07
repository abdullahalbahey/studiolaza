@file:OptIn(androidx.compose.material3.ExperimentalMaterial3Api::class)

package com.readflow.app.ui.bookdetails

import androidx.compose.foundation.layout.Arrangement
import androidx.compose.foundation.layout.Column
import androidx.compose.foundation.layout.Row
import androidx.compose.foundation.layout.fillMaxSize
import androidx.compose.foundation.layout.fillMaxWidth
import androidx.compose.foundation.layout.height
import androidx.compose.foundation.layout.padding
import androidx.compose.foundation.layout.size
import androidx.compose.foundation.layout.width
import androidx.compose.foundation.lazy.grid.GridCells
import androidx.compose.foundation.lazy.grid.LazyVerticalGrid
import androidx.compose.foundation.lazy.grid.items
import androidx.compose.foundation.rememberScrollState
import androidx.compose.foundation.verticalScroll
import androidx.compose.material.icons.Icons
import androidx.compose.material.icons.automirrored.filled.ArrowBack
import androidx.compose.material.icons.automirrored.filled.MenuBook
import androidx.compose.material.icons.filled.Alarm
import androidx.compose.material.icons.filled.Bookmark
import androidx.compose.material.icons.filled.Delete
import androidx.compose.material.icons.filled.Edit
import androidx.compose.material.icons.filled.Flag
import androidx.compose.material.icons.filled.Highlight
import androidx.compose.material.icons.filled.InsertDriveFile
import androidx.compose.material.icons.filled.MoreVert
import androidx.compose.material.icons.filled.QueryStats
import androidx.compose.material3.AlertDialog
import androidx.compose.material3.Button
import androidx.compose.material3.CircularProgressIndicator
import androidx.compose.material3.DropdownMenu
import androidx.compose.material3.DropdownMenuItem
import androidx.compose.material3.Icon
import androidx.compose.material3.IconButton
import androidx.compose.material3.LinearProgressIndicator
import androidx.compose.material3.MaterialTheme
import androidx.compose.material3.OutlinedButton
import androidx.compose.material3.Scaffold
import androidx.compose.material3.Text
import androidx.compose.material3.TextButton
import androidx.compose.material3.TopAppBar
import androidx.compose.runtime.Composable
import androidx.compose.runtime.LaunchedEffect
import androidx.compose.runtime.getValue
import androidx.compose.runtime.mutableStateOf
import androidx.compose.runtime.remember
import androidx.compose.runtime.setValue
import androidx.compose.ui.Alignment
import androidx.compose.ui.Modifier
import androidx.compose.ui.unit.dp
import androidx.hilt.navigation.compose.hiltViewModel
import androidx.lifecycle.compose.collectAsStateWithLifecycle
import com.readflow.app.ui.common.formatDate
import com.readflow.app.ui.common.formatDuration
import com.readflow.app.ui.library.BookCoverImage

@Composable
fun BookDetailsScreen(
    bookId: Long,
    onBack: () -> Unit,
    onOpenReader: (Int?) -> Unit,
    onOpenBookmarks: () -> Unit,
    onOpenNotes: () -> Unit,
    onOpenHighlights: () -> Unit,
    onOpenStats: () -> Unit,
    onOpenGoal: () -> Unit,
    onOpenReminder: () -> Unit,
    onDeleted: () -> Unit,
    viewModel: BookDetailsViewModel = hiltViewModel()
) {
    val state by viewModel.uiState.collectAsStateWithLifecycle()
    var showMenu by remember { mutableStateOf(false) }
    var showDeleteConfirm by remember { mutableStateOf(false) }

    LaunchedEffect(state.deleted) {
        if (state.deleted) onDeleted()
    }

    Scaffold(
        topBar = {
            TopAppBar(
                title = { Text(if (state.isLoading) "" else state.title, maxLines = 1) },
                navigationIcon = {
                    IconButton(onClick = onBack) {
                        Icon(Icons.AutoMirrored.Filled.ArrowBack, contentDescription = "Back")
                    }
                },
                actions = {
                    IconButton(onClick = { showMenu = true }) {
                        Icon(Icons.Filled.MoreVert, contentDescription = "More")
                    }
                    DropdownMenu(expanded = showMenu, onDismissRequest = { showMenu = false }) {
                        DropdownMenuItem(
                            text = { Text(if (state.readingModeEnabled) "Switch to Original PDF" else "Switch to Reading Mode") },
                            enabled = state.hasExtractableText,
                            onClick = {
                                viewModel.setReadingModeEnabled(!state.readingModeEnabled)
                                showMenu = false
                            }
                        )
                        DropdownMenuItem(
                            text = { Text("Remove from library") },
                            leadingIcon = { Icon(Icons.Filled.Delete, contentDescription = null) },
                            onClick = { showMenu = false; showDeleteConfirm = true }
                        )
                    }
                }
            )
        }
    ) { padding ->
        if (state.isLoading) {
            Column(
                modifier = Modifier.fillMaxSize().padding(padding),
                horizontalAlignment = Alignment.CenterHorizontally,
                verticalArrangement = Arrangement.Center
            ) {
                CircularProgressIndicator()
            }
            return@Scaffold
        }

        Column(
            modifier = Modifier
                .fillMaxSize()
                .padding(padding)
                .verticalScroll(rememberScrollState())
                .padding(20.dp)
        ) {
            Row {
                BookCoverImage(coverPath = state.coverPath, modifier = Modifier.width(120.dp).height(168.dp))
                Column(modifier = Modifier.padding(start = 16.dp)) {
                    Text(state.title, style = MaterialTheme.typography.titleLarge)
                    val author = state.author
                    if (author != null) {
                        Text(author, style = MaterialTheme.typography.bodyLarge, color = MaterialTheme.colorScheme.onSurfaceVariant)
                    }
                    Text(
                        "${state.pageCount} pages",
                        style = MaterialTheme.typography.bodyMedium,
                        color = MaterialTheme.colorScheme.onSurfaceVariant,
                        modifier = Modifier.padding(top = 4.dp)
                    )
                    Text(
                        "Reading time: ${formatDuration(state.totalReadingTimeMillis)}",
                        style = MaterialTheme.typography.bodyMedium,
                        color = MaterialTheme.colorScheme.onSurfaceVariant
                    )
                }
            }

            Column(modifier = Modifier.padding(top = 20.dp)) {
                Row(modifier = Modifier.fillMaxWidth(), horizontalArrangement = Arrangement.SpaceBetween) {
                    Text("Progress", style = MaterialTheme.typography.titleMedium)
                    Text("${(state.progressPercent * 100).toInt()}%", style = MaterialTheme.typography.titleMedium)
                }
                LinearProgressIndicator(
                    progress = { state.progressPercent },
                    modifier = Modifier.fillMaxWidth().padding(top = 6.dp).height(8.dp)
                )
                Text(
                    "Page ${state.currentPageDisplay} of ${state.pageCount}",
                    style = MaterialTheme.typography.bodyMedium,
                    color = MaterialTheme.colorScheme.onSurfaceVariant,
                    modifier = Modifier.padding(top = 4.dp)
                )
            }

            if (state.goalPagesPerDay != null) {
                Column(modifier = Modifier.padding(top = 16.dp)) {
                    Text("Goal: ${state.goalPagesPerDay} pages/day", style = MaterialTheme.typography.titleMedium)
                    Text(
                        "Current: ${state.goalPagesReadToday} pages today" + if (!state.goalOnTrackToday) " · behind today's goal" else "",
                        style = MaterialTheme.typography.bodyMedium,
                        color = MaterialTheme.colorScheme.onSurfaceVariant
                    )
                    Text(
                        "Remaining: ${state.goalRemainingPages} pages",
                        style = MaterialTheme.typography.bodyMedium,
                        color = MaterialTheme.colorScheme.onSurfaceVariant
                    )
                    state.goalEstimatedCompletionMillis?.let {
                        Text(
                            "Estimated completion: ${formatDate(it)}",
                            style = MaterialTheme.typography.bodyMedium,
                            color = MaterialTheme.colorScheme.onSurfaceVariant
                        )
                    }
                }
            }

            Button(
                onClick = { onOpenReader(null) },
                modifier = Modifier.fillMaxWidth().padding(top = 20.dp)
            ) {
                Text(if (state.currentPageDisplay > 1) "Continue Reading" else "Start Reading")
            }

            val actions = listOf(
                DetailAction("Bookmarks", Icons.Filled.Bookmark, onOpenBookmarks),
                DetailAction("Notes", Icons.Filled.Edit, onOpenNotes),
                DetailAction("Highlights", Icons.Filled.Highlight, onOpenHighlights),
                DetailAction("Reading Stats", Icons.Filled.QueryStats, onOpenStats),
                DetailAction("Goal", Icons.Filled.Flag, onOpenGoal),
                DetailAction("Reminder", Icons.Filled.Alarm, onOpenReminder)
            )
            LazyVerticalGrid(
                columns = GridCells.Fixed(3),
                modifier = Modifier.fillMaxWidth().padding(top = 16.dp),
                horizontalArrangement = Arrangement.spacedBy(8.dp),
                verticalArrangement = Arrangement.spacedBy(8.dp)
            ) {
                items(actions) { action ->
                    DetailActionButton(action)
                }
            }
        }
    }

    if (showDeleteConfirm) {
        AlertDialog(
            onDismissRequest = { showDeleteConfirm = false },
            title = { Text("Remove \"${state.title}\"?") },
            text = { Text("This deletes the book and all of its bookmarks, notes, highlights, reading history, goals, and reminders from this device.") },
            confirmButton = {
                TextButton(onClick = {
                    showDeleteConfirm = false
                    viewModel.deleteBook()
                }) { Text("Remove") }
            },
            dismissButton = {
                TextButton(onClick = { showDeleteConfirm = false }) { Text("Cancel") }
            }
        )
    }
}

private data class DetailAction(val label: String, val icon: androidx.compose.ui.graphics.vector.ImageVector, val onClick: () -> Unit)

@Composable
private fun DetailActionButton(action: DetailAction) {
    OutlinedButton(
        onClick = action.onClick,
        modifier = Modifier.fillMaxWidth().height(72.dp)
    ) {
        Column(horizontalAlignment = Alignment.CenterHorizontally) {
            Icon(action.icon, contentDescription = null, modifier = Modifier.size(20.dp))
            Text(action.label, style = MaterialTheme.typography.bodyMedium, modifier = Modifier.padding(top = 4.dp))
        }
    }
}
