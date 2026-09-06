package com.readflow.app.data.local.db.dao

import androidx.room.Dao
import androidx.room.Delete
import androidx.room.Insert
import androidx.room.OnConflictStrategy
import androidx.room.Query
import androidx.room.Update
import com.readflow.app.data.local.db.entity.BookEntity
import kotlinx.coroutines.flow.Flow

@Dao
interface BookDao {

    @Insert(onConflict = OnConflictStrategy.ABORT)
    suspend fun insert(book: BookEntity): Long

    @Update
    suspend fun update(book: BookEntity)

    @Delete
    suspend fun delete(book: BookEntity)

    @Query("SELECT * FROM books ORDER BY lastOpened DESC")
    fun observeAll(): Flow<List<BookEntity>>

    @Query("SELECT * FROM books")
    suspend fun getAllBooks(): List<BookEntity>

    @Query("SELECT * FROM books WHERE id = :bookId")
    fun observeBook(bookId: Long): Flow<BookEntity?>

    @Query("SELECT * FROM books WHERE id = :bookId")
    suspend fun getBook(bookId: Long): BookEntity?

    @Query("SELECT * FROM books WHERE fileHash = :fileHash LIMIT 1")
    suspend fun findByHash(fileHash: String): BookEntity?

    @Query("UPDATE books SET currentPage = :page, progressPercent = :progress, lastOpened = :timestamp, status = :status WHERE id = :bookId")
    suspend fun updateProgress(bookId: Long, page: Int, progress: Float, timestamp: Long, status: String)

    @Query("UPDATE books SET totalReadingTimeMillis = totalReadingTimeMillis + :deltaMillis WHERE id = :bookId")
    suspend fun addReadingTime(bookId: Long, deltaMillis: Long)

    @Query("UPDATE books SET isIndexed = :indexed, hasExtractableText = :hasText WHERE id = :bookId")
    suspend fun updateIndexingState(bookId: Long, indexed: Boolean, hasText: Boolean)

    @Query("UPDATE books SET viewMode = :viewMode WHERE id = :bookId")
    suspend fun updateViewMode(bookId: Long, viewMode: String)

    @Query("UPDATE books SET readingModeEnabled = :enabled WHERE id = :bookId")
    suspend fun updateReadingModeEnabled(bookId: Long, enabled: Boolean)

    @Query("UPDATE books SET zoomLevel = :zoom WHERE id = :bookId")
    suspend fun updateZoom(bookId: Long, zoom: Float)

    @Query("UPDATE books SET coverPath = :coverPath WHERE id = :bookId")
    suspend fun updateCoverPath(bookId: Long, coverPath: String?)

    @Query("DELETE FROM books WHERE id = :bookId")
    suspend fun deleteById(bookId: Long)

    @Query("DELETE FROM books")
    suspend fun deleteAll()

    @Query("SELECT COUNT(*) FROM books")
    fun observeCount(): Flow<Int>
}
