@file:OptIn(androidx.compose.material3.ExperimentalMaterial3Api::class)

package com.readflow.app.ui.settings

import androidx.activity.compose.rememberLauncherForActivityResult
import androidx.activity.result.contract.ActivityResultContracts
import androidx.compose.foundation.layout.Arrangement
import androidx.compose.foundation.layout.Column
import androidx.compose.foundation.layout.Row
import androidx.compose.foundation.layout.fillMaxSize
import androidx.compose.foundation.layout.fillMaxWidth
import androidx.compose.foundation.layout.padding
import androidx.compose.foundation.lazy.LazyColumn
import androidx.compose.foundation.lazy.items
import androidx.compose.foundation.horizontalScroll
import androidx.compose.foundation.rememberScrollState
import androidx.compose.foundation.verticalScroll
import androidx.compose.material.icons.Icons
import androidx.compose.material.icons.filled.Delete
import androidx.compose.material3.AlertDialog
import androidx.compose.material3.Button
import androidx.compose.material3.HorizontalDivider
import androidx.compose.material3.Icon
import androidx.compose.material3.IconButton
import androidx.compose.material3.MaterialTheme
import androidx.compose.material3.OutlinedButton
import androidx.compose.material3.Scaffold
import androidx.compose.material3.SegmentedButton
import androidx.compose.material3.SegmentedButtonDefaults
import androidx.compose.material3.SingleChoiceSegmentedButtonRow
import androidx.compose.material3.Snackbar
import androidx.compose.material3.Switch
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
import androidx.compose.ui.platform.LocalContext
import androidx.compose.ui.text.style.TextOverflow
import androidx.compose.ui.unit.dp
import androidx.hilt.navigation.compose.hiltViewModel
import androidx.lifecycle.compose.collectAsStateWithLifecycle
import com.readflow.app.data.local.datastore.AppThemeMode
import com.readflow.app.data.local.datastore.DefaultReadingModeOption
import com.readflow.app.data.local.datastore.LibrarySortOrder
import com.readflow.app.data.local.datastore.LibraryViewType
import com.readflow.app.data.local.db.entity.ReminderEntity
import java.io.OutputStreamWriter
import java.nio.charset.StandardCharsets

