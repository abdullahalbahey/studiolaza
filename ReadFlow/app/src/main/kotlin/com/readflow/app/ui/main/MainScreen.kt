package com.readflow.app.ui.main

import android.net.Uri
import androidx.compose.foundation.layout.Box
import androidx.compose.foundation.layout.WindowInsets
import androidx.compose.foundation.layout.fillMaxSize
import androidx.compose.foundation.layout.padding
import androidx.compose.material.icons.Icons
import androidx.compose.material.icons.automirrored.filled.MenuBook
import androidx.compose.material.icons.automirrored.outlined.MenuBook
import androidx.compose.material.icons.filled.Flag
import androidx.compose.material.icons.filled.Settings
import androidx.compose.material.icons.outlined.Flag
import androidx.compose.material.icons.outlined.Settings
import androidx.compose.material3.Icon
import androidx.compose.material3.NavigationBar
import androidx.compose.material3.NavigationBarItem
import androidx.compose.material3.Scaffold
import androidx.compose.material3.Text
import androidx.compose.runtime.Composable
import androidx.compose.runtime.mutableIntStateOf
import androidx.compose.runtime.saveable.rememberSaveable
import androidx.compose.runtime.setValue
import androidx.compose.runtime.getValue
import androidx.compose.ui.Modifier
import androidx.compose.ui.res.stringResource
import com.readflow.app.R
import com.readflow.app.ui.goals.GoalsScreen
import com.readflow.app.ui.library.LibraryScreen
import com.readflow.app.ui.settings.SettingsScreen

@Composable
fun MainScreen(
    onOpenBook: (Long) -> Unit,
    onOpenReaderDirect: (Long) -> Unit,
    pendingImportUri: Uri?,
    onImportUriConsumed: () -> Unit
) {
    var selectedTab by rememberSaveable { mutableIntStateOf(0) }

    Scaffold(
        // Each tab (LibraryScreen, GoalsScreen, SettingsScreen) has its own Scaffold with its own
        // TopAppBar, which already pads itself for the status bar. Leaving this Scaffold's default
        // window insets (which include the status bar, since it has no topBar of its own to absorb
        // them) would stack a second status-bar-height of empty space above every tab's content.
        // NavigationBar below still gets the correct bottom inset on its own regardless of this.
        contentWindowInsets = WindowInsets(0, 0, 0, 0),
        bottomBar = {
            NavigationBar {
                NavigationBarItem(
                    selected = selectedTab == 0,
                    onClick = { selectedTab = 0 },
                    icon = {
                        Icon(
                            if (selectedTab == 0) Icons.AutoMirrored.Filled.MenuBook else Icons.AutoMirrored.Outlined.MenuBook,
                            contentDescription = null
                        )
                    },
                    label = { Text(stringResource(R.string.tab_library)) }
                )
                NavigationBarItem(
                    selected = selectedTab == 1,
                    onClick = { selectedTab = 1 },
                    icon = { Icon(if (selectedTab == 1) Icons.Filled.Flag else Icons.Outlined.Flag, contentDescription = null) },
                    label = { Text(stringResource(R.string.tab_goals)) }
                )
                NavigationBarItem(
                    selected = selectedTab == 2,
                    onClick = { selectedTab = 2 },
                    icon = { Icon(if (selectedTab == 2) Icons.Filled.Settings else Icons.Outlined.Settings, contentDescription = null) },
                    label = { Text(stringResource(R.string.tab_settings)) }
                )
            }
        }
    ) { padding ->
        Box(modifier = Modifier.fillMaxSize().padding(padding)) {
            when (selectedTab) {
                0 -> LibraryScreen(
                    onBookClick = onOpenBook,
                    onOpenReaderDirect = onOpenReaderDirect,
                    pendingImportUri = pendingImportUri,
                    onImportUriConsumed = onImportUriConsumed
                )
                1 -> GoalsScreen(onBookClick = onOpenBook)
                else -> SettingsScreen()
            }
        }
    }
}
