package com.readflow.app.ui.navigation

sealed class Screen(val route: String) {
    object Onboarding : Screen("onboarding")
    object Main : Screen("main")

    object BookDetails : Screen("book_details/{bookId}") {
        fun createRoute(bookId: Long) = "book_details/$bookId"
    }

    object Reader : Screen("reader/{bookId}?startPage={startPage}") {
        fun createRoute(bookId: Long, startPage: Int? = null) = "reader/$bookId?startPage=${startPage ?: -1}"
    }

    object Bookmarks : Screen("bookmarks/{bookId}") {
        fun createRoute(bookId: Long) = "bookmarks/$bookId"
    }

    object Notes : Screen("notes/{bookId}") {
        fun createRoute(bookId: Long) = "notes/$bookId"
    }

    object Highlights : Screen("highlights/{bookId}") {
        fun createRoute(bookId: Long) = "highlights/$bookId"
    }

    object Stats : Screen("stats/{bookId}") {
        fun createRoute(bookId: Long) = "stats/$bookId"
    }

    object GoalEditor : Screen("goal_editor/{bookId}") {
        fun createRoute(bookId: Long) = "goal_editor/$bookId"
    }

    object ReminderEditor : Screen("reminder_editor?bookId={bookId}&reminderId={reminderId}") {
        fun createRoute(bookId: Long? = null, reminderId: Long? = null) =
            "reminder_editor?bookId=${bookId ?: -1}&reminderId=${reminderId ?: -1}"
    }
}