@Composable
fun SettingsScreen(viewModel: SettingsViewModel = hiltViewModel()) {
    val state by viewModel.uiState.collectAsStateWithLifecycle()
    val context = LocalContext.current
    var showDeleteAllConfirm by remember { mutableStateOf(false) }

    val exportLauncher = rememberLauncherForActivityResult(ActivityResultContracts.CreateDocument("application/json")) { uri ->
        val json = state.exportedJson
        if (uri != null && json != null) {
            context.contentResolver.openOutputStream(uri)?.use { out ->
                OutputStreamWriter(out, StandardCharsets.UTF_8).use { it.write(json) }
            }
        }
        viewModel.consumeExportedJson()
    }

    val importLauncher = rememberLauncherForActivityResult(ActivityResultContracts.OpenDocument()) { uri ->
        if (uri != null) {
            val text = context.contentResolver.openInputStream(uri)?.bufferedReader()?.use { it.readText() }
            if (text != null) viewModel.importData(text)
        }
    }

    LaunchedEffect(state.exportedJson) {
        if (state.exportedJson != null) {
            exportLauncher.launch("readflow-backup.json")
        }
    }

    Scaffold(topBar = { TopAppBar(title = { Text("Settings") }) }) { padding ->
        Column(
            modifier = Modifier
                .fillMaxSize()
                .padding(padding)
                .verticalScroll(rememberScrollState())
                .padding(horizontal = 20.dp)
        ) {
            Text("Your books and reading data stay on this device.", style = MaterialTheme.typography.bodyMedium, color = MaterialTheme.colorScheme.onSurfaceVariant, modifier = Modifier.padding(top = 12.dp))

            SectionTitle("Appearance")
            SingleChoiceSegmentedButtonRow(modifier = Modifier.fillMaxWidth()) {
                AppThemeMode.entries.forEachIndexed { index, mode ->
                    SegmentedButton(
                        selected = state.settings.appThemeMode == mode,
                        onClick = { viewModel.setAppTheme(mode) },
                        shape = SegmentedButtonDefaults.itemShape(index, AppThemeMode.entries.size)
                    ) { Text(mode.label()) }
                }
            }

            SectionTitle("Reading")
            Text("Default reading mode", style = MaterialTheme.typography.bodyMedium, modifier = Modifier.padding(top = 8.dp))
            SingleChoiceSegmentedButtonRow(modifier = Modifier.fillMaxWidth().padding(top = 4.dp)) {
                DefaultReadingModeOption.entries.forEachIndexed { index, mode ->
                    SegmentedButton(
                        selected = state.settings.defaultReadingMode == mode,
                        onClick = { viewModel.setDefaultReadingMode(mode) },
                        shape = SegmentedButtonDefaults.itemShape(index, DefaultReadingModeOption.entries.size)
                    ) { Text(if (mode == DefaultReadingModeOption.ORIGINAL_PDF) "Original PDF" else "Reading Mode") }
                }
            }
            SettingsSwitchRow("Page turn animation", state.settings.pageAnimationEnabled, viewModel::setPageAnimation)
            SettingsSwitchRow("Keep screen awake while reading", state.settings.keepScreenAwake, viewModel::setKeepScreenAwake)

            SectionTitle("Notifications")
            SettingsSwitchRow("Reading reminders", state.settings.remindersEnabled, viewModel::setRemindersEnabled)
            if (state.reminders.isEmpty()) {
                Text("No reminders yet. Set one from a book's details page.", style = MaterialTheme.typography.bodyMedium, color = MaterialTheme.colorScheme.onSurfaceVariant, modifier = Modifier.padding(top = 4.dp))
            } else {
                state.reminders.forEach { reminder ->
                    ReminderRow(reminder, onToggle = { viewModel.toggleReminder(reminder, it) }, onDelete = { viewModel.deleteReminder(reminder) })
                }
            }

            SectionTitle("Library")
            Text("Default sort", style = MaterialTheme.typography.bodyMedium, modifier = Modifier.padding(top = 8.dp))
            LazyRowChips(
                options = LibrarySortOrder.entries,
                selected = state.settings.librarySortOrder,
                label = { it.name.lowercase().replace('_', ' ').replaceFirstChar { c -> c.uppercase() } },
                onSelect = viewModel::setLibrarySortOrder
            )
            Text("Default view", style = MaterialTheme.typography.bodyMedium, modifier = Modifier.padding(top = 12.dp))
            SingleChoiceSegmentedButtonRow(modifier = Modifier.fillMaxWidth().padding(top = 4.dp)) {
                LibraryViewType.entries.forEachIndexed { index, type ->
                    SegmentedButton(
                        selected = state.settings.libraryViewType == type,
                        onClick = { viewModel.setLibraryViewType(type) },
                        shape = SegmentedButtonDefaults.itemShape(index, LibraryViewType.entries.size)
                    ) { Text(type.name.lowercase().replaceFirstChar { it.uppercase() }) }
                }
            }

            SectionTitle("Data")
            OutlinedButton(onClick = { viewModel.exportData() }, modifier = Modifier.fillMaxWidth().padding(top = 8.dp)) {
                Text("Export reading data")
            }
            OutlinedButton(onClick = { importLauncher.launch(arrayOf("application/json")) }, modifier = Modifier.fillMaxWidth().padding(top = 8.dp)) {
                Text("Import reading data")
            }
            Button(
                onClick = { showDeleteAllConfirm = true },
                colors = androidx.compose.material3.ButtonDefaults.buttonColors(containerColor = MaterialTheme.colorScheme.error),
                modifier = Modifier.fillMaxWidth().padding(top = 16.dp, bottom = 32.dp)
            ) {
                Text("Delete all books")
            }
        }
    }

    state.importSummary?.let { summary ->
        AlertDialog(
            onDismissRequest = viewModel::consumeImportSummary,
            title = { Text("Import complete") },
            text = { Text("Matched ${summary.booksMatched} book(s) already in your library. Skipped ${summary.booksSkipped} not found on this device.") },
            confirmButton = { TextButton(onClick = viewModel::consumeImportSummary) { Text("OK") } }
        )
    }

    if (showDeleteAllConfirm) {
        AlertDialog(
            onDismissRequest = { showDeleteAllConfirm = false },
            title = { Text("Delete all books?") },
            text = { Text("This removes every book and all of its bookmarks, notes, highlights, reading history, goals, and reminders from this device. This can't be undone.") },
            confirmButton = {
                TextButton(onClick = { showDeleteAllConfirm = false; viewModel.deleteAllBooks() }) { Text("Delete all") }
            },
            dismissButton = { TextButton(onClick = { showDeleteAllConfirm = false }) { Text("Cancel") } }
        )
    }
}

