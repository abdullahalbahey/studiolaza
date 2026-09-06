@file:OptIn(androidx.compose.material3.ExperimentalMaterial3Api::class)

package com.readflow.app.ui.reader

import androidx.compose.foundation.background
import androidx.compose.foundation.border
import androidx.compose.foundation.clickable
import androidx.compose.foundation.layout.Arrangement
import androidx.compose.foundation.layout.Column
import androidx.compose.foundation.layout.Row
import androidx.compose.foundation.layout.fillMaxWidth
import androidx.compose.foundation.layout.padding
import androidx.compose.foundation.layout.size
import androidx.compose.foundation.shape.CircleShape
import androidx.compose.material3.HorizontalDivider
import androidx.compose.material3.MaterialTheme
import androidx.compose.material3.Slider
import androidx.compose.material3.SegmentedButton
import androidx.compose.material3.SingleChoiceSegmentedButtonRow
import androidx.compose.material3.SegmentedButtonDefaults
import androidx.compose.material3.Switch
import androidx.compose.material3.Text
import androidx.compose.runtime.Composable
import androidx.compose.runtime.getValue
import androidx.compose.ui.Alignment
import androidx.compose.ui.Modifier
import androidx.compose.ui.draw.clip
import androidx.compose.ui.graphics.Color
import androidx.compose.ui.unit.dp
import androidx.hilt.navigation.compose.hiltViewModel
import androidx.lifecycle.ViewModel
import androidx.lifecycle.compose.collectAsStateWithLifecycle
import androidx.lifecycle.viewModelScope
import com.readflow.app.data.local.datastore.AppSettings
import com.readflow.app.data.local.datastore.ReaderFontFamilyOption
import com.readflow.app.data.local.datastore.ReadingThemeMode
import com.readflow.app.data.local.datastore.SettingsDataStore
import com.readflow.app.data.local.db.entity.ReaderViewMode
import dagger.hilt.android.lifecycle.HiltViewModel
import kotlinx.coroutines.flow.SharingStarted
import kotlinx.coroutines.flow.StateFlow
import kotlinx.coroutines.flow.stateIn
import kotlinx.coroutines.launch
import javax.inject.Inject

@HiltViewModel
class DisplaySettingsViewModel @Inject constructor(
    private val settingsDataStore: SettingsDataStore
) : ViewModel() {
    val settings: StateFlow<AppSettings> = settingsDataStore.settings
        .stateIn(viewModelScope, SharingStarted.WhileSubscribed(5000), AppSettings())

    fun setReadingTheme(mode: ReadingThemeMode) = viewModelScope.launch { settingsDataStore.setReadingTheme(mode) }
    fun setFontSize(sp: Float) = viewModelScope.launch { settingsDataStore.setFontSize(sp) }
    fun setLineSpacing(v: Float) = viewModelScope.launch { settingsDataStore.setLineSpacing(v) }
    fun setParagraphSpacing(sp: Float) = viewModelScope.launch { settingsDataStore.setParagraphSpacing(sp) }
    fun setFontFamily(option: ReaderFontFamilyOption) = viewModelScope.launch { settingsDataStore.setReaderFontFamily(option) }
    fun setReadingWidth(fraction: Float) = viewModelScope.launch { settingsDataStore.setReadingWidth(fraction) }
    fun setKeepScreenAwake(enabled: Boolean) = viewModelScope.launch { settingsDataStore.setKeepScreenAwake(enabled) }
}

