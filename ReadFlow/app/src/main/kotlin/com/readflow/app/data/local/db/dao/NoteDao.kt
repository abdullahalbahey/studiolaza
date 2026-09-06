package com.readflow.app.data.local.db.dao

import androidx.room.Dao
import androidx.room.Delete
import androidx.room.Insert
import androidx.room.Query
import androidx.room.Update
import com.readflow.app.data.local.db.entity.NoteEntity
import kotlinx.coroutines.flow.Flow

@Dao
interface NoteDao {
    @Insert
    suspend fun insert(note: NoteEntity): Long

    @Update
    suspend fun update(note: NoteEntity)

    @Delete
    suspend fun delete(note: NoteEntity)

    @Query("SELECT * FROM notes WHERE bookId = :bookId ORDER BY pageNumber ASC")
    fun observeForBook(bookId: Long): Flow<List<NoteEntity>>

    @Query("SELECT * FROM notes WHERE bookId = :bookId AND pageNumber = :page ORDER BY createdAt ASC")
    fun observeForPage(bookId: Long, page: Int): Flow<List<NoteEntity>>

    @Query("SELECT COUNT(*) FROM notes WHERE bookId = :bookId")
    fun observeCountForBook(bookId: Long): Flow<Int>
}
