package com.readflow.app.data.repository

import com.readflow.app.data.local.db.dao.NoteDao
import com.readflow.app.data.local.db.entity.NoteEntity
import kotlinx.coroutines.flow.Flow
import javax.inject.Inject
import javax.inject.Singleton

@Singleton
class NoteRepository @Inject constructor(
    private val dao: NoteDao
) {
    fun observeForBook(bookId: Long): Flow<List<NoteEntity>> = dao.observeForBook(bookId)
    fun observeForPage(bookId: Long, page: Int): Flow<List<NoteEntity>> = dao.observeForPage(bookId, page)

    suspend fun addNote(bookId: Long, page: Int, selectedText: String?, noteText: String): Long {
        val now = System.currentTimeMillis()
        return dao.insert(NoteEntity(bookId = bookId, pageNumber = page, selectedText = selectedText, noteText = noteText, createdAt = now, updatedAt = now))
    }

    suspend fun updateNote(note: NoteEntity, newText: String) {
        dao.update(note.copy(noteText = newText, updatedAt = System.currentTimeMillis()))
    }

    suspend fun deleteNote(note: NoteEntity) = dao.delete(note)
}
