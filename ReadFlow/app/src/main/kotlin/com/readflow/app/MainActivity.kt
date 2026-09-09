package com.readflow.app

import android.content.Intent
import android.net.Uri
import android.os.Bundle
import androidx.activity.ComponentActivity
import androidx.activity.compose.setContent
import androidx.activity.enableEdgeToEdge
import androidx.compose.foundation.layout.Box
import androidx.compose.foundation.layout.fillMaxSize
import androidx.compose.material3.MaterialTheme
import androidx.compose.material3.Surface
import androidx.compose.runtime.getValue
import androidx.compose.runtime.mutableStateOf
import androidx.compose.runtime.setValue
import androidx.compose.ui.Modifier
import androidx.lifecycle.compose.collectAsStateWithLifecycle
import androidx.navigation.compose.rememberNavController
import com.readflow.app.data.local.datastore.AppThemeMode
import com.readflow.app.reminders.EXTRA_OPEN_BOOK_ID
import com.readflow.app.ui.AppViewModel
import com.readflow.app.ui.navigation.ReadFlowNavGraph
import com.readflow.app.ui.theme.ReadFlowTheme
import dagger.hilt.android.AndroidEntryPoint

@AndroidEntryPoint
class MainActivity : ComponentActivity() {

    private var pendingDeepLinkBookId by mutableStateOf<Long?>(null)
    private var pendingImportUri by mutableStateOf<Uri?>(null)

    override fun onCreate(savedInstanceState: Bundle?) {
        super.onCreate(savedInstanceState)
        enableEdgeToEdge()
        consumeIntent(intent)

        setContent {
            val appViewModel: AppViewModel = androidx.hilt.navigation.compose.hiltViewModel()
            val settings by appViewModel.settings.collectAsStateWithLifecycle()
            val loadedSettings = settings

            ReadFlowTheme(appThemeMode = loadedSettings?.appThemeMode ?: AppThemeMode.SYSTEM) {
                Surface(modifier = Modifier.fillMaxSize(), color = MaterialTheme.colorScheme.background) {
                    if (loadedSettings == null) {
                        // DataStore's first real read hasn't completed yet - show nothing rather
                        // than guess whether onboarding is needed. This is normally imperceptible
                        // (a handful of milliseconds); the alternative is deciding the app's start
                        // screen from a default value that doesn't reflect what's actually on disk.
                        Box(modifier = Modifier.fillMaxSize())
                    } else {
                        ReadFlowNavGraph(
                            onboardingCompleted = loadedSettings.onboardingCompleted,
                            deepLinkBookId = pendingDeepLinkBookId,
                            onDeepLinkConsumed = { pendingDeepLinkBookId = null },
                            importUri = pendingImportUri,
                            onImportUriConsumed = { pendingImportUri = null },
                            navController = rememberNavController()
                        )
                    }
                }
            }
        }
    }

    override fun onNewIntent(intent: Intent) {
        super.onNewIntent(intent)
        setIntent(intent)
        consumeIntent(intent)
    }

    private fun consumeIntent(intent: Intent?) {
        intent ?: return
        val bookId = intent.getLongExtra(EXTRA_OPEN_BOOK_ID, -1L)
        if (bookId > 0) {
            pendingDeepLinkBookId = bookId
        }
        if (intent.action == Intent.ACTION_VIEW) {
            pendingImportUri = intent.data
        }
    }
}
