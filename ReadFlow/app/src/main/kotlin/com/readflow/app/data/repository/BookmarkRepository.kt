package com.readflow.app.data.repository

import com.readflow.app.data.local.db.dao.BookmarkDao
import com.readflow.app.data.local.db.entity.BookmarkEntity
import kotlinx.coroutines.flow.Flow
import javax.inject.Inject
import javax.inject.Singleton

@Singleton
class BookmarkRepository @Inject constructor(
    private val dao: BookmarkDao
) {
    fun observeForBook(bookId: Long): Flow<List<BookmarkEntity>> = dao.observeForBook(bookId)

    suspend fun toggleBookmark(bookId: Long, page: Int, title: String?): Boolean {
        val existing = dao.findForPage(bookId, page)
        return if (existing != null) {
            dao.delete(existing)
            false
        } else {
            dao.insert(BookmarkEntity(bookId = bookId, pageNumber = page, title = title, createdAt = System.currentTimeMillis()))
            true
        }
    }

    suspend fun isBookmarked(bookId: Long, page: Int): Boolean = dao.findForPage(bookId, page) != null

    suspend fun delete(bookmark: BookmarkEntity) = dao.delete(bookmark)
}
