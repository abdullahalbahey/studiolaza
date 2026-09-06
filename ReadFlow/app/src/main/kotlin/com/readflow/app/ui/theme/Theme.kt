package com.readflow.app.ui.theme

import android.app.Activity
import android.os.Build
import androidx.compose.foundation.isSystemInDarkTheme
import androidx.compose.material3.MaterialTheme
import androidx.compose.material3.darkColorScheme
import androidx.compose.material3.lightColorScheme
import androidx.compose.runtime.Composable
import androidx.compose.runtime.SideEffect
import androidx.compose.ui.graphics.toArgb
import androidx.compose.ui.platform.LocalView
import androidx.core.view.WindowCompat
import com.readflow.app.data.local.datastore.AppThemeMode

private val LightColors = lightColorScheme(
    primary = ForestGreen40,
    onPrimary = Neutral99,
    primaryContainer = ForestGreen80,
    onPrimaryContainer = ForestGreen20,
    secondary = Amber40,
    onSecondary = Neutral99,
    secondaryContainer = Amber80,
    background = Neutral99,
    onBackground = Neutral10,
    surface = Neutral99,
    onSurface = Neutral10,
    surfaceVariant = Neutral95,
    onSurfaceVariant = Neutral30,
    outline = Neutral90,
    error = ErrorRed
)

private val DarkColors = darkColorScheme(
    primary = ForestGreen80,
    onPrimary = ForestGreen20,
    primaryContainer = ForestGreen40,
    onPrimaryContainer = ForestGreen80,
    secondary = Amber80,
    onSecondary = Amber40,
    secondaryContainer = Amber40,
    background = Neutral10,
    onBackground = Neutral95,
    surface = Neutral10,
    onSurface = Neutral95,
    surfaceVariant = Neutral20,
    onSurfaceVariant = Neutral90,
    outline = Neutral30,
    error = ErrorRedDark
)

@Composable
fun ReadFlowTheme(
    appThemeMode: AppThemeMode = AppThemeMode.SYSTEM,
    content: @Composable () -> Unit
) {
    val useDarkTheme = when (appThemeMode) {
        AppThemeMode.LIGHT -> false
        AppThemeMode.DARK -> true
        AppThemeMode.SYSTEM -> isSystemInDarkTheme()
    }
    val colorScheme = if (useDarkTheme) DarkColors else LightColors

    val view = LocalView.current
    if (!view.isInEditMode) {
        SideEffect {
            val window = (view.context as? Activity)?.window ?: return@SideEffect
            window.statusBarColor = colorScheme.background.toArgb()
            WindowCompat.getInsetsController(window, view).isAppearanceLightStatusBars = !useDarkTheme
        }
    }

    MaterialTheme(
        colorScheme = colorScheme,
        typography = Typography,
        content = content
    )
}
