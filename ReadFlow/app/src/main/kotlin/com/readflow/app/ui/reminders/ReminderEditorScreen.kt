@file:OptIn(androidx.compose.material3.ExperimentalMaterial3Api::class)

package com.readflow.app.ui.reminders

import android.Manifest
import android.content.Intent
import android.net.Uri
import android.os.Build
import android.provider.Settings
import androidx.activity.compose.rememberLauncherForActivityResult
import androidx.activity.result.contract.ActivityResultContracts
import androidx.compose.foundation.layout.Arrangement
import androidx.compose.foundation.layout.Column
import androidx.compose.foundation.layout.Row
import androidx.compose.foundation.layout.fillMaxSize
import androidx.compose.foundation.layout.fillMaxWidth
import androidx.compose.foundation.layout.padding
import androidx.compose.foundation.rememberScrollState
import androidx.compose.foundation.verticalScroll
import androidx.compose.material.icons.Icons
import androidx.compose.material.icons.automirrored.filled.ArrowBack
import androidx.compose.material3.AlertDialog
import androidx.compose.material3.Button
import androidx.compose.material3.Card
import androidx.compose.material3.DropdownMenu
import androidx.compose.material3.DropdownMenuItem
import androidx.compose.material3.FilterChip
import androidx.compose.material3.Icon
import androidx.compose.material3.IconButton
import androidx.compose.material3.MaterialTheme
import androidx.compose.material3.OutlinedButton
import androidx.compose.material3.OutlinedTextField
import androidx.compose.material3.Scaffold
import androidx.compose.material3.Switch
import androidx.compose.material3.Text
import androidx.compose.material3.TextButton
import androidx.compose.material3.TimePicker
import androidx.compose.material3.TopAppBar
import androidx.compose.material3.rememberTimePickerState
import androidx.compose.runtime.Composable
import androidx.compose.runtime.LaunchedEffect
import androidx.compose.runtime.getValue
import androidx.compose.runtime.mutableStateOf
import androidx.compose.runtime.remember
import androidx.compose.runtime.setValue
import androidx.compose.ui.Alignment
import androidx.compose.ui.Modifier
import androidx.compose.ui.platform.LocalContext
import androidx.compose.ui.unit.dp
import androidx.core.content.ContextCompat
import androidx.hilt.navigation.compose.hiltViewModel
import androidx.lifecycle.Lifecycle
import androidx.lifecycle.LifecycleEventObserver
import androidx.lifecycle.compose.collectAsStateWithLifecycle
import androidx.compose.runtime.DisposableEffect
import androidx.compose.ui.platform.LocalLifecycleOwner

private val dayLabels = mapOf(1 to "Mon", 2 to "Tue", 3 to "Wed", 4 to "Thu", 5 to "Fri", 6 to "Sat", 7 to "Sun")