@Composable
fun ReaderDisplaySettingsSheet(
    readingModeAvailable: Boolean,
    readingModeEnabled: Boolean,
    onReadingModeToggle: (Boolean) -> Unit,
    viewMode: ReaderViewMode,
    onViewModeChange: (ReaderViewMode) -> Unit,
    fitWholePage: Boolean,
    onFitToggle: (Boolean) -> Unit,
    viewModel: DisplaySettingsViewModel = hiltViewModel()
) {
    val settings by viewModel.settings.collectAsStateWithLifecycle()

    Column(modifier = Modifier.fillMaxWidth().padding(20.dp)) {
        Text("Display settings", style = MaterialTheme.typography.titleLarge)

        Row(
            modifier = Modifier.fillMaxWidth().padding(top = 16.dp),
            horizontalArrangement = Arrangement.SpaceBetween,
            verticalAlignment = Alignment.CenterVertically
        ) {
            Column(modifier = Modifier.weight(1f)) {
                Text("Comfortable Reading Mode", style = MaterialTheme.typography.titleMedium)
                Text(
                    if (readingModeAvailable) "Reflow this book's text for easier reading." else "Unavailable: this PDF has no extractable text, so Original PDF is used.",
                    style = MaterialTheme.typography.bodyMedium,
                    color = MaterialTheme.colorScheme.onSurfaceVariant
                )
            }
            Switch(checked = readingModeEnabled, onCheckedChange = onReadingModeToggle, enabled = readingModeAvailable)
        }

        HorizontalDivider(modifier = Modifier.padding(vertical = 16.dp))

        if (!readingModeEnabled) {
            Text("Page mode", style = MaterialTheme.typography.titleMedium)
            SingleChoiceSegmentedButtonRow(modifier = Modifier.fillMaxWidth().padding(top = 8.dp)) {
                SegmentedButton(
                    selected = viewMode == ReaderViewMode.PAGE,
                    onClick = { onViewModeChange(ReaderViewMode.PAGE) },
                    shape = SegmentedButtonDefaults.itemShape(0, 2)
                ) { Text("Page by page") }
                SegmentedButton(
                    selected = viewMode == ReaderViewMode.SCROLL,
                    onClick = { onViewModeChange(ReaderViewMode.SCROLL) },
                    shape = SegmentedButtonDefaults.itemShape(1, 2)
                ) { Text("Vertical scroll") }
            }

            Text("Zoom fit", style = MaterialTheme.typography.titleMedium, modifier = Modifier.padding(top = 16.dp))
            SingleChoiceSegmentedButtonRow(modifier = Modifier.fillMaxWidth().padding(top = 8.dp)) {
                SegmentedButton(
                    selected = !fitWholePage,
                    onClick = { onFitToggle(false) },
                    shape = SegmentedButtonDefaults.itemShape(0, 2)
                ) { Text("Fit width") }
                SegmentedButton(
                    selected = fitWholePage,
                    onClick = { onFitToggle(true) },
                    shape = SegmentedButtonDefaults.itemShape(1, 2)
                ) { Text("Fit page") }
            }
            HorizontalDivider(modifier = Modifier.padding(vertical = 16.dp))
        } else {
            Text("Font size: ${settings.fontSizeSp.toInt()}sp", style = MaterialTheme.typography.titleMedium)
            Slider(value = settings.fontSizeSp, onValueChange = viewModel::setFontSize, valueRange = 12f..28f)

            Text("Line spacing: ${"%.1f".format(settings.lineSpacingMultiplier)}x", style = MaterialTheme.typography.titleMedium)
            Slider(value = settings.lineSpacingMultiplier, onValueChange = viewModel::setLineSpacing, valueRange = 1f..2.2f)

            Text("Paragraph spacing: ${settings.paragraphSpacingSp.toInt()}sp", style = MaterialTheme.typography.titleMedium)
            Slider(value = settings.paragraphSpacingSp, onValueChange = viewModel::setParagraphSpacing, valueRange = 0f..32f)

            Text("Reading width: ${(settings.readingWidthFraction * 100).toInt()}%", style = MaterialTheme.typography.titleMedium)
            Slider(value = settings.readingWidthFraction, onValueChange = viewModel::setReadingWidth, valueRange = 0.6f..1f)

            Text("Font", style = MaterialTheme.typography.titleMedium, modifier = Modifier.padding(top = 8.dp))
            Row(modifier = Modifier.fillMaxWidth().padding(top = 8.dp), horizontalArrangement = Arrangement.spacedBy(8.dp)) {
                ReaderFontFamilyOption.entries.forEach { option ->
                    androidx.compose.material3.FilterChip(
                        selected = settings.readerFontFamily == option,
                        onClick = { viewModel.setFontFamily(option) },
                        label = { Text(option.label()) }
                    )
                }
            }
            HorizontalDivider(modifier = Modifier.padding(vertical = 16.dp))
        }

        Text("Reading theme", style = MaterialTheme.typography.titleMedium)
        Row(modifier = Modifier.fillMaxWidth().padding(top = 8.dp), horizontalArrangement = Arrangement.spacedBy(12.dp)) {
            ReadingThemeMode.entries.forEach { theme ->
                ThemeSwatch(
                    color = theme.swatchColor(),
                    selected = settings.readingTheme == theme,
                    onClick = { viewModel.setReadingTheme(theme) }
                )
            }
        }

        Row(
            modifier = Modifier.fillMaxWidth().padding(top = 16.dp),
            horizontalArrangement = Arrangement.SpaceBetween,
            verticalAlignment = Alignment.CenterVertically
        ) {
            Text("Keep screen awake while reading", style = MaterialTheme.typography.titleMedium, modifier = Modifier.weight(1f))
            Switch(checked = settings.keepScreenAwake, onCheckedChange = viewModel::setKeepScreenAwake)
        }
    }
}

@Composable
private fun ThemeSwatch(color: Color, selected: Boolean, onClick: () -> Unit) {
    Column(
        modifier = Modifier
            .size(36.dp)
            .clip(CircleShape)
            .background(color)
            .border(width = if (selected) 3.dp else 1.dp, color = MaterialTheme.colorScheme.primary, shape = CircleShape)
            .clickable(onClick = onClick)
    ) {}
}

private fun ReadingThemeMode.swatchColor(): Color = when (this) {
    ReadingThemeMode.LIGHT -> Color(0xFFFDFBF7)
    ReadingThemeMode.DARK -> Color(0xFF121110)
    ReadingThemeMode.SEPIA -> Color(0xFFF4ECD8)
    ReadingThemeMode.HIGH_CONTRAST -> Color(0xFF000000)
}

private fun ReaderFontFamilyOption.label(): String = when (this) {
    ReaderFontFamilyOption.DEFAULT -> "Default"
    ReaderFontFamilyOption.SERIF -> "Serif"
    ReaderFontFamilyOption.SANS_SERIF -> "Sans"
    ReaderFontFamilyOption.MONOSPACE -> "Mono"
}
