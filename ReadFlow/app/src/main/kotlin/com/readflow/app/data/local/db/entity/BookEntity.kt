package com.readflow.app.data.local.db.entity

import androidx.room.Entity
import androidx.room.PrimaryKey

enum class BookStatus {
    NOT_STARTED,
    READING,
    COMPLETED
}

enum class ReaderViewMode {
    PAGE,
    SCROLL
}

/**
 * A book imported into the local library. The original PDF is copied into app-private
 * storage on import ([filePath]); [originalUri] is kept only best-effort for reference and
 * must never be relied on to still resolve.
 */
@Entity(tableName = "books")
data class BookEntity(
    @PrimaryKey(autoGenerate = true) val id: Long = 0,
    val title: String,
    val author: String?,
    val filePath: String,
    val originalUri: String?,
    val coverPath: String?,
    val pageCount: Int,
    val currentPage: Int = 0,
    val progressPercent: Float = 0f,
    val dateAdded: Long,
    val lastOpened: Long? = null,
    val totalReadingTimeMillis: Long = 0,
    val status: String = BookStatus.NOT_STARTED.name,
    val hasExtractableText: Boolean = false,
    val isIndexed: Boolean = false,
    val fileSizeBytes: Long = 0,
    val fileHash: String,
    val viewMode: String = ReaderViewMode.PAGE.name,
    val readingModeEnabled: Boolean = false,
    val zoomLevel: Float = 1f
)
