package com.readflow.app.data.local.datastore

import android.content.Context
import dagger.hilt.android.qualifiers.ApplicationContext
import androidx.datastore.preferences.core.booleanPreferencesKey
import androidx.datastore.preferences.core.edit
import androidx.datastore.preferences.core.floatPreferencesKey
import androidx.datastore.preferences.core.intPreferencesKey
import androidx.datastore.preferences.core.stringPreferencesKey
import androidx.datastore.preferences.preferencesDataStore
import kotlinx.coroutines.flow.Flow
import kotlinx.coroutines.flow.map
import javax.inject.Inject
import javax.inject.Singleton

enum class AppThemeMode { LIGHT, DARK, SYSTEM }
enum class ReadingThemeMode { LIGHT, DARK, SEPIA, HIGH_CONTRAST }
enum class DefaultReadingModeOption { ORIGINAL_PDF, READING_MODE }
enum class LibrarySortOrder { RECENTLY_READ, TITLE, AUTHOR, PROGRESS, DATE_ADDED }
enum class LibraryFilter { ALL, READING, COMPLETED, NOT_STARTED }
enum class LibraryViewType { GRID, LIST }
enum class ReaderFontFamilyOption { DEFAULT, SERIF, SANS_SERIF, MONOSPACE }

data class AppSettings(
    val appThemeMode: AppThemeMode = AppThemeMode.SYSTEM,
    val onboardingCompleted: Boolean = false,
    // Reading defaults
    val defaultReadingMode: DefaultReadingModeOption = DefaultReadingModeOption.ORIGINAL_PDF,
    val readingTheme: ReadingThemeMode = ReadingThemeMode.LIGHT,
    val defaultZoom: Float = 1f,
    val fontSizeSp: Float = 18f,
    val lineSpacingMultiplier: Float = 1.4f,
    val paragraphSpacingSp: Float = 12f,
    val readerFontFamily: ReaderFontFamilyOption = ReaderFontFamilyOption.DEFAULT,
    val readingWidthFraction: Float = 0.92f,
    val pageAnimationEnabled: Boolean = true,
    val keepScreenAwake: Boolean = true,
    // Notifications
    val remindersEnabled: Boolean = true,
    val defaultReminderHour: Int = 20,
    val defaultReminderMinute: Int = 0,
    // Library
    val librarySortOrder: LibrarySortOrder = LibrarySortOrder.RECENTLY_READ,
    val libraryFilter: LibraryFilter = LibraryFilter.ALL,
    val libraryViewType: LibraryViewType = LibraryViewType.GRID
)

private val Context.dataStore by preferencesDataStore(name = "readflow_settings")

