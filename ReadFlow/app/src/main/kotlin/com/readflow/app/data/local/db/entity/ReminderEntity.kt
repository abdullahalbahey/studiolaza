package com.readflow.app.data.local.db.entity

import androidx.room.Entity
import androidx.room.ForeignKey
import androidx.room.Index
import androidx.room.PrimaryKey

/**
 * A reading reminder. [bookId] is null for a general "continue whatever you're reading"
 * reminder; when set, the notification opens that specific book.
 * [daysOfWeek] is a comma-separated list of [java.time.DayOfWeek] values (1=Monday..7=Sunday),
 * or blank to mean every day.
 */
@Entity(
    tableName = "reminders",
    foreignKeys = [
        ForeignKey(
            entity = BookEntity::class,
            parentColumns = ["id"],
            childColumns = ["bookId"],
            onDelete = ForeignKey.CASCADE
        )
    ],
    indices = [Index("bookId")]
)
data class ReminderEntity(
    @PrimaryKey(autoGenerate = true) val id: Long = 0,
    val bookId: Long? = null,
    val hour: Int,
    val minute: Int,
    val daysOfWeek: String,
    val enabled: Boolean = true,
    val message: String? = null,
    val dailyTargetPages: Int? = null
)
