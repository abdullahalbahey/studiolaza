package com.readflow.app.data.local.db.dao

import androidx.room.Dao
import androidx.room.Delete
import androidx.room.Insert
import androidx.room.Query
import androidx.room.Update
import com.readflow.app.data.local.db.entity.HighlightEntity
import kotlinx.coroutines.flow.Flow

@Dao
interface HighlightDao {
    @Insert
    suspend fun insert(highlight: HighlightEntity): Long

    @Update
    suspend fun update(highlight: HighlightEntity)

    @Delete
    suspend fun delete(highlight: HighlightEntity)

    @Query("SELECT * FROM highlights WHERE bookId = :bookId ORDER BY pageNumber ASC")
    fun observeForBook(bookId: Long): Flow<List<HighlightEntity>>

    @Query("SELECT * FROM highlights WHERE bookId = :bookId AND pageNumber = :page ORDER BY createdAt ASC")
    fun observeForPage(bookId: Long, page: Int): Flow<List<HighlightEntity>>
}