@Composable
fun ReminderEditorScreen(bookId: Long?, reminderId: Long?, onBack: () -> Unit, viewModel: ReminderEditorViewModel = hiltViewModel()) {
    val state by viewModel.uiState.collectAsStateWithLifecycle()
    val context = LocalContext.current
    var showTimePicker by remember { mutableStateOf(false) }
    var showBookMenu by remember { mutableStateOf(false) }

    val notificationPermissionLauncher = rememberLauncherForActivityResult(ActivityResultContracts.RequestPermission()) {}

    LaunchedEffect(Unit) {
        if (Build.VERSION.SDK_INT >= Build.VERSION_CODES.TIRAMISU) {
            val granted = ContextCompat.checkSelfPermission(context, Manifest.permission.POST_NOTIFICATIONS) == android.content.pm.PackageManager.PERMISSION_GRANTED
            if (!granted) notificationPermissionLauncher.launch(Manifest.permission.POST_NOTIFICATIONS)
        }
    }

    LaunchedEffect(state.saved, state.deleted) {
        if (state.saved || state.deleted) onBack()
    }

    // The exact-alarm and battery-optimization cards below send the user to system Settings;
    // re-check both permissions when they come back so the cards clear without needing to
    // leave and re-enter this screen.
    val lifecycleOwner = LocalLifecycleOwner.current
    DisposableEffect(lifecycleOwner) {
        val observer = LifecycleEventObserver { _, event ->
            if (event == Lifecycle.Event.ON_RESUME) viewModel.refreshSystemPermissionState()
        }
        lifecycleOwner.lifecycle.addObserver(observer)
        onDispose { lifecycleOwner.lifecycle.removeObserver(observer) }
    }

    Scaffold(
        topBar = {
            TopAppBar(
                title = { Text(if (state.isEditing) "Edit Reminder" else "New Reminder") },
                navigationIcon = { IconButton(onClick = onBack) { Icon(Icons.AutoMirrored.Filled.ArrowBack, contentDescription = "Back") } }
            )
        }
    ) { padding ->
        Column(
            modifier = Modifier
                .fillMaxSize()
                .padding(padding)
                .verticalScroll(rememberScrollState())
                .padding(20.dp)
        ) {
            if (!state.canScheduleExactAlarms) {
                Card(modifier = Modifier.fillMaxWidth().padding(bottom = 16.dp)) {
                    Column(modifier = Modifier.padding(16.dp)) {
                        Text("Exact alarms are off", style = MaterialTheme.typography.titleMedium)
                        Text(
                            "Reminders will still fire, but might be a little late. Allow exact alarms for on-time reminders.",
                            style = MaterialTheme.typography.bodyMedium,
                            color = MaterialTheme.colorScheme.onSurfaceVariant
                        )
                        TextButton(onClick = {
                            if (Build.VERSION.SDK_INT >= Build.VERSION_CODES.S) {
                                context.startActivity(Intent(Settings.ACTION_REQUEST_SCHEDULE_EXACT_ALARM, Uri.parse("package:${context.packageName}")))
                            }
                        }) { Text("Open settings") }
                    }
                }
            }

            if (!state.isIgnoringBatteryOptimizations) {
                Card(modifier = Modifier.fillMaxWidth().padding(bottom = 16.dp)) {
                    Column(modifier = Modifier.padding(16.dp)) {
                        Text("Battery optimization may block reminders", style = MaterialTheme.typography.titleMedium)
                        Text(
                            "Your phone's battery manager can stop this app in the background and silently drop the reminder before it fires. Allow ReadFlow to run unrestricted so reminders arrive on time.",
                            style = MaterialTheme.typography.bodyMedium,
                            color = MaterialTheme.colorScheme.onSurfaceVariant
                        )
                        TextButton(onClick = {
                            context.startActivity(
                                Intent(Settings.ACTION_REQUEST_IGNORE_BATTERY_OPTIMIZATIONS, Uri.parse("package:${context.packageName}"))
                            )
                        }) { Text("Allow") }
                    }
                }
            }

            Text("Remind me to read", style = MaterialTheme.typography.titleMedium)

            OutlinedButton(onClick = { showTimePicker = true }, modifier = Modifier.fillMaxWidth().padding(top = 8.dp)) {
                Text("%02d:%02d".format(state.hour, state.minute))
            }

            Text("Repeat on", style = MaterialTheme.typography.titleMedium, modifier = Modifier.padding(top = 20.dp))
            Row(modifier = Modifier.fillMaxWidth().padding(top = 8.dp), horizontalArrangement = Arrangement.spacedBy(6.dp)) {
                dayLabels.forEach { (day, label) ->
                    FilterChip(selected = state.selectedDays.contains(day), onClick = { viewModel.toggleDay(day) }, label = { Text(label) })
                }
            }
            Text(
                if (state.selectedDays.isEmpty()) "Every day" else "",
                style = MaterialTheme.typography.bodyMedium,
                color = MaterialTheme.colorScheme.onSurfaceVariant,
                modifier = Modifier.padding(top = 4.dp)
            )

            Text("Book", style = MaterialTheme.typography.titleMedium, modifier = Modifier.padding(top = 20.dp))
            androidx.compose.foundation.layout.Box {
                OutlinedButton(onClick = { showBookMenu = true }, modifier = Modifier.fillMaxWidth().padding(top = 8.dp)) {
                    Text(state.selectedBookTitle ?: "Whatever I'm currently reading")
                }
                DropdownMenu(expanded = showBookMenu, onDismissRequest = { showBookMenu = false }) {
                    DropdownMenuItem(text = { Text("Whatever I'm currently reading") }, onClick = { viewModel.setSelectedBook(null, null); showBookMenu = false })
                    state.availableBooks.forEach { (id, title) ->
                        DropdownMenuItem(text = { Text(title) }, onClick = { viewModel.setSelectedBook(id, title); showBookMenu = false })
                    }
                }
            }

            OutlinedTextField(
                value = state.message,
                onValueChange = viewModel::setMessage,
                label = { Text("Reminder message (optional)") },
                modifier = Modifier.fillMaxWidth().padding(top = 20.dp)
            )
            OutlinedTextField(
                value = state.dailyTargetPages,
                onValueChange = viewModel::setDailyTargetPages,
                label = { Text("Daily reading target in pages (optional)") },
                modifier = Modifier.fillMaxWidth().padding(top = 12.dp),
                singleLine = true
            )

            Row(
                modifier = Modifier.fillMaxWidth().padding(top = 20.dp),
                horizontalArrangement = Arrangement.SpaceBetween,
                verticalAlignment = Alignment.CenterVertically
            ) {
                Text("Enabled", style = MaterialTheme.typography.titleMedium)
                Switch(checked = state.enabled, onCheckedChange = viewModel::setEnabled)
            }

            Button(onClick = viewModel::save, modifier = Modifier.fillMaxWidth().padding(top = 24.dp)) {
                Text("Save reminder")
            }
            if (state.isEditing) {
                TextButton(onClick = viewModel::delete, modifier = Modifier.fillMaxWidth().padding(top = 8.dp)) {
                    Text("Delete reminder")
                }
            }
        }
    }

    if (showTimePicker) {
        val timePickerState = rememberTimePickerState(initialHour = state.hour, initialMinute = state.minute, is24Hour = false)
        AlertDialog(
            onDismissRequest = { showTimePicker = false },
            confirmButton = {
                TextButton(onClick = {
                    viewModel.setTime(timePickerState.hour, timePickerState.minute)
                    showTimePicker = false
                }) { Text("OK") }
            },
            dismissButton = { TextButton(onClick = { showTimePicker = false }) { Text("Cancel") } },
            text = { TimePicker(state = timePickerState) }
        )
    }
}
