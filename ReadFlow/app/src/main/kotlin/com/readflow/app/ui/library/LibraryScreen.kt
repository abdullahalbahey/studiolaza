@file:OptIn(androidx.compose.material3.ExperimentalMaterial3Api::class)

package com.readflow.app.ui.library

import android.net.Uri
import androidx.activity.compose.rememberLauncherForActivityResult
import androidx.activity.result.contract.ActivityResultContracts
import androidx.compose.foundation.layout.Arrangement
import androidx.compose.foundation.layout.Box
import androidx.compose.foundation.layout.Column
import androidx.compose.foundation.layout.PaddingValues
import androidx.compose.foundation.layout.Row
import androidx.compose.foundation.layout.fillMaxSize
import androidx.compose.foundation.layout.fillMaxWidth
import androidx.compose.foundation.layout.padding
import androidx.compose.foundation.layout.size
import androidx.compose.foundation.lazy.LazyColumn
import androidx.compose.foundation.lazy.grid.GridCells
import androidx.compose.foundation.lazy.grid.LazyVerticalGrid
import androidx.compose.foundation.lazy.grid.items
import androidx.compose.foundation.lazy.items
import androidx.compose.material.icons.Icons
import androidx.compose.material.icons.automirrored.outlined.MenuBook
import androidx.compose.material.icons.filled.Add
import androidx.compose.material.icons.filled.CreateNewFolder
import androidx.compose.material.icons.filled.GridView
import androidx.compose.material.icons.filled.List
import androidx.compose.material.icons.filled.Search
import androidx.compose.material.icons.filled.Sort
import androidx.compose.material3.AlertDialog
import androidx.compose.material3.CircularProgressIndicator
import androidx.compose.material3.DropdownMenu
import androidx.compose.material3.DropdownMenuItem
import androidx.compose.material3.ExtendedFloatingActionButton
import androidx.compose.material3.FilterChip
import androidx.compose.material3.Icon
import androidx.compose.material3.IconButton
import androidx.compose.material3.LinearProgressIndicator
import androidx.compose.material3.MaterialTheme
import androidx.compose.material3.OutlinedTextField
import androidx.compose.material3.Scaffold
import androidx.compose.material3.SnackbarHost
import androidx.compose.material3.SnackbarHostState
import androidx.compose.material3.Text
import androidx.compose.material3.TextButton
import androidx.compose.material3.TopAppBar
import androidx.compose.runtime.Composable
import androidx.compose.runtime.LaunchedEffect
import androidx.compose.runtime.getValue
import androidx.compose.runtime.mutableStateOf
import androidx.compose.runtime.remember
import androidx.compose.runtime.rememberCoroutineScope
import androidx.compose.runtime.setValue
import androidx.compose.ui.Alignment
import androidx.compose.ui.Modifier
import androidx.compose.ui.platform.LocalContext
import androidx.compose.ui.unit.dp
import androidx.hilt.navigation.compose.hiltViewModel
import androidx.lifecycle.compose.collectAsStateWithLifecycle
import com.readflow.app.data.local.datastore.LibraryFilter
import com.readflow.app.data.local.datastore.LibrarySortOrder
import com.readflow.app.data.local.datastore.LibraryViewType
import com.readflow.app.data.repository.DuplicateResolution
import com.readflow.app.ui.common.queryDisplayName
import kotlinx.coroutines.launch

