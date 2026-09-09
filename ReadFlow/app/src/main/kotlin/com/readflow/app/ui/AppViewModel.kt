package com.readflow.app.ui

import android.util.Log
import androidx.lifecycle.ViewModel
import androidx.lifecycle.viewModelScope
import com.readflow.app.data.local.datastore.AppSettings
import com.readflow.app.data.local.datastore.SettingsDataStore
import dagger.hilt.android.lifecycle.HiltViewModel
import kotlinx.coroutines.flow.SharingStarted
import kotlinx.coroutines.flow.StateFlow
import kotlinx.coroutines.flow.onEach
import kotlinx.coroutines.flow.stateIn
import javax.inject.Inject

private const val TAG = "ReadFlow"

@HiltViewModel
class AppViewModel @Inject constructor(
    settingsDataStore: SettingsDataStore
) : ViewModel() {

    // null means "DataStore hasn't produced its first real read yet" - deliberately not defaulted
    // to AppSettings() (which has onboardingCompleted = false), since the app's startDestination
    // decision reads this value. Defaulting it would make every fresh process/Activity creation
    // race DataStore's async read: if the UI decided "show onboarding" before the real,
    // already-true onboardingCompleted flag loaded, it would flash the onboarding screen even
    // though setup was already done - which is exactly what a null default here prevents by
    // making the caller wait for a real value instead of guessing.
    val settings: StateFlow<AppSettings?> = settingsDataStore.settings
        .onEach { Log.d(TAG, "[STARTUP] Settings loaded: onboardingCompleted=${it.onboardingCompleted}") }
        .stateIn(
            scope = viewModelScope,
            started = SharingStarted.WhileSubscribed(5000),
            initialValue = null
        )

    init {
        Log.d(TAG, "[STARTUP] AppViewModel created, awaiting first settings read")
    }
}
