package com.readflow.app.data.repository

import com.readflow.app.data.local.db.dao.ReadingGoalDao
import com.readflow.app.data.local.db.entity.ReadingGoalEntity
import kotlinx.coroutines.flow.Flow
import javax.inject.Inject
import javax.inject.Singleton

@Singleton
class ReadingGoalRepository @Inject constructor(
    private val dao: ReadingGoalDao
) {
    fun observeForBook(bookId: Long): Flow<ReadingGoalEntity?> = dao.observeForBook(bookId)

    fun observeAllEnabled(): Flow<List<ReadingGoalEntity>> = dao.observeAllEnabled()

    suspend fun getForBook(bookId: Long): ReadingGoalEntity? = dao.getForBook(bookId)

    suspend fun setGoal(
        bookId: Long,
        targetPagesPerDay: Int?,
        targetMinutesPerDay: Int?,
        targetDate: Long?
    ) {
        val existing = dao.getForBook(bookId)
        val goal = (existing ?: ReadingGoalEntity(bookId = bookId, createdAt = System.currentTimeMillis())).copy(
            targetPagesPerDay = targetPagesPerDay,
            targetMinutesPerDay = targetMinutesPerDay,
            targetDate = targetDate,
            enabled = true
        )
        dao.upsert(goal)
    }

    suspend fun clearGoal(bookId: Long) {
        dao.getForBook(bookId)?.let { dao.delete(it) }
    }
}
