package com.readflow.app.data.local.db.entity

import androidx.room.Entity
import androidx.room.ForeignKey
import androidx.room.Index
import androidx.room.PrimaryKey

enum class HighlightColor {
    YELLOW, GREEN, BLUE, PINK, ORANGE
}

/**
 * Highlights are only offered in Reading Mode, where extracted text is selectable.
 * The original bitmap-rendered PDF page has no text layer to select from.
 */
@Entity(
    tableName = "highlights",
    foreignKeys = [
        ForeignKey(
            entity = BookEntity::class,
            parentColumns = ["id"],
            childColumns = ["bookId"],
            onDelete = ForeignKey.CASCADE
        )
    ],
    indices = [Index("bookId")]
)
data class HighlightEntity(
    @PrimaryKey(autoGenerate = true) val id: Long = 0,
    val bookId: Long,
    val pageNumber: Int,
    val selectedText: String,
    val color: String = HighlightColor.YELLOW.name,
    val noteId: Long? = null,
    val createdAt: Long
)
