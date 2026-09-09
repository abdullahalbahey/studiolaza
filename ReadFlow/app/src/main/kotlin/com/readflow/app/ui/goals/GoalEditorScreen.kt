@file:OptIn(androidx.compose.material3.ExperimentalMaterial3Api::class)

package com.readflow.app.ui.goals

import androidx.compose.foundation.layout.Column
import androidx.compose.foundation.layout.fillMaxSize
import androidx.compose.foundation.layout.fillMaxWidth
import androidx.compose.foundation.layout.padding
import androidx.compose.material.icons.Icons
import androidx.compose.material.icons.automirrored.filled.ArrowBack
import androidx.compose.material3.Button
import androidx.compose.material3.DatePicker
import androidx.compose.material3.DatePickerDialog
import androidx.compose.material3.Icon
import androidx.compose.material3.IconButton
import androidx.compose.material3.MaterialTheme
import androidx.compose.material3.OutlinedButton
import androidx.compose.material3.OutlinedTextField
import androidx.compose.material3.Scaffold
import androidx.compose.material3.Text
import androidx.compose.material3.TextButton
import androidx.compose.material3.TopAppBar
import androidx.compose.material3.rememberDatePickerState
import androidx.compose.runtime.Composable
import androidx.compose.runtime.LaunchedEffect
import androidx.compose.runtime.getValue
import androidx.compose.runtime.mutableStateOf
import androidx.compose.runtime.remember
import androidx.compose.runtime.setValue
import androidx.compose.ui.Modifier
import androidx.compose.ui.unit.dp
import androidx.hilt.navigation.compose.hiltViewModel
import androidx.lifecycle.compose.collectAsStateWithLifecycle
import com.readflow.app.ui.common.formatDate

@Composable
fun GoalEditorScreen(bookId: Long, onBack: () -> Unit, viewModel: GoalEditorViewModel = hiltViewModel()) {
    val state by viewModel.uiState.collectAsStateWithLifecycle()
    var showDatePicker by remember { mutableStateOf(false) }

    LaunchedEffect(state.saved) {
        if (state.saved) onBack()
    }

    Scaffold(
        topBar = {
            TopAppBar(
                title = { Text("Reading Goal") },
                navigationIcon = { IconButton(onClick = onBack) { Icon(Icons.AutoMirrored.Filled.ArrowBack, contentDescription = "Back") } }
            )
        }
    ) { padding ->
        Column(modifier = Modifier.fillMaxSize().padding(padding).padding(20.dp)) {
            Text(state.bookTitle, style = MaterialTheme.typography.titleLarge)
            Text("${state.pageCount - state.currentPage} pages remaining", style = MaterialTheme.typography.bodyMedium, color = MaterialTheme.colorScheme.onSurfaceVariant)

            OutlinedTextField(
                value = state.targetPagesPerDay,
                onValueChange = viewModel::setPagesPerDay,
                label = { Text("Target pages per day") },
                modifier = Modifier.fillMaxWidth().padding(top = 24.dp),
                singleLine = true
            )
            OutlinedTextField(
                value = state.targetMinutesPerDay,
                onValueChange = viewModel::setMinutesPerDay,
                label = { Text("Target minutes per day") },
                modifier = Modifier.fillMaxWidth().padding(top = 12.dp),
                singleLine = true
            )
            OutlinedButton(onClick = { showDatePicker = true }, modifier = Modifier.fillMaxWidth().padding(top = 12.dp)) {
                Text(state.targetDateMillis?.let { "Target completion date: ${formatDate(it)}" } ?: "Set a target completion date (optional)")
            }

            Button(onClick = viewModel::save, modifier = Modifier.fillMaxWidth().padding(top = 24.dp)) {
                Text("Save goal")
            }
            if (state.hasExistingGoal) {
                TextButton(onClick = viewModel::clearGoal, modifier = Modifier.fillMaxWidth().padding(top = 8.dp)) {
                    Text("Remove goal")
                }
            }
        }
    }

    if (showDatePicker) {
        val datePickerState = rememberDatePickerState(initialSelectedDateMillis = state.targetDateMillis)
        DatePickerDialog(
            onDismissRequest = { showDatePicker = false },
            confirmButton = {
                TextButton(onClick = {
                    viewModel.setTargetDate(datePickerState.selectedDateMillis)
                    showDatePicker = false
                }) { Text("OK") }
            },
            dismissButton = { TextButton(onClick = { showDatePicker = false }) { Text("Cancel") } }
        ) {
            DatePicker(state = datePickerState)
        }
    }
}
