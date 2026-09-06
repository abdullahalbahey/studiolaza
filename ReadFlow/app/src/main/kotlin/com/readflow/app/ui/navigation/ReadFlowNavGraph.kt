package com.readflow.app.ui.navigation

import android.net.Uri
import androidx.compose.runtime.Composable
import androidx.compose.runtime.LaunchedEffect
import androidx.navigation.NavHostController
import androidx.navigation.NavType
import androidx.navigation.compose.NavHost
import androidx.navigation.compose.composable
import androidx.navigation.compose.rememberNavController
import androidx.navigation.navArgument
import com.readflow.app.ui.bookdetails.BookDetailsScreen
import com.readflow.app.ui.bookmarks.BookmarksScreen
import com.readflow.app.ui.goals.GoalEditorScreen
import com.readflow.app.ui.highlights.HighlightsScreen
import com.readflow.app.ui.main.MainScreen
import com.readflow.app.ui.notes.NotesScreen
import com.readflow.app.ui.onboarding.OnboardingScreen
import com.readflow.app.ui.reader.ReaderScreen
import com.readflow.app.ui.reminders.ReminderEditorScreen
import com.readflow.app.ui.stats.StatsScreen

@Composable
fun ReadFlowNavGraph(
    onboardingCompleted: Boolean,
    deepLinkBookId: Long?,
    onDeepLinkConsumed: () -> Unit,
    importUri: Uri? = null,
    onImportUriConsumed: () -> Unit = {},
    navController: NavHostController = rememberNavController()
) {
    val startDestination = if (onboardingCompleted) Screen.Main.route else Screen.Onboarding.route

    LaunchedEffect(deepLinkBookId) {
        if (deepLinkBookId != null && deepLinkBookId > 0) {
            navController.navigate(Screen.Reader.createRoute(deepLinkBookId))
            onDeepLinkConsumed()
        }
    }

    NavHost(navController = navController, startDestination = startDestination) {
        composable(Screen.Onboarding.route) {
            OnboardingScreen(
                onFinished = {
                    navController.navigate(Screen.Main.route) {
                        popUpTo(Screen.Onboarding.route) { inclusive = true }
                    }
                }
            )
        }

        composable(Screen.Main.route) {
            MainScreen(
                onOpenBook = { bookId -> navController.navigate(Screen.BookDetails.createRoute(bookId)) },
                onOpenReaderDirect = { bookId -> navController.navigate(Screen.Reader.createRoute(bookId)) },
                pendingImportUri = importUri,
                onImportUriConsumed = onImportUriConsumed
            )
        }

        composable(
            route = Screen.BookDetails.route,
            arguments = listOf(navArgument("bookId") { type = NavType.LongType })
        ) { backStackEntry ->
            val bookId = backStackEntry.arguments?.getLong("bookId") ?: return@composable
            BookDetailsScreen(
                bookId = bookId,
                onBack = { navController.popBackStack() },
                onOpenReader = { startPage -> navController.navigate(Screen.Reader.createRoute(bookId, startPage)) },
                onOpenBookmarks = { navController.navigate(Screen.Bookmarks.createRoute(bookId)) },
                onOpenNotes = { navController.navigate(Screen.Notes.createRoute(bookId)) },
                onOpenHighlights = { navController.navigate(Screen.Highlights.createRoute(bookId)) },
                onOpenStats = { navController.navigate(Screen.Stats.createRoute(bookId)) },
                onOpenGoal = { navController.navigate(Screen.GoalEditor.createRoute(bookId)) },
                onOpenReminder = { navController.navigate(Screen.ReminderEditor.createRoute(bookId = bookId)) },
                onDeleted = { navController.popBackStack() }
            )
        }

        composable(
            route = Screen.Reader.route,
            arguments = listOf(
                navArgument("bookId") { type = NavType.LongType },
                navArgument("startPage") { type = NavType.IntType; defaultValue = -1 }
            )
        ) { backStackEntry ->
            val bookId = backStackEntry.arguments?.getLong("bookId") ?: return@composable
            val startPage = backStackEntry.arguments?.getInt("startPage")?.takeIf { it >= 0 }
            ReaderScreen(
                bookId = bookId,
                initialPage = startPage,
                onBack = { navController.popBackStack() },
                onOpenBookmarks = { navController.navigate(Screen.Bookmarks.createRoute(bookId)) },
                onOpenNotes = { navController.navigate(Screen.Notes.createRoute(bookId)) },
                onOpenHighlights = { navController.navigate(Screen.Highlights.createRoute(bookId)) }
            )
        }

        composable(
            route = Screen.Bookmarks.route,
            arguments = listOf(navArgument("bookId") { type = NavType.LongType })
        ) { backStackEntry ->
            val bookId = backStackEntry.arguments?.getLong("bookId") ?: return@composable
            BookmarksScreen(
                bookId = bookId,
                onBack = { navController.popBackStack() },
                onJumpToPage = { page -> navController.navigate(Screen.Reader.createRoute(bookId, page)) }
            )
        }

        composable(
            route = Screen.Notes.route,
            arguments = listOf(navArgument("bookId") { type = NavType.LongType })
        ) { backStackEntry ->
            val bookId = backStackEntry.arguments?.getLong("bookId") ?: return@composable
            NotesScreen(
                bookId = bookId,
                onBack = { navController.popBackStack() },
                onJumpToPage = { page -> navController.navigate(Screen.Reader.createRoute(bookId, page)) }
            )
        }

        composable(
            route = Screen.Highlights.route,
            arguments = listOf(navArgument("bookId") { type = NavType.LongType })
        ) { backStackEntry ->
            val bookId = backStackEntry.arguments?.getLong("bookId") ?: return@composable
            HighlightsScreen(
                bookId = bookId,
                onBack = { navController.popBackStack() },
                onJumpToPage = { page -> navController.navigate(Screen.Reader.createRoute(bookId, page)) }
            )
        }

        composable(
            route = Screen.Stats.route,
            arguments = listOf(navArgument("bookId") { type = NavType.LongType })
        ) { backStackEntry ->
            val bookId = backStackEntry.arguments?.getLong("bookId") ?: return@composable
            StatsScreen(bookId = bookId, onBack = { navController.popBackStack() })
        }

        composable(
            route = Screen.GoalEditor.route,
            arguments = listOf(navArgument("bookId") { type = NavType.LongType })
        ) { backStackEntry ->
            val bookId = backStackEntry.arguments?.getLong("bookId") ?: return@composable
            GoalEditorScreen(bookId = bookId, onBack = { navController.popBackStack() })
        }

        composable(
            route = Screen.ReminderEditor.route,
            arguments = listOf(
                navArgument("bookId") { type = NavType.LongType; defaultValue = -1L },
                navArgument("reminderId") { type = NavType.LongType; defaultValue = -1L }
            )
        ) { backStackEntry ->
            val bookId = backStackEntry.arguments?.getLong("bookId")?.takeIf { it > 0 }
            val reminderId = backStackEntry.arguments?.getLong("reminderId")?.takeIf { it > 0 }
            ReminderEditorScreen(bookId = bookId, reminderId = reminderId, onBack = { navController.popBackStack() })
        }
    }
}
