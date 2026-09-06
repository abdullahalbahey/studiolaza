package com.readflow.app.data.repository

import com.readflow.app.data.local.db.dao.BookDao
import com.readflow.app.data.local.db.dao.PageTextDao
import com.readflow.app.data.local.db.dao.TocEntryDao
import com.readflow.app.data.local.db.entity.PageTextEntity
import com.readflow.app.data.local.db.entity.TocEntryEntity
import com.readflow.app.data.pdf.PdfTextExtractor
import com.readflow.app.di.ApplicationScope
import kotlinx.coroutines.CoroutineScope
import kotlinx.coroutines.Dispatchers
import kotlinx.coroutines.flow.Flow
import kotlinx.coroutines.launch
import kotlinx.coroutines.withContext
import javax.inject.Inject
import javax.inject.Singleton

data class SearchResult(val pageNumber: Int, val snippet: String)

/**
 * Owns everything derived from a book's extractable text: the cached per-page text used by
 * search and Reading Mode, and the table of contents. Extraction is lazy per-page (so opening
 * a book never blocks on the whole file) and backfilled for the whole book in the background
 * right after import so search works everywhere once it finishes.
 */
@Singleton
class BookContentRepository @Inject constructor(
    private val pageTextDao: PageTextDao,
    private val tocEntryDao: TocEntryDao,
    private val bookDao: BookDao,
    private val textExtractor: PdfTextExtractor,
    @ApplicationScope private val appScope: CoroutineScope
) {

    fun observeToc(bookId: Long): Flow<List<TocEntryEntity>> = tocEntryDao.observeForBook(bookId)

    suspend fun getPageText(bookId: Long, filePath: String, pageIndex: Int): String? {
        pageTextDao.getPage(bookId, pageIndex)?.let { return it.text }
        val extracted = withContext(Dispatchers.IO) { textExtractor.extractPageText(filePath, pageIndex) }
        if (extracted != null) {
            pageTextDao.insert(PageTextEntity(bookId, pageIndex, extracted))
        }
        return extracted
    }

    suspend fun search(bookId: Long, filePath: String, query: String): List<SearchResult> {
        if (query.isBlank()) return emptyList()
        val book = bookDao.getBook(bookId)
        if (book?.isIndexed != true) {
            // Not indexed yet (e.g. indexing still running, or it failed silently) - index now
            // so this search attempt can return complete results.
            indexBookNow(bookId, filePath)
        }
        val matches = pageTextDao.search(bookId, query)
        return matches.map { SearchResult(it.pageNumber, buildSnippet(it.text, query)) }
    }

    fun indexBookInBackground(bookId: Long, filePath: String) {
        appScope.launch(Dispatchers.IO) {
            indexBookNow(bookId, filePath)
        }
    }

    private suspend fun indexBookNow(bookId: Long, filePath: String) = withContext(Dispatchers.IO) {
        val pages = textExtractor.extractAllPagesText(filePath)
        val hasText = pages?.values?.any { it.length > 40 } ?: false
        if (pages != null) {
            val entities = pages.map { (index, text) -> PageTextEntity(bookId, index, text) }
            pageTextDao.insertAll(entities)
        }
        if (tocEntryDao.countForBook(bookId) == 0) {
            val toc = textExtractor.extractToc(filePath)
            if (toc.isNotEmpty()) {
                tocEntryDao.insertAll(
                    toc.mapIndexed { index, node ->
                        TocEntryEntity(
                            bookId = bookId,
                            title = node.title,
                            pageNumber = node.pageNumber,
                            level = node.level,
                            orderIndex = index
                        )
                    }
                )
            }
        }
        bookDao.updateIndexingState(bookId, indexed = true, hasText = hasText)
    }

    private fun buildSnippet(pageText: String, query: String): String {
        val index = pageText.indexOf(query, ignoreCase = true)
        if (index < 0) return pageText.take(120)
        val start = (index - 40).coerceAtLeast(0)
        val end = (index + query.length + 40).coerceAtMost(pageText.length)
        val prefix = if (start > 0) "…" else ""
        val suffix = if (end < pageText.length) "…" else ""
        return prefix + pageText.substring(start, end).trim() + suffix
    }
}
