package com.readflow.app.data.local.db.dao

import androidx.room.Dao
import androidx.room.Insert
import androidx.room.Query
import com.readflow.app.data.local.db.entity.ReadingSessionEntity
import kotlinx.coroutines.flow.Flow

@Dao
interface ReadingSessionDao {
    @Insert
    suspend fun insert(session: ReadingSessionEntity): Long

    @Query("SELECT * FROM reading_sessions WHERE bookId = :bookId ORDER BY startTime DESC")
    fun observeForBook(bookId: Long): Flow<List<ReadingSessionEntity>>

    @Query("SELECT * FROM reading_sessions WHERE bookId = :bookId ORDER BY startTime DESC")
    suspend fun getForBook(bookId: Long): List<ReadingSessionEntity>

    @Query("SELECT * FROM reading_sessions ORDER BY startTime DESC")
    suspend fun getAll(): List<ReadingSessionEntity>

    @Query("SELECT * FROM reading_sessions ORDER BY startTime DESC")
    fun observeAll(): Flow<List<ReadingSessionEntity>>
}
