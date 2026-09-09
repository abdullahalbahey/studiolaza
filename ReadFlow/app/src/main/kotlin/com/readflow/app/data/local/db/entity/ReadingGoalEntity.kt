package com.readflow.app.data.local.db.entity

import androidx.room.Entity
import androidx.room.ForeignKey
import androidx.room.Index
import androidx.room.PrimaryKey

@Entity(
    tableName = "reading_goals",
    foreignKeys = [
        ForeignKey(
            entity = BookEntity::class,
            parentColumns = ["id"],
            childColumns = ["bookId"],
            onDelete = ForeignKey.CASCADE
        )
    ],
    indices = [Index("bookId", unique = true)]
)
data class ReadingGoalEntity(
    @PrimaryKey(autoGenerate = true) val id: Long = 0,
    val bookId: Long,
    val targetPagesPerDay: Int? = null,
    val targetMinutesPerDay: Int? = null,
    val targetDate: Long? = null,
    val enabled: Boolean = true,
    val createdAt: Long
)