@Singleton
class SettingsDataStore @Inject constructor(
    @ApplicationContext private val context: Context
) {
    private object Keys {
        val APP_THEME = stringPreferencesKey("app_theme_mode")
        val ONBOARDING_DONE = booleanPreferencesKey("onboarding_completed")
        val DEFAULT_READING_MODE = stringPreferencesKey("default_reading_mode")
        val READING_THEME = stringPreferencesKey("reading_theme")
        val DEFAULT_ZOOM = floatPreferencesKey("default_zoom")
        val FONT_SIZE = floatPreferencesKey("font_size_sp")
        val LINE_SPACING = floatPreferencesKey("line_spacing")
        val PARAGRAPH_SPACING = floatPreferencesKey("paragraph_spacing")
        val FONT_FAMILY = stringPreferencesKey("reader_font_family")
        val READING_WIDTH = floatPreferencesKey("reading_width_fraction")
        val PAGE_ANIMATION = booleanPreferencesKey("page_animation_enabled")
        val KEEP_SCREEN_AWAKE = booleanPreferencesKey("keep_screen_awake")
        val REMINDERS_ENABLED = booleanPreferencesKey("reminders_enabled")
        val DEFAULT_REMINDER_HOUR = intPreferencesKey("default_reminder_hour")
        val DEFAULT_REMINDER_MINUTE = intPreferencesKey("default_reminder_minute")
        val LIBRARY_SORT = stringPreferencesKey("library_sort_order")
        val LIBRARY_FILTER = stringPreferencesKey("library_filter")
        val LIBRARY_VIEW_TYPE = stringPreferencesKey("library_view_type")
    }

    val settings: Flow<AppSettings> = context.dataStore.data.map { prefs ->
        AppSettings(
            appThemeMode = prefs[Keys.APP_THEME]?.let { runCatching { AppThemeMode.valueOf(it) }.getOrNull() } ?: AppThemeMode.SYSTEM,
            onboardingCompleted = prefs[Keys.ONBOARDING_DONE] ?: false,
            defaultReadingMode = prefs[Keys.DEFAULT_READING_MODE]?.let { runCatching { DefaultReadingModeOption.valueOf(it) }.getOrNull() } ?: DefaultReadingModeOption.ORIGINAL_PDF,
            readingTheme = prefs[Keys.READING_THEME]?.let { runCatching { ReadingThemeMode.valueOf(it) }.getOrNull() } ?: ReadingThemeMode.LIGHT,
            defaultZoom = prefs[Keys.DEFAULT_ZOOM] ?: 1f,
            fontSizeSp = prefs[Keys.FONT_SIZE] ?: 18f,
            lineSpacingMultiplier = prefs[Keys.LINE_SPACING] ?: 1.4f,
            paragraphSpacingSp = prefs[Keys.PARAGRAPH_SPACING] ?: 12f,
            readerFontFamily = prefs[Keys.FONT_FAMILY]?.let { runCatching { ReaderFontFamilyOption.valueOf(it) }.getOrNull() } ?: ReaderFontFamilyOption.DEFAULT,
            readingWidthFraction = prefs[Keys.READING_WIDTH] ?: 0.92f,
            pageAnimationEnabled = prefs[Keys.PAGE_ANIMATION] ?: true,
            keepScreenAwake = prefs[Keys.KEEP_SCREEN_AWAKE] ?: true,
            remindersEnabled = prefs[Keys.REMINDERS_ENABLED] ?: true,
            defaultReminderHour = prefs[Keys.DEFAULT_REMINDER_HOUR] ?: 20,
            defaultReminderMinute = prefs[Keys.DEFAULT_REMINDER_MINUTE] ?: 0,
            librarySortOrder = prefs[Keys.LIBRARY_SORT]?.let { runCatching { LibrarySortOrder.valueOf(it) }.getOrNull() } ?: LibrarySortOrder.RECENTLY_READ,
            libraryFilter = prefs[Keys.LIBRARY_FILTER]?.let { runCatching { LibraryFilter.valueOf(it) }.getOrNull() } ?: LibraryFilter.ALL,
            libraryViewType = prefs[Keys.LIBRARY_VIEW_TYPE]?.let { runCatching { LibraryViewType.valueOf(it) }.getOrNull() } ?: LibraryViewType.GRID
        )
    }

    suspend fun setAppThemeMode(mode: AppThemeMode) = update { it[Keys.APP_THEME] = mode.name }
    suspend fun setOnboardingCompleted(done: Boolean) = update { it[Keys.ONBOARDING_DONE] = done }
    suspend fun setDefaultReadingMode(mode: DefaultReadingModeOption) = update { it[Keys.DEFAULT_READING_MODE] = mode.name }
    suspend fun setReadingTheme(mode: ReadingThemeMode) = update { it[Keys.READING_THEME] = mode.name }
    suspend fun setDefaultZoom(zoom: Float) = update { it[Keys.DEFAULT_ZOOM] = zoom }
    suspend fun setFontSize(sp: Float) = update { it[Keys.FONT_SIZE] = sp }
    suspend fun setLineSpacing(multiplier: Float) = update { it[Keys.LINE_SPACING] = multiplier }
    suspend fun setParagraphSpacing(sp: Float) = update { it[Keys.PARAGRAPH_SPACING] = sp }
    suspend fun setReaderFontFamily(option: ReaderFontFamilyOption) = update { it[Keys.FONT_FAMILY] = option.name }
    suspend fun setReadingWidth(fraction: Float) = update { it[Keys.READING_WIDTH] = fraction }
    suspend fun setPageAnimationEnabled(enabled: Boolean) = update { it[Keys.PAGE_ANIMATION] = enabled }
    suspend fun setKeepScreenAwake(enabled: Boolean) = update { it[Keys.KEEP_SCREEN_AWAKE] = enabled }
    suspend fun setRemindersEnabled(enabled: Boolean) = update { it[Keys.REMINDERS_ENABLED] = enabled }
    suspend fun setDefaultReminderTime(hour: Int, minute: Int) = update {
        it[Keys.DEFAULT_REMINDER_HOUR] = hour
        it[Keys.DEFAULT_REMINDER_MINUTE] = minute
    }
    suspend fun setLibrarySortOrder(order: LibrarySortOrder) = update { it[Keys.LIBRARY_SORT] = order.name }
    suspend fun setLibraryFilter(filter: LibraryFilter) = update { it[Keys.LIBRARY_FILTER] = filter.name }
    suspend fun setLibraryViewType(type: LibraryViewType) = update { it[Keys.LIBRARY_VIEW_TYPE] = type.name }

    private suspend fun update(block: (androidx.datastore.preferences.core.MutablePreferences) -> Unit) {
        context.dataStore.edit(block)
    }
}
