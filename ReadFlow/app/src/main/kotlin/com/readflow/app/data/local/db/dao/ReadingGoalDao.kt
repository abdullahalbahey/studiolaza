package com.readflow.app.data.local.db.dao

import androidx.room.Dao
import androidx.room.Delete
import androidx.room.Insert
import androidx.room.OnConflictStrategy
import androidx.room.Query
import androidx.room.Update
import com.readflow.app.data.local.db.entity.ReadingGoalEntity
import kotlinx.coroutines.flow.Flow

@Dao
interface ReadingGoalDao {
    @Insert(onConflict = OnConflictStrategy.REPLACE)
    suspend fun upsert(goal: ReadingGoalEntity): Long

    @Update
    suspend fun update(goal: ReadingGoalEntity)

    @Delete
    suspend fun delete(goal: ReadingGoalEntity)

    @Query("SELECT * FROM reading_goals WHERE bookId = :bookId LIMIT 1")
    fun observeForBook(bookId: Long): Flow<ReadingGoalEntity?>

    @Query("SELECT * FROM reading_goals WHERE bookId = :bookId LIMIT 1")
    suspend fun getForBook(bookId: Long): ReadingGoalEntity?

    @Query("SELECT * FROM reading_goals WHERE enabled = 1")
    fun observeAllEnabled(): Flow<List<ReadingGoalEntity>>
}
