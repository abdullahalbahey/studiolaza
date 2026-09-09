package com.readflow.app.data.repository

import com.readflow.app.data.local.db.dao.HighlightDao
import com.readflow.app.data.local.db.entity.HighlightColor
import com.readflow.app.data.local.db.entity.HighlightEntity
import kotlinx.coroutines.flow.Flow
import javax.inject.Inject
import javax.inject.Singleton

@Singleton
class HighlightRepository @Inject constructor(
    private val dao: HighlightDao
) {
    fun observeForBook(bookId: Long): Flow<List<HighlightEntity>> = dao.observeForBook(bookId)
    fun observeForPage(bookId: Long, page: Int): Flow<List<HighlightEntity>> = dao.observeForPage(bookId, page)

    suspend fun addHighlight(bookId: Long, page: Int, selectedText: String, color: HighlightColor): Long =
        dao.insert(HighlightEntity(bookId = bookId, pageNumber = page, selectedText = selectedText, color = color.name, createdAt = System.currentTimeMillis()))

    suspend fun updateColor(highlight: HighlightEntity, color: HighlightColor) =
        dao.update(highlight.copy(color = color.name))

    suspend fun attachNote(highlight: HighlightEntity, noteId: Long?) =
        dao.update(highlight.copy(noteId = noteId))

    suspend fun delete(highlight: HighlightEntity) = dao.delete(highlight)
}
