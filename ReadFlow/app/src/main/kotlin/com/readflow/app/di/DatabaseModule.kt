package com.readflow.app.di

import android.content.Context
import androidx.room.Room
import com.readflow.app.data.local.db.AppDatabase
import com.readflow.app.data.local.db.dao.BookDao
import com.readflow.app.data.local.db.dao.BookmarkDao
import com.readflow.app.data.local.db.dao.HighlightDao
import com.readflow.app.data.local.db.dao.NoteDao
import com.readflow.app.data.local.db.dao.PageTextDao
import com.readflow.app.data.local.db.dao.ReadingGoalDao
import com.readflow.app.data.local.db.dao.ReadingSessionDao
import com.readflow.app.data.local.db.dao.ReminderDao
import com.readflow.app.data.local.db.dao.TocEntryDao
import dagger.Module
import dagger.Provides
import dagger.hilt.InstallIn
import dagger.hilt.android.qualifiers.ApplicationContext
import dagger.hilt.components.SingletonComponent
import javax.inject.Singleton

@Module
@InstallIn(SingletonComponent::class)
object DatabaseModule {

    @Provides
    @Singleton
    fun provideDatabase(@ApplicationContext context: Context): AppDatabase =
        Room.databaseBuilder(context, AppDatabase::class.java, AppDatabase.DATABASE_NAME)
            .fallbackToDestructiveMigration()
            .build()

    @Provides
    fun provideBookDao(db: AppDatabase): BookDao = db.bookDao()

    @Provides
    fun provideBookmarkDao(db: AppDatabase): BookmarkDao = db.bookmarkDao()

    @Provides
    fun provideNoteDao(db: AppDatabase): NoteDao = db.noteDao()

    @Provides
    fun provideHighlightDao(db: AppDatabase): HighlightDao = db.highlightDao()

    @Provides
    fun provideReadingSessionDao(db: AppDatabase): ReadingSessionDao = db.readingSessionDao()

    @Provides
    fun provideReadingGoalDao(db: AppDatabase): ReadingGoalDao = db.readingGoalDao()

    @Provides
    fun provideReminderDao(db: AppDatabase): ReminderDao = db.reminderDao()

    @Provides
    fun provideTocEntryDao(db: AppDatabase): TocEntryDao = db.tocEntryDao()

    @Provides
    fun providePageTextDao(db: AppDatabase): PageTextDao = db.pageTextDao()
}
