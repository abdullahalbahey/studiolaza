package com.readflow.app.data.local.db

import androidx.room.Database
import androidx.room.RoomDatabase
import com.readflow.app.data.local.db.dao.BookDao
import com.readflow.app.data.local.db.dao.BookmarkDao
import com.readflow.app.data.local.db.dao.HighlightDao
import com.readflow.app.data.local.db.dao.NoteDao
import com.readflow.app.data.local.db.dao.PageTextDao
import com.readflow.app.data.local.db.dao.ReadingGoalDao
import com.readflow.app.data.local.db.dao.ReadingSessionDao
import com.readflow.app.data.local.db.dao.ReminderDao
import com.readflow.app.data.local.db.dao.TocEntryDao
import com.readflow.app.data.local.db.entity.BookEntity
import com.readflow.app.data.local.db.entity.BookmarkEntity
import com.readflow.app.data.local.db.entity.HighlightEntity
import com.readflow.app.data.local.db.entity.NoteEntity
import com.readflow.app.data.local.db.entity.PageTextEntity
import com.readflow.app.data.local.db.entity.ReadingGoalEntity
import com.readflow.app.data.local.db.entity.ReadingSessionEntity
import com.readflow.app.data.local.db.entity.ReminderEntity
import com.readflow.app.data.local.db.entity.TocEntryEntity

@Database(
    entities = [
        BookEntity::class,
        BookmarkEntity::class,
        NoteEntity::class,
        HighlightEntity::class,
        ReadingSessionEntity::class,
        ReadingGoalEntity::class,
        ReminderEntity::class,
        TocEntryEntity::class,
        PageTextEntity::class
    ],
    version = 1,
    exportSchema = true
)
abstract class AppDatabase : RoomDatabase() {
    abstract fun bookDao(): BookDao
    abstract fun bookmarkDao(): BookmarkDao
    abstract fun noteDao(): NoteDao
    abstract fun highlightDao(): HighlightDao
    abstract fun readingSessionDao(): ReadingSessionDao
    abstract fun readingGoalDao(): ReadingGoalDao
    abstract fun reminderDao(): ReminderDao
    abstract fun tocEntryDao(): TocEntryDao
    abstract fun pageTextDao(): PageTextDao

    companion object {
        const val DATABASE_NAME = "readflow.db"
    }
}
