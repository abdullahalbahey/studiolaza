@file:OptIn(androidx.compose.material3.ExperimentalMaterial3Api::class)

package com.readflow.app.ui.highlights

import androidx.compose.foundation.background
import androidx.compose.foundation.clickable
import androidx.compose.foundation.layout.Box
import androidx.compose.foundation.layout.Column
import androidx.compose.foundation.layout.Row
import androidx.compose.foundation.layout.fillMaxHeight
import androidx.compose.foundation.layout.fillMaxSize
import androidx.compose.foundation.layout.fillMaxWidth
import androidx.compose.foundation.layout.padding
import androidx.compose.foundation.layout.width
import androidx.compose.foundation.lazy.LazyColumn
import androidx.compose.foundation.lazy.items
import androidx.compose.material.icons.Icons
import androidx.compose.material.icons.automirrored.filled.ArrowBack
import androidx.compose.material.icons.filled.Delete
import androidx.compose.material3.DropdownMenu
import androidx.compose.material3.DropdownMenuItem
import androidx.compose.material3.Icon
import androidx.compose.material3.IconButton
import androidx.compose.material3.MaterialTheme
import androidx.compose.material3.Scaffold
import androidx.compose.material3.Text
import androidx.compose.material3.TopAppBar
import androidx.compose.runtime.Composable
import androidx.compose.runtime.getValue
import androidx.compose.runtime.mutableStateOf
import androidx.compose.runtime.remember
import androidx.compose.runtime.setValue
import androidx.compose.ui.Alignment
import androidx.compose.ui.Modifier
import androidx.compose.ui.graphics.Color
import androidx.compose.ui.unit.dp
import androidx.hilt.navigation.compose.hiltViewModel
import androidx.lifecycle.compose.collectAsStateWithLifecycle
import com.readflow.app.data.local.db.entity.HighlightColor
import com.readflow.app.data.local.db.entity.HighlightEntity
import com.readflow.app.ui.common.formatDate

@Composable
fun HighlightsScreen(
    bookId: Long,
    onBack: () -> Unit,
    onJumpToPage: (Int) -> Unit,
    viewModel: HighlightsViewModel = hiltViewModel()
) {
    val highlights by viewModel.highlights.collectAsStateWithLifecycle()

    Scaffold(
        topBar = {
            TopAppBar(
                title = { Text("Highlights") },
                navigationIcon = { IconButton(onClick = onBack) { Icon(Icons.AutoMirrored.Filled.ArrowBack, contentDescription = "Back") } }
            )
        }
    ) { padding ->
        if (highlights.isEmpty()) {
            Box(Modifier.fillMaxSize().padding(padding), contentAlignment = Alignment.Center) {
                Text("No highlights yet. Highlight text from Reading Mode.", color = MaterialTheme.colorScheme.onSurfaceVariant)
            }
        } else {
            LazyColumn(modifier = Modifier.fillMaxSize().padding(padding)) {
                items(highlights, key = { it.id }) { highlight ->
                    HighlightRow(
                        highlight = highlight,
                        onJump = { onJumpToPage(highlight.pageNumber) },
                        onColorChange = { viewModel.setColor(highlight, it) },
                        onDelete = { viewModel.delete(highlight) }
                    )
                }
            }
        }
    }
}

@Composable
private fun HighlightRow(highlight: HighlightEntity, onJump: () -> Unit, onColorChange: (HighlightColor) -> Unit, onDelete: () -> Unit) {
    var showColorMenu by remember { mutableStateOf(false) }
    val color = runCatching { HighlightColor.valueOf(highlight.color) }.getOrDefault(HighlightColor.YELLOW)

    Row(
        modifier = Modifier
            .fillMaxWidth()
            .clickable(onClick = onJump)
            .padding(horizontal = 20.dp, vertical = 12.dp)
    ) {
        Box(
            modifier = Modifier
                .width(4.dp)
                .fillMaxHeight()
                .background(color.toColor())
        )
        Column(modifier = Modifier.weight(1f).padding(start = 12.dp)) {
            Text("Page ${highlight.pageNumber + 1} · ${formatDate(highlight.createdAt)}", style = MaterialTheme.typography.bodyMedium, color = MaterialTheme.colorScheme.onSurfaceVariant)
            Text(highlight.selectedText, style = MaterialTheme.typography.bodyLarge, modifier = Modifier.padding(top = 4.dp))
        }
        Box {
            IconButton(onClick = { showColorMenu = true }) {
                Box(modifier = Modifier.width(20.dp).fillMaxHeight().background(color.toColor()))
            }
            DropdownMenu(expanded = showColorMenu, onDismissRequest = { showColorMenu = false }) {
                HighlightColor.entries.forEach { c ->
                    DropdownMenuItem(text = { Text(c.name.lowercase().replaceFirstChar { it.uppercase() }) }, onClick = { onColorChange(c); showColorMenu = false })
                }
            }
        }
        IconButton(onClick = onDelete) { Icon(Icons.Filled.Delete, contentDescription = "Delete highlight") }
    }
}

private fun HighlightColor.toColor(): Color = when (this) {
    HighlightColor.YELLOW -> Color(0xFFFFE066)
    HighlightColor.GREEN -> Color(0xFFA6E3A1)
    HighlightColor.BLUE -> Color(0xFFA0C4FF)
    HighlightColor.PINK -> Color(0xFFFFADC6)
    HighlightColor.ORANGE -> Color(0xFFFFB870)
}
