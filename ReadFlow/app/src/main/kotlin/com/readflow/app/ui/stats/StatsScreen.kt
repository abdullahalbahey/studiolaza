@file:OptIn(androidx.compose.material3.ExperimentalMaterial3Api::class)

package com.readflow.app.ui.stats

import androidx.compose.foundation.layout.Arrangement
import androidx.compose.foundation.layout.Column
import androidx.compose.foundation.layout.Row
import androidx.compose.foundation.layout.fillMaxSize
import androidx.compose.foundation.layout.fillMaxWidth
import androidx.compose.foundation.layout.padding
import androidx.compose.foundation.lazy.grid.GridCells
import androidx.compose.foundation.lazy.grid.LazyVerticalGrid
import androidx.compose.foundation.lazy.grid.items
import androidx.compose.material.icons.Icons
import androidx.compose.material.icons.automirrored.filled.ArrowBack
import androidx.compose.material3.Card
import androidx.compose.material3.Icon
import androidx.compose.material3.IconButton
import androidx.compose.material3.MaterialTheme
import androidx.compose.material3.Scaffold
import androidx.compose.material3.Text
import androidx.compose.material3.TopAppBar
import androidx.compose.runtime.Composable
import androidx.compose.runtime.getValue
import androidx.compose.ui.Modifier
import androidx.compose.ui.unit.dp
import androidx.hilt.navigation.compose.hiltViewModel
import androidx.lifecycle.compose.collectAsStateWithLifecycle
import com.readflow.app.ui.common.formatDate
import com.readflow.app.ui.common.formatDuration

@Composable
fun StatsScreen(bookId: Long, onBack: () -> Unit, viewModel: StatsViewModel = hiltViewModel()) {
    val state by viewModel.uiState.collectAsStateWithLifecycle()

    Scaffold(
        topBar = {
            TopAppBar(
                title = { Text("Reading Stats") },
                navigationIcon = { IconButton(onClick = onBack) { Icon(Icons.AutoMirrored.Filled.ArrowBack, contentDescription = "Back") } }
            )
        }
    ) { padding ->
        val stats = state.stats
        if (stats == null) {
            Column(modifier = Modifier.fillMaxSize().padding(padding)) {}
            return@Scaffold
        }

        Column(modifier = Modifier.fillMaxSize().padding(padding).padding(20.dp)) {
            Text(state.bookTitle, style = MaterialTheme.typography.titleLarge)

            val cards = listOf(
                "Pages read" to "${stats.pagesRead} / ${stats.totalPages}",
                "Progress" to "${(stats.percentComplete * 100).toInt()}%",
                "Reading time" to formatDuration(stats.totalReadingTimeMillis),
                "Sessions" to stats.sessionCount.toString(),
                "Avg pages/session" to "%.1f".format(stats.averagePagesPerSession),
                "Avg time/session" to formatDuration(stats.averageSessionDurationMillis),
                "Current streak" to "${stats.currentStreakDays} days",
                "Longest streak" to "${stats.longestStreakDays} days"
            )

            LazyVerticalGrid(
                columns = GridCells.Fixed(2),
                modifier = Modifier.fillMaxWidth().padding(top = 16.dp),
                horizontalArrangement = Arrangement.spacedBy(12.dp),
                verticalArrangement = Arrangement.spacedBy(12.dp)
            ) {
                items(cards) { (label, value) ->
                    StatCard(label, value)
                }
            }

            stats.estimatedCompletionDate?.let {
                Text(
                    "Estimated completion: ${formatDate(it)}",
                    style = MaterialTheme.typography.titleMedium,
                    modifier = Modifier.padding(top = 20.dp)
                )
            }
        }
    }
}

@Composable
private fun StatCard(label: String, value: String) {
    Card(modifier = Modifier.fillMaxWidth()) {
        Column(modifier = Modifier.padding(16.dp)) {
            Text(value, style = MaterialTheme.typography.titleLarge)
            Text(label, style = MaterialTheme.typography.bodyMedium, color = MaterialTheme.colorScheme.onSurfaceVariant)
        }
    }
}
