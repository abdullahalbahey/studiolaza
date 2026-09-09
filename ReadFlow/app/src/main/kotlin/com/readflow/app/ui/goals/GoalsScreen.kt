@file:OptIn(androidx.compose.material3.ExperimentalMaterial3Api::class)

package com.readflow.app.ui.goals

import androidx.compose.foundation.clickable
import androidx.compose.foundation.layout.Box
import androidx.compose.foundation.layout.Column
import androidx.compose.foundation.layout.fillMaxSize
import androidx.compose.foundation.layout.fillMaxWidth
import androidx.compose.foundation.layout.padding
import androidx.compose.foundation.lazy.LazyColumn
import androidx.compose.foundation.lazy.items
import androidx.compose.material3.LinearProgressIndicator
import androidx.compose.material3.MaterialTheme
import androidx.compose.material3.Scaffold
import androidx.compose.material3.Text
import androidx.compose.material3.TopAppBar
import androidx.compose.runtime.Composable
import androidx.compose.runtime.getValue
import androidx.compose.ui.Alignment
import androidx.compose.ui.Modifier
import androidx.compose.ui.unit.dp
import androidx.hilt.navigation.compose.hiltViewModel
import androidx.lifecycle.compose.collectAsStateWithLifecycle

@Composable
fun GoalsScreen(onBookClick: (Long) -> Unit, viewModel: GoalsViewModel = hiltViewModel()) {
    val state by viewModel.uiState.collectAsStateWithLifecycle()

    Scaffold(topBar = { TopAppBar(title = { Text("Reading Goals") }) }) { padding ->
        if (!state.isLoading && state.booksWithGoals.isEmpty() && state.booksWithoutGoals.isEmpty()) {
            Box(Modifier.fillMaxSize().padding(padding), contentAlignment = Alignment.Center) {
                Text("Import a book to set a reading goal.", color = MaterialTheme.colorScheme.onSurfaceVariant)
            }
            return@Scaffold
        }

        LazyColumn(modifier = Modifier.fillMaxSize().padding(padding).padding(horizontal = 20.dp)) {
            if (state.booksWithGoals.isNotEmpty()) {
                item {
                    Text("Active goals", style = MaterialTheme.typography.titleMedium, modifier = Modifier.padding(top = 16.dp, bottom = 8.dp))
                }
                items(state.booksWithGoals, key = { "goal_${it.bookId}" }) { book ->
                    GoalRow(book, onClick = { onBookClick(book.bookId) })
                }
            }
            if (state.booksWithoutGoals.isNotEmpty()) {
                item {
                    Text("Set a goal", style = MaterialTheme.typography.titleMedium, modifier = Modifier.padding(top = 24.dp, bottom = 8.dp))
                }
                items(state.booksWithoutGoals, key = { "nogoal_${it.bookId}" }) { book ->
                    Column(
                        modifier = Modifier
                            .fillMaxWidth()
                            .clickable { onBookClick(book.bookId) }
                            .padding(vertical = 12.dp)
                    ) {
                        Text(book.title, style = MaterialTheme.typography.titleMedium)
                        Text("No goal set yet", style = MaterialTheme.typography.bodyMedium, color = MaterialTheme.colorScheme.onSurfaceVariant)
                    }
                }
            }
        }
    }
}

@Composable
private fun GoalRow(book: BookGoalUiModel, onClick: () -> Unit) {
    Column(
        modifier = Modifier
            .fillMaxWidth()
            .clickable(onClick = onClick)
            .padding(vertical = 12.dp)
    ) {
        Text(book.title, style = MaterialTheme.typography.titleMedium)
        if (book.targetPagesPerDay != null) {
            Text("Goal: ${book.targetPagesPerDay} pages/day", style = MaterialTheme.typography.bodyMedium, color = MaterialTheme.colorScheme.onSurfaceVariant)
        }
        LinearProgressIndicator(progress = { book.progressPercent }, modifier = Modifier.fillMaxWidth().padding(top = 6.dp))
        Text(
            "Page ${book.currentPageDisplay} / ${book.pageCount} · ${book.remainingPages} pages remaining",
            style = MaterialTheme.typography.bodyMedium,
            color = MaterialTheme.colorScheme.onSurfaceVariant
        )
    }
}
