package com.readflow.app.data.local.db.dao

import androidx.room.Dao
import androidx.room.Insert
import androidx.room.OnConflictStrategy
import androidx.room.Query
import com.readflow.app.data.local.db.entity.PageTextEntity

@Dao
interface PageTextDao {
    @Insert(onConflict = OnConflictStrategy.REPLACE)
    suspend fun insert(pageText: PageTextEntity)

    @Insert(onConflict = OnConflictStrategy.REPLACE)
    suspend fun insertAll(pages: List<PageTextEntity>)

    @Query("SELECT * FROM page_text WHERE bookId = :bookId AND pageNumber = :page LIMIT 1")
    suspend fun getPage(bookId: Long, page: Int): PageTextEntity?

    @Query("SELECT COUNT(*) FROM page_text WHERE bookId = :bookId")
    suspend fun countForBook(bookId: Long): Int

    @Query("SELECT * FROM page_text WHERE bookId = :bookId AND text LIKE '%' || :query || '%' ORDER BY pageNumber ASC")
    suspend fun search(bookId: Long, query: String): List<PageTextEntity>

    @Query("SELECT * FROM page_text WHERE bookId = :bookId ORDER BY pageNumber ASC")
    suspend fun getAllForBook(bookId: Long): List<PageTextEntity>
}
