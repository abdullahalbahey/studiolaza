package com.readflow.app.data.repository

import com.readflow.app.data.local.db.dao.ReadingSessionDao
import com.readflow.app.data.local.db.entity.ReadingSessionEntity
import kotlinx.coroutines.flow.Flow
import javax.inject.Inject
import javax.inject.Singleton

@Singleton
class ReadingSessionRepository @Inject constructor(
    private val dao: ReadingSessionDao
) {
    fun observeForBook(bookId: Long): Flow<List<ReadingSessionEntity>> = dao.observeForBook(bookId)

    suspend fun getForBook(bookId: Long): List<ReadingSessionEntity> = dao.getForBook(bookId)

    suspend fun getAll(): List<ReadingSessionEntity> = dao.getAll()

    /** Records a finished reading session. Sessions shorter than a few seconds are still kept -
     * even a quick check of a page counts toward "number of sessions". */
    suspend fun recordSession(bookId: Long, startTime: Long, endTime: Long, pagesStarted: Int, pagesEnded: Int) {
        if (endTime <= startTime) return
        dao.insert(
            ReadingSessionEntity(
                bookId = bookId,
                startTime = startTime,
                endTime = endTime,
                pagesStarted = pagesStarted,
                pagesEnded = pagesEnded,
                durationMillis = endTime - startTime
            )
        )
    }
}