@Composable
private fun SectionTitle(title: String) {
    Text(title, style = MaterialTheme.typography.titleMedium, modifier = Modifier.padding(top = 24.dp, bottom = 4.dp))
    HorizontalDivider()
}

@Composable
private fun SettingsSwitchRow(label: String, checked: Boolean, onCheckedChange: (Boolean) -> Unit) {
    Row(
        modifier = Modifier.fillMaxWidth().padding(top = 8.dp),
        horizontalArrangement = Arrangement.SpaceBetween,
        verticalAlignment = Alignment.CenterVertically
    ) {
        Text(label, style = MaterialTheme.typography.bodyLarge, modifier = Modifier.weight(1f))
        Switch(checked = checked, onCheckedChange = onCheckedChange)
    }
}

@Composable
private fun ReminderRow(reminder: ReminderEntity, onToggle: (Boolean) -> Unit, onDelete: (Unit) -> Unit) {
    Row(
        modifier = Modifier.fillMaxWidth().padding(top = 8.dp),
        horizontalArrangement = Arrangement.SpaceBetween,
        verticalAlignment = Alignment.CenterVertically
    ) {
        Column(modifier = Modifier.weight(1f)) {
            Text("%02d:%02d".format(reminder.hour, reminder.minute), style = MaterialTheme.typography.bodyLarge)
            Text(reminder.message ?: "Reading reminder", style = MaterialTheme.typography.bodyMedium, color = MaterialTheme.colorScheme.onSurfaceVariant)
        }
        Switch(checked = reminder.enabled, onCheckedChange = onToggle)
        IconButton(onClick = { onDelete(Unit) }) {
            Icon(Icons.Filled.Delete, contentDescription = "Delete reminder")
        }
    }
}

@Composable
private fun <T> LazyRowChips(options: List<T>, selected: T, label: (T) -> String, onSelect: (T) -> Unit) {
    // A plain, non-scrolling Row here let the last chip(s) get squeezed into whatever width was
    // left over once the earlier ones took their natural size, and FilterChip's label Text (no
    // maxLines/overflow set) wrapped that squeeze into one character per line ("Progress" ->
    // vertically stacked letters) instead of just running off-screen. Scrolling avoids the squeeze
    // in the first place; maxLines + ellipsis is a hard guarantee against vertical wrapping even
    // if a future chip's label is unusually long for the available width.
    Row(
        modifier = Modifier
            .fillMaxWidth()
            .horizontalScroll(rememberScrollState())
            .padding(top = 4.dp),
        horizontalArrangement = Arrangement.spacedBy(8.dp)
    ) {
        options.forEach { option ->
            androidx.compose.material3.FilterChip(
                selected = option == selected,
                onClick = { onSelect(option) },
                label = { Text(label(option), maxLines = 1, overflow = TextOverflow.Ellipsis) }
            )
        }
    }
}

private fun AppThemeMode.label(): String = when (this) {
    AppThemeMode.LIGHT -> "Light"
    AppThemeMode.DARK -> "Dark"
    AppThemeMode.SYSTEM -> "System"
}
