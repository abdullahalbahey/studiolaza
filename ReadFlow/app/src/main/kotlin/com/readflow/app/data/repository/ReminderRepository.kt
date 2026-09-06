package com.readflow.app.data.repository

import com.readflow.app.data.local.db.dao.ReminderDao
import com.readflow.app.data.local.db.entity.ReminderEntity
import com.readflow.app.reminders.AlarmScheduler
import kotlinx.coroutines.flow.Flow
import javax.inject.Inject
import javax.inject.Singleton

@Singleton
class ReminderRepository @Inject constructor(
    private val dao: ReminderDao,
    private val alarmScheduler: AlarmScheduler
) {
    fun observeAll(): Flow<List<ReminderEntity>> = dao.observeAll()
    fun observeForBook(bookId: Long): Flow<List<ReminderEntity>> = dao.observeForBook(bookId)
    suspend fun getById(id: Long): ReminderEntity? = dao.getById(id)

    fun canScheduleExactAlarms(): Boolean = alarmScheduler.canScheduleExactAlarms()

    suspend fun saveReminder(
        id: Long?,
        bookId: Long?,
        hour: Int,
        minute: Int,
        daysOfWeek: String,
        enabled: Boolean,
        message: String?,
        dailyTargetPages: Int?
    ): Long {
        val reminder = ReminderEntity(
            id = id ?: 0,
            bookId = bookId,
            hour = hour,
            minute = minute,
            daysOfWeek = daysOfWeek,
            enabled = enabled,
            message = message,
            dailyTargetPages = dailyTargetPages
        )
        val savedId = if (id == null) dao.insert(reminder) else {
            dao.update(reminder)
            id
        }
        alarmScheduler.schedule(reminder.copy(id = savedId))
        return savedId
    }

    suspend fun setEnabled(reminder: ReminderEntity, enabled: Boolean) {
        val updated = reminder.copy(enabled = enabled)
        dao.update(updated)
        alarmScheduler.schedule(updated)
    }

    suspend fun deleteReminder(reminder: ReminderEntity) {
        alarmScheduler.cancel(reminder.id)
        dao.delete(reminder)
    }
}
