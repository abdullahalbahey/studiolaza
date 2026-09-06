package com.readflow.app.data.backup

import com.readflow.app.data.local.db.dao.BookDao
import com.readflow.app.data.local.db.dao.BookmarkDao
import com.readflow.app.data.local.db.dao.HighlightDao
import com.readflow.app.data.local.db.dao.NoteDao
import com.readflow.app.data.local.db.dao.ReadingGoalDao
import com.readflow.app.data.local.db.entity.BookmarkEntity
import com.readflow.app.data.local.db.entity.HighlightEntity
import com.readflow.app.data.local.db.entity.NoteEntity
import com.readflow.app.data.local.db.entity.ReadingGoalEntity
import com.readflow.app.data.repository.ReminderRepository
import kotlinx.coroutines.flow.first
import org.json.JSONArray
import org.json.JSONObject
import javax.inject.Inject
import javax.inject.Singleton

data class ImportSummary(val booksMatched: Int, val booksSkipped: Int)

/**
 * Exports/imports reading data (progress, bookmarks, notes, highlights, goals, reminders) as a
 * portable JSON file. The PDFs themselves are never included - only the local device holds
 * those - so import matches entries back to books already in this library by file hash.
 */
@Singleton
class BackupManager @Inject constructor(
    private val bookDao: BookDao,
    private val bookmarkDao: BookmarkDao,
    private val noteDao: NoteDao,
    private val highlightDao: HighlightDao,
    private val readingGoalDao: ReadingGoalDao,
    private val reminderRepository: ReminderRepository
) {
    suspend fun export(): String {
        val books = bookDao.getAllBooks()
        val booksJson = JSONArray()
        for (book in books) {
            val bookmarks = bookmarkDao.observeForBook(book.id).first()
            val notes = noteDao.observeForBook(book.id).first()
            val highlights = highlightDao.observeForBook(book.id).first()
            val goal = readingGoalDao.observeForBook(book.id).first()
            val reminders = reminderRepository.observeForBook(book.id).first()

            val bookJson = JSONObject().apply {
                put("fileHash", book.fileHash)
                put("title", book.title)
                put("author", book.author ?: JSONObject.NULL)
                put("pageCount", book.pageCount)
                put("currentPage", book.currentPage)
                put("progressPercent", book.progressPercent.toDouble())
                put("dateAdded", book.dateAdded)
                put("lastOpened", book.lastOpened ?: JSONObject.NULL)
                put("totalReadingTimeMillis", book.totalReadingTimeMillis)
                put("status", book.status)
                put("bookmarks", JSONArray(bookmarks.map {
                    JSONObject().put("pageNumber", it.pageNumber).put("title", it.title ?: JSONObject.NULL).put("createdAt", it.createdAt)
                }))
                put("notes", JSONArray(notes.map {
                    JSONObject().put("pageNumber", it.pageNumber).put("selectedText", it.selectedText ?: JSONObject.NULL)
                        .put("noteText", it.noteText).put("createdAt", it.createdAt).put("updatedAt", it.updatedAt)
                }))
                put("highlights", JSONArray(highlights.map {
                    JSONObject().put("pageNumber", it.pageNumber).put("selectedText", it.selectedText).put("color", it.color).put("createdAt", it.createdAt)
                }))
                put("goal", goal?.let {
                    JSONObject().put("targetPagesPerDay", it.targetPagesPerDay ?: JSONObject.NULL)
                        .put("targetMinutesPerDay", it.targetMinutesPerDay ?: JSONObject.NULL)
                        .put("targetDate", it.targetDate ?: JSONObject.NULL)
                } ?: JSONObject.NULL)
                put("reminders", JSONArray(reminders.map {
                    JSONObject().put("hour", it.hour).put("minute", it.minute).put("daysOfWeek", it.daysOfWeek)
                        .put("enabled", it.enabled).put("message", it.message ?: JSONObject.NULL)
                        .put("dailyTargetPages", it.dailyTargetPages ?: JSONObject.NULL)
                }))
            }
            booksJson.put(bookJson)
        }
        return JSONObject()
            .put("version", 1)
            .put("exportedAt", System.currentTimeMillis())
            .put("books", booksJson)
            .toString(2)
    }

    suspend fun import(json: String): ImportSummary {
        val root = JSONObject(json)
        val booksJson = root.optJSONArray("books") ?: JSONArray()
        var matched = 0
        var skipped = 0

        for (i in 0 until booksJson.length()) {
            val entry = booksJson.getJSONObject(i)
            val fileHash = entry.optString("fileHash", "")
            val localBook = if (fileHash.isNotBlank()) bookDao.findByHash(fileHash) else null
            if (localBook == null) {
                skipped++
                continue
            }
            matched++

            val importedCurrentPage = entry.optInt("currentPage", localBook.currentPage)
            val importedProgress = entry.optDouble("progressPercent", localBook.progressPercent.toDouble()).toFloat()
            val importedReadingTime = entry.optLong("totalReadingTimeMillis", localBook.totalReadingTimeMillis)
            if (importedCurrentPage > localBook.currentPage) {
                bookDao.updateProgress(localBook.id, importedCurrentPage, importedProgress, System.currentTimeMillis(), localBook.status)
            }
            if (importedReadingTime > localBook.totalReadingTimeMillis) {
                bookDao.addReadingTime(localBook.id, importedReadingTime - localBook.totalReadingTimeMillis)
            }

            entry.optJSONArray("bookmarks")?.let { array ->
                for (j in 0 until array.length()) {
                    val b = array.getJSONObject(j)
                    bookmarkDao.insert(
                        BookmarkEntity(
                            bookId = localBook.id,
                            pageNumber = b.getInt("pageNumber"),
                            title = b.optString("title", null),
                            createdAt = b.optLong("createdAt", System.currentTimeMillis())
                        )
                    )
                }
            }
            entry.optJSONArray("notes")?.let { array ->
                for (j in 0 until array.length()) {
                    val n = array.getJSONObject(j)
                    noteDao.insert(
                        NoteEntity(
                            bookId = localBook.id,
                            pageNumber = n.getInt("pageNumber"),
                            selectedText = n.optString("selectedText", null),
                            noteText = n.getString("noteText"),
                            createdAt = n.optLong("createdAt", System.currentTimeMillis()),
                            updatedAt = n.optLong("updatedAt", System.currentTimeMillis())
                        )
                    )
                }
            }
            entry.optJSONArray("highlights")?.let { array ->
                for (j in 0 until array.length()) {
                    val h = array.getJSONObject(j)
                    highlightDao.insert(
                        HighlightEntity(
                            bookId = localBook.id,
                            pageNumber = h.getInt("pageNumber"),
                            selectedText = h.getString("selectedText"),
                            color = h.optString("color", "YELLOW"),
                            createdAt = h.optLong("createdAt", System.currentTimeMillis())
                        )
                    )
                }
            }
            entry.optJSONObject("goal")?.let { g ->
                if (readingGoalDao.getForBook(localBook.id) == null) {
                    readingGoalDao.upsert(
                        ReadingGoalEntity(
                            bookId = localBook.id,
                            targetPagesPerDay = g.optInt("targetPagesPerDay", -1).takeIf { it > 0 },
                            targetMinutesPerDay = g.optInt("targetMinutesPerDay", -1).takeIf { it > 0 },
                            targetDate = if (g.isNull("targetDate")) null else g.optLong("targetDate"),
                            createdAt = System.currentTimeMillis()
                        )
                    )
                }
            }
            entry.optJSONArray("reminders")?.let { array ->
                for (j in 0 until array.length()) {
                    val r = array.getJSONObject(j)
                    reminderRepository.saveReminder(
                        id = null,
                        bookId = localBook.id,
                        hour = r.getInt("hour"),
                        minute = r.getInt("minute"),
                        daysOfWeek = r.optString("daysOfWeek", ""),
                        enabled = r.optBoolean("enabled", true),
                        message = r.optString("message", null),
                        dailyTargetPages = r.optInt("dailyTargetPages", -1).takeIf { it > 0 }
                    )
                }
            }
        }
        return ImportSummary(booksMatched = matched, booksSkipped = skipped)
    }
}