@Composable
fun LibraryScreen(
    onBookClick: (Long) -> Unit,
    onOpenReaderDirect: (Long) -> Unit,
    pendingImportUri: Uri?,
    onImportUriConsumed: () -> Unit,
    viewModel: LibraryViewModel = hiltViewModel()
) {
    val state by viewModel.uiState.collectAsStateWithLifecycle()
    val context = LocalContext.current
    val snackbarHostState = remember { SnackbarHostState() }
    val scope = rememberCoroutineScope()
    var showSearch by remember { mutableStateOf(false) }
    var showSortMenu by remember { mutableStateOf(false) }
    var showFolderImportDialog by remember { mutableStateOf(false) }

    val importLauncher = rememberLauncherForActivityResult(ActivityResultContracts.OpenDocument()) { uri ->
        if (uri != null) {
            val name = context.queryDisplayName(uri)
            viewModel.importBook(uri, name)
        }
    }

    LaunchedEffect(pendingImportUri) {
        if (pendingImportUri != null) {
            val name = context.queryDisplayName(pendingImportUri)
            viewModel.importBook(pendingImportUri, name)
            onImportUriConsumed()
        }
    }

    LaunchedEffect(state.justImportedBookId) {
        state.justImportedBookId?.let { bookId ->
            onOpenReaderDirect(bookId)
            viewModel.consumeJustImported()
        }
    }

    LaunchedEffect(state.errorMessage) {
        state.errorMessage?.let {
            scope.launch { snackbarHostState.showSnackbar(it) }
            viewModel.consumeError()
        }
    }

    Scaffold(
        topBar = {
            Column {
                TopAppBar(
                    title = { Text("ReadFlow") },
                    actions = {
                        IconButton(onClick = { showFolderImportDialog = true }) {
                            Icon(Icons.Filled.CreateNewFolder, contentDescription = "Import from Google Drive folder")
                        }
                        IconButton(onClick = { showSearch = !showSearch }) {
                            Icon(Icons.Filled.Search, contentDescription = "Search")
                        }
                        IconButton(onClick = {
                            viewModel.setViewType(if (state.viewType == LibraryViewType.GRID) LibraryViewType.LIST else LibraryViewType.GRID)
                        }) {
                            Icon(
                                if (state.viewType == LibraryViewType.GRID) Icons.Filled.List else Icons.Filled.GridView,
                                contentDescription = "Toggle view"
                            )
                        }
                        Box {
                            IconButton(onClick = { showSortMenu = true }) {
                                Icon(Icons.Filled.Sort, contentDescription = "Sort")
                            }
                            DropdownMenu(expanded = showSortMenu, onDismissRequest = { showSortMenu = false }) {
                                LibrarySortOrder.entries.forEach { order ->
                                    DropdownMenuItem(
                                        text = { Text(order.label()) },
                                        onClick = { viewModel.setSort(order); showSortMenu = false }
                                    )
                                }
                            }
                        }
                    }
                )
                if (showSearch) {
                    OutlinedTextField(
                        value = state.searchQuery,
                        onValueChange = viewModel::setSearchQuery,
                        modifier = Modifier.fillMaxWidth().padding(horizontal = 16.dp, vertical = 4.dp),
                        placeholder = { Text("Search your library") },
                        singleLine = true
                    )
                }
                Row(
                    modifier = Modifier
                        .fillMaxWidth()
                        .padding(horizontal = 16.dp, vertical = 8.dp),
                    horizontalArrangement = Arrangement.spacedBy(8.dp)
                ) {
                    LibraryFilter.entries.forEach { filter ->
                        FilterChip(
                            selected = state.filter == filter,
                            onClick = { viewModel.setFilter(filter) },
                            label = { Text(filter.label()) }
                        )
                    }
                }
            }
        },
        floatingActionButton = {
            ExtendedFloatingActionButton(
                onClick = { importLauncher.launch(arrayOf("application/pdf")) },
                icon = { Icon(Icons.Filled.Add, contentDescription = null) },
                text = { Text("Add Book") }
            )
        },
        snackbarHost = { SnackbarHost(snackbarHostState) }
    ) { padding ->
        Box(modifier = Modifier.fillMaxSize().padding(padding)) {
            when {
                state.isLoading -> CircularProgressIndicator(modifier = Modifier.align(Alignment.Center))
                state.books.isEmpty() -> EmptyLibraryState(
                    hasAnyBooksAtAll = state.searchQuery.isBlank() && state.filter == LibraryFilter.ALL,
                    onAddBook = { importLauncher.launch(arrayOf("application/pdf")) }
                )
                state.viewType == LibraryViewType.GRID -> LazyVerticalGrid(
                    columns = GridCells.Fixed(2),
                    contentPadding = PaddingValues(16.dp),
                    verticalArrangement = Arrangement.spacedBy(20.dp),
                    horizontalArrangement = Arrangement.spacedBy(16.dp),
                    modifier = Modifier.fillMaxSize()
                ) {
                    items(state.books, key = { it.id }) { book ->
                        BookGridCard(book = book, onClick = { onBookClick(book.id) })
                    }
                }
                else -> LazyColumn(
                    contentPadding = PaddingValues(horizontal = 16.dp, vertical = 8.dp),
                    modifier = Modifier.fillMaxSize()
                ) {
                    items(state.books, key = { it.id }) { book ->
                        BookListCard(book = book, onClick = { onBookClick(book.id) })
                    }
                }
            }

            if (state.isImporting) {
                Box(
                    modifier = Modifier.fillMaxSize(),
                    contentAlignment = Alignment.Center
                ) {
                    val folderProgress = state.folderImportProgress
                    Column(horizontalAlignment = Alignment.CenterHorizontally, modifier = Modifier.padding(horizontal = 32.dp)) {
                        if (folderProgress != null && folderProgress.total > 0) {
                            LinearProgressIndicator(
                                progress = { (folderProgress.done.toFloat() / folderProgress.total).coerceIn(0f, 1f) },
                                modifier = Modifier.fillMaxWidth()
                            )
                            Text(
                                "Importing ${folderProgress.done + 1} of ${folderProgress.total}${if (folderProgress.currentName.isNotBlank()) ": ${folderProgress.currentName}" else ""}",
                                modifier = Modifier.padding(top = 12.dp)
                            )
                        } else {
                            CircularProgressIndicator()
                            Text("Importing…", modifier = Modifier.padding(top = 12.dp))
                        }
                    }
                }
            }
        }
    }

    if (showFolderImportDialog) {
        FolderImportDialog(
            hasApiKey = state.hasDriveApiKey,
            onDismiss = { showFolderImportDialog = false },
            onImport = { link -> showFolderImportDialog = false; viewModel.importFromDriveFolder(link) }
        )
    }

    state.folderImportSummary?.let { summary ->
        AlertDialog(
            onDismissRequest = viewModel::consumeFolderImportSummary,
            title = { Text("Folder import finished") },
            text = {
                Text(
                    "Found ${summary.filesFound} PDF${if (summary.filesFound == 1) "" else "s"} — added ${summary.added}, " +
                        "skipped ${summary.duplicates} already in your library, ${summary.failed} failed."
                )
            },
            confirmButton = { TextButton(onClick = viewModel::consumeFolderImportSummary) { Text("OK") } }
        )
    }

    state.duplicatePrompt?.let { prompt ->
        AlertDialog(
            onDismissRequest = viewModel::dismissDuplicatePrompt,
            title = { Text("Already in your library") },
            text = { Text("This book is already in your library. What would you like to do?") },
            confirmButton = {
                TextButton(onClick = { viewModel.resolveDuplicate(DuplicateResolution.OPEN_EXISTING) }) {
                    Text("Open existing")
                }
            },
            dismissButton = {
                Row {
                    TextButton(onClick = { viewModel.resolveDuplicate(DuplicateResolution.REPLACE) }) {
                        Text("Replace")
                    }
                    TextButton(onClick = { viewModel.resolveDuplicate(DuplicateResolution.IMPORT_ANYWAY) }) {
                        Text("Import anyway")
                    }
                }
            }
        )
    }
}

