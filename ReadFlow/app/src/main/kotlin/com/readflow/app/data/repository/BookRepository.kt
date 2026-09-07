package com.readflow.app.data.repository

import android.net.Uri
import com.readflow.app.data.local.db.dao.BookDao
import com.readflow.app.data.local.db.entity.BookEntity
import com.readflow.app.data.local.db.entity.BookStatus
import com.readflow.app.data.pdf.ImportedPdfInfo
import com.readflow.app.data.pdf.PdfImporter
import com.readflow.app.domain.ProgressCalculator
import kotlinx.coroutines.flow.Flow
import javax.inject.Inject
import javax.inject.Singleton

sealed interface ImportOutcome {
    data class Success(val bookId: Long) : ImportOutcome
    data class Duplicate(val existingBookId: Long, val pendingUri: Uri, val pendingDisplayName: String?) : ImportOutcome
    data class Failed(val message: String) : ImportOutcome
}

sealed interface DriveBookImportResult {
    data class Success(val bookId: Long) : DriveBookImportResult
    data class Duplicate(val existingBookId: Long) : DriveBookImportResult
}

enum class DuplicateResolution { OPEN_EXISTING, REPLACE, IMPORT_ANYWAY }

@Singleton
class BookRepository @Inject constructor(
    private val bookDao: BookDao,
    private val pdfImporter: PdfImporter,
    private val bookContentRepository: BookContentRepository
) {

    fun observeBooks(): Flow<List<BookEntity>> = bookDao.observeAll()

    fun observeBook(bookId: Long): Flow<BookEntity?> = bookDao.observeBook(bookId)

    suspend fun getBook(bookId: Long): BookEntity? = bookDao.getBook(bookId)

    suspend fun importBook(uri: Uri, displayName: String?): ImportOutcome {
        return try {
            val info = pdfImporter.importFromUri(uri, displayName)
            val existing = bookDao.findByHash(info.fileHash)
            if (existing != null) {
                pdfImporter.deleteBookFiles(info.filePath, info.coverPath)
                ImportOutcome.Duplicate(existing.id, uri, displayName)
            } else {
                val bookId = insertNewBook(info)
                ImportOutcome.Success(bookId)
            }
        } catch (e: Throwable) {
            ImportOutcome.Failed(e.message ?: "Import failed")
        }
    }

    /** Called after the user picks how to resolve a detected duplicate. */
    suspend fun resolveDuplicateImport(
        uri: Uri,
        displayName: String?,
        resolution: DuplicateResolution,
        existingBookId: Long
    ): ImportOutcome {
        return when (resolution) {
            DuplicateResolution.OPEN_EXISTING -> ImportOutcome.Success(existingBookId)
            DuplicateResolution.REPLACE -> {
                try {
                    val info = pdfImporter.importFromUri(uri, displayName)
                    val existing = bookDao.getBook(existingBookId)
                    if (existing != null) {
                        pdfImporter.deleteBookFiles(existing.filePath, existing.coverPath)
                        val replaced = existing.copy(
                            filePath = info.filePath,
                            title = info.title,
                            author = info.author,
                            pageCount = info.pageCount,
                            coverPath = info.coverPath,
                            hasExtractableText = info.hasExtractableText,
                            fileSizeBytes = info.fileSizeBytes,
                            fileHash = info.fileHash,
                            currentPage = 0,
                            progressPercent = 0f,
                            isIndexed = false,
                            status = BookStatus.NOT_STARTED.name
                        )
                        bookDao.update(replaced)
                        bookContentRepository.indexBookInBackground(replaced.id, replaced.filePath)
                        ImportOutcome.Success(existingBookId)
                    } else {
                        val bookId = insertNewBook(info)
                        ImportOutcome.Success(bookId)
                    }
                } catch (e: Throwable) {
                    ImportOutcome.Failed(e.message ?: "Import failed")
                }
            }
            DuplicateResolution.IMPORT_ANYWAY -> {
                try {
                    val info = pdfImporter.importFromUri(uri, displayName)
                    val bookId = insertNewBook(info)
                    ImportOutcome.Success(bookId)
                } catch (e: Throwable) {
                    ImportOutcome.Failed(e.message ?: "Import failed")
                }
            }
        }
    }

    /** Records a book already downloaded and imported from Drive (bytes already on disk as [info]). */
    suspend fun importDriveBook(info: ImportedPdfInfo): DriveBookImportResult {
        val existing = bookDao.findByHash(info.fileHash)
        return if (existing != null) {
            pdfImporter.deleteBookFiles(info.filePath, info.coverPath)
            DriveBookImportResult.Duplicate(existing.id)
        } else {
            DriveBookImportResult.Success(insertNewBook(info))
        }
    }

    private suspend fun insertNewBook(info: ImportedPdfInfo): Long {
        val book = BookEntity(
            title = info.title,
            author = info.author,
            filePath = info.filePath,
            originalUri = null,
            coverPath = info.coverPath,
            pageCount = info.pageCount,
            currentPage = 0,
            progressPercent = 0f,
            dateAdded = System.currentTimeMillis(),
            hasExtractableText = info.hasExtractableText,
            fileSizeBytes = info.fileSizeBytes,
            fileHash = info.fileHash
        )
        val bookId = bookDao.insert(book)
        bookContentRepository.indexBookInBackground(bookId, info.filePath)
        return bookId
    }

    suspend fun markOpened(bookId: Long) {
        val book = bookDao.getBook(bookId) ?: return
        bookDao.update(book.copy(lastOpened = System.currentTimeMillis()))
    }

    suspend fun updateProgress(bookId: Long, page: Int) {
        val book = bookDao.getBook(bookId) ?: return
        val progress = ProgressCalculator.percentComplete(page, book.pageCount)
        val status = ProgressCalculator.statusFor(page, book.pageCount)
        bookDao.updateProgress(bookId, page, progress, System.currentTimeMillis(), status.name)
    }

    suspend fun addReadingTime(bookId: Long, deltaMillis: Long) {
        if (deltaMillis <= 0) return
        bookDao.addReadingTime(bookId, deltaMillis)
    }

    suspend fun setViewMode(bookId: Long, viewMode: String) = bookDao.updateViewMode(bookId, viewMode)

    suspend fun setReadingModeEnabled(bookId: Long, enabled: Boolean) = bookDao.updateReadingModeEnabled(bookId, enabled)

    suspend fun setZoom(bookId: Long, zoom: Float) = bookDao.updateZoom(bookId, zoom)

    suspend fun deleteBook(bookId: Long) {
        val book = bookDao.getBook(bookId) ?: return
        pdfImporter.deleteBookFiles(book.filePath, book.coverPath)
        bookDao.deleteById(bookId)
    }

    suspend fun deleteAllBooks() {
        val all = bookDao.getAllBooks()
        all.forEach { pdfImporter.deleteBookFiles(it.filePath, it.coverPath) }
        bookDao.deleteAll()
    }
}
