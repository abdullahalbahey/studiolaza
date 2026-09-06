package com.readflow.app.data.local.db

import androidx.room.Room
import androidx.test.core.app.ApplicationProvider
import com.google.common.truth.Truth.assertThat
import com.readflow.app.data.local.db.entity.BookEntity
import com.readflow.app.data.local.db.entity.BookmarkEntity
import kotlinx.coroutines.flow.first
import kotlinx.coroutines.runBlocking
import org.junit.After
import org.junit.Before
import org.junit.Test
import org.junit.runner.RunWith
import org.robolectric.RobolectricTestRunner

@RunWith(RobolectricTestRunner::class)
class BookDaoTest {

    private lateinit var db: AppDatabase

    @Before
    fun setUp() {
        db = Room.inMemoryDatabaseBuilder(ApplicationProvider.getApplicationContext(), AppDatabase::class.java)
            .allowMainThreadQueries()
            .build()
    }

    @After
    fun tearDown() {
        db.close()
    }

    private fun sampleBook(hash: String = "hash-1") = BookEntity(
        title = "The Hard Thing About Hard Things",
        author = "Ben Horowitz",
        filePath = "/data/books/$hash.pdf",
        originalUri = null,
        coverPath = null,
        pageCount = 312,
        dateAdded = 1000L,
        fileHash = hash
    )

    @Test
    fun `insert and retrieve a book`() = runBlocking {
        val id = db.bookDao().insert(sampleBook())
        val loaded = db.bookDao().getBook(id)
        assertThat(loaded).isNotNull()
        assertThat(loaded!!.title).isEqualTo("The Hard Thing About Hard Things")
        assertThat(loaded.pageCount).isEqualTo(312)
    }

    @Test
    fun `findByHash returns the matching book for duplicate detection`() = runBlocking {
        db.bookDao().insert(sampleBook(hash = "abc123"))
        val found = db.bookDao().findByHash("abc123")
        val notFound = db.bookDao().findByHash("does-not-exist")
        assertThat(found).isNotNull()
        assertThat(notFound).isNull()
    }

    @Test
    fun `updateProgress persists page, percent, status and timestamp`() = runBlocking {
        val id = db.bookDao().insert(sampleBook())
        db.bookDao().updateProgress(id, page = 150, progress = 0.48f, timestamp = 5000L, status = "READING")
        val loaded = db.bookDao().getBook(id)
        assertThat(loaded!!.currentPage).isEqualTo(150)
        assertThat(loaded.progressPercent).isEqualTo(0.48f)
        assertThat(loaded.status).isEqualTo("READING")
        assertThat(loaded.lastOpened).isEqualTo(5000L)
    }

    @Test
    fun `addReadingTime accumulates rather than overwrites`() = runBlocking {
        val id = db.bookDao().insert(sampleBook())
        db.bookDao().addReadingTime(id, 60_000L)
        db.bookDao().addReadingTime(id, 30_000L)
        val loaded = db.bookDao().getBook(id)
        assertThat(loaded!!.totalReadingTimeMillis).isEqualTo(90_000L)
    }

    @Test
    fun `deleting a book cascades to its bookmarks`() = runBlocking {
        val id = db.bookDao().insert(sampleBook())
        db.bookmarkDao().insert(BookmarkEntity(bookId = id, pageNumber = 10, title = "Ch 1", createdAt = 1L))
        db.bookmarkDao().insert(BookmarkEntity(bookId = id, pageNumber = 42, title = null, createdAt = 2L))

        assertThat(db.bookmarkDao().observeForBook(id).first()).hasSize(2)

        db.bookDao().deleteById(id)

        assertThat(db.bookDao().getBook(id)).isNull()
        assertThat(db.bookmarkDao().observeForBook(id).first()).isEmpty()
    }

    @Test
    fun `observeAll reflects inserts and deletes`() = runBlocking {
        db.bookDao().insert(sampleBook(hash = "one"))
        db.bookDao().insert(sampleBook(hash = "two"))
        assertThat(db.bookDao().observeAll().first()).hasSize(2)

        db.bookDao().deleteAll()
        assertThat(db.bookDao().observeAll().first()).isEmpty()
    }
}