@Composable
private fun FolderImportDialog(hasApiKey: Boolean, onDismiss: () -> Unit, onImport: (String) -> Unit) {
    var link by remember { mutableStateOf("") }
    AlertDialog(
        onDismissRequest = onDismiss,
        title = { Text("Import from Drive folder") },
        text = {
            Column {
                Text("Paste a public Google Drive folder link. Every PDF directly inside it will be imported.")
                if (!hasApiKey) {
                    Text(
                        "You need a Google Drive API key set in Settings first — this always requires one.",
                        color = MaterialTheme.colorScheme.error,
                        modifier = Modifier.padding(top = 8.dp)
                    )
                }
                OutlinedTextField(
                    value = link,
                    onValueChange = { link = it },
                    placeholder = { Text("https://drive.google.com/drive/folders/...") },
                    singleLine = true,
                    enabled = hasApiKey,
                    modifier = Modifier.fillMaxWidth().padding(top = 12.dp)
                )
            }
        },
        confirmButton = {
            TextButton(onClick = { onImport(link.trim()) }, enabled = hasApiKey && link.isNotBlank()) {
                Text("Import")
            }
        },
        dismissButton = { TextButton(onClick = onDismiss) { Text("Cancel") } }
    )
}

@Composable
private fun EmptyLibraryState(hasAnyBooksAtAll: Boolean, onAddBook: () -> Unit) {
    Column(
        modifier = Modifier.fillMaxSize().padding(32.dp),
        horizontalAlignment = Alignment.CenterHorizontally,
        verticalArrangement = Arrangement.Center
    ) {
        Icon(
            Icons.AutoMirrored.Outlined.MenuBook,
            contentDescription = null,
            modifier = Modifier.size(56.dp),
            tint = MaterialTheme.colorScheme.onSurfaceVariant
        )
        Text(
            text = if (hasAnyBooksAtAll) "Your library is empty" else "No books match",
            style = MaterialTheme.typography.titleMedium,
            modifier = Modifier.padding(top = 16.dp)
        )
        if (hasAnyBooksAtAll) {
            Text(
                text = "Import a PDF to start reading. Your books and reading data stay on this device.",
                style = MaterialTheme.typography.bodyMedium,
                color = MaterialTheme.colorScheme.onSurfaceVariant,
                modifier = Modifier.padding(top = 4.dp)
            )
            TextButton(onClick = onAddBook, modifier = Modifier.padding(top = 16.dp)) {
                Text("Add your first book")
            }
        }
    }
}

private fun LibrarySortOrder.label(): String = when (this) {
    LibrarySortOrder.RECENTLY_READ -> "Recently read"
    LibrarySortOrder.TITLE -> "Title"
    LibrarySortOrder.AUTHOR -> "Author"
    LibrarySortOrder.PROGRESS -> "Progress"
    LibrarySortOrder.DATE_ADDED -> "Date added"
}

private fun LibraryFilter.label(): String = when (this) {
    LibraryFilter.ALL -> "All"
    LibraryFilter.READING -> "Reading"
    LibraryFilter.COMPLETED -> "Completed"
    LibraryFilter.NOT_STARTED -> "Not started"
}
