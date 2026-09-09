package com.readflow.app.ui.theme

import androidx.compose.runtime.Composable
import androidx.compose.runtime.remember
import androidx.compose.ui.graphics.Color
import com.readflow.app.data.local.datastore.ReadingThemeMode

/** Colors for the reader surface itself, independent of the app's own Light/Dark/System theme. */
data class ReadingColors(
    val pageBackground: Color,
    val onPageText: Color,
    val toolbarBackground: Color,
    val onToolbar: Color,
    val progressTrack: Color,
    val progressIndicator: Color
)

@Composable
fun readingColorsFor(mode: ReadingThemeMode): ReadingColors = remember(mode) {
    when (mode) {
        ReadingThemeMode.LIGHT -> ReadingColors(
            pageBackground = Neutral99,
            onPageText = Neutral10,
            toolbarBackground = Neutral95,
            onToolbar = Neutral10,
            progressTrack = Neutral90,
            progressIndicator = ForestGreen40
        )
        ReadingThemeMode.DARK -> ReadingColors(
            pageBackground = Neutral10,
            onPageText = Neutral95,
            toolbarBackground = Neutral20,
            onToolbar = Neutral95,
            progressTrack = Neutral30,
            progressIndicator = ForestGreen80
        )
        ReadingThemeMode.SEPIA -> ReadingColors(
            pageBackground = SepiaBackground,
            onPageText = SepiaOnBackground,
            toolbarBackground = SepiaToolbar,
            onToolbar = SepiaOnBackground,
            progressTrack = Amber80,
            progressIndicator = Amber40
        )
        ReadingThemeMode.HIGH_CONTRAST -> ReadingColors(
            pageBackground = HighContrastBackground,
            onPageText = HighContrastOnBackground,
            toolbarBackground = HighContrastBackground,
            onToolbar = HighContrastOnBackground,
            progressTrack = Neutral30,
            progressIndicator = HighContrastOnBackground
        )
    }
}
