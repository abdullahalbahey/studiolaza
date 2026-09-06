package com.readflow.app.data.local.db.dao

import androidx.room.Dao
import androidx.room.Insert
import androidx.room.Query
import com.readflow.app.data.local.db.entity.TocEntryEntity
import kotlinx.coroutines.flow.Flow

@Dao
interface TocEntryDao {
    @Insert
    suspend fun insertAll(entries: List<TocEntryEntity>)

    @Query("SELECT * FROM toc_entries WHERE bookId = :bookId ORDER BY orderIndex ASC")
    fun observeForBook(bookId: Long): Flow<List<TocEntryEntity>>

    @Query("SELECT COUNT(*) FROM toc_entries WHERE bookId = :bookId")
    suspend fun countForBook(bookId: Long): Int

    @Query("DELETE FROM toc_entries WHERE bookId = :bookId")
    suspend fun deleteForBook(bookId: Long)
}
