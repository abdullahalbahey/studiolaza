package com.readflow.app.data.local.db.entity

import androidx.room.Entity
import androidx.room.ForeignKey
import androidx.room.Index

/**
 * Lazily-populated cache of extracted per-page text, used for search and Reading Mode.
 * Populated page-by-page as pages are visited, and backfilled in the background by
 * [com.readflow.app.data.pdf.PdfIndexingWorker] so search works across the whole book.
 */
@Entity(
    tableName = "page_text",
    primaryKeys = ["bookId", "pageNumber"],
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
data class PageTextEntity(
    val bookId: Long,
    val pageNumber: Int,
    val text: String
)
