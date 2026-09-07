@file:OptIn(androidx.compose.material3.ExperimentalMaterial3Api::class)

package com.readflow.app.ui.reader

import android.app.Activity
import android.view.WindowManager
import androidx.compose.animation.AnimatedVisibility
import androidx.compose.animation.fadeIn
import androidx.compose.animation.fadeOut
import androidx.compose.foundation.background
import androidx.compose.foundation.gestures.detectTapGestures
import androidx.compose.foundation.layout.Arrangement
import androidx.compose.foundation.layout.aspectRatio
import androidx.compose.foundation.layout.Box
import androidx.compose.foundation.layout.Column
import androidx.compose.foundation.layout.Row
import androidx.compose.foundation.layout.fillMaxSize
import androidx.compose.foundation.layout.fillMaxWidth
import androidx.compose.foundation.layout.padding
import androidx.compose.foundation.layout.size
import androidx.compose.foundation.lazy.LazyColumn
import androidx.compose.foundation.lazy.itemsIndexed
import androidx.compose.foundation.lazy.rememberLazyListState
import androidx.compose.foundation.pager.HorizontalPager
import androidx.compose.foundation.pager.rememberPagerState
import androidx.compose.material.icons.Icons
import androidx.compose.material.icons.automirrored.filled.ArrowBack
import androidx.compose.material.icons.filled.Bookmark
import androidx.compose.material.icons.filled.BookmarkBorder
import androidx.compose.material.icons.filled.Edit
import androidx.compose.material.icons.filled.List
import androidx.compose.material.icons.filled.MoreVert
import androidx.compose.material.icons.filled.Search
import androidx.compose.material3.AlertDialog
import androidx.compose.material3.Button
import androidx.compose.material3.CircularProgressIndicator
import androidx.compose.material3.DropdownMenu
import androidx.compose.material3.DropdownMenuItem
import androidx.compose.material3.Icon
import androidx.compose.material3.IconButton
import androidx.compose.material3.MaterialTheme
import androidx.compose.material3.ModalBottomSheet
import androidx.compose.material3.OutlinedTextField
import androidx.compose.material3.Slider
import androidx.compose.material3.Surface
import androidx.compose.material3.Text
import androidx.compose.material3.TextButton
import androidx.compose.material3.TopAppBar
import androidx.compose.runtime.Composable
import androidx.compose.runtime.DisposableEffect
import androidx.compose.runtime.LaunchedEffect
import androidx.compose.runtime.getValue
import androidx.compose.runtime.mutableStateOf
import androidx.compose.runtime.remember
import androidx.compose.runtime.rememberCoroutineScope
import androidx.compose.runtime.setValue
import androidx.compose.runtime.snapshotFlow
import androidx.compose.ui.Alignment
import androidx.compose.ui.Modifier
import androidx.compose.ui.input.pointer.pointerInput
import androidx.compose.ui.platform.LocalContext
import androidx.compose.ui.platform.LocalLifecycleOwner
import androidx.compose.ui.unit.dp
import androidx.hilt.navigation.compose.hiltViewModel
import androidx.lifecycle.Lifecycle
import androidx.lifecycle.LifecycleEventObserver
import androidx.lifecycle.compose.collectAsStateWithLifecycle
import com.readflow.app.data.local.db.entity.ReaderViewMode
import com.readflow.app.ui.theme.readingColorsFor
import kotlinx.coroutines.launch

@Composable
fun ReaderScreen(
    bookId: Long,
    initialPage: Int?,
    onBack: () -> Unit,
    onOpenBookmarks: () -> Unit,
    onOpenNotes: () -> Unit,
    onOpenHighlights: () -> Unit,
    viewModel: ReaderViewModel = hiltViewModel()
) {
    val state by viewModel.uiState.collectAsStateWithLifecycle()
    val readingColors = readingColorsFor(state.readingTheme)
    val context = LocalContext.current

    DisposableEffect(state.keepScreenAwake) {
        val window = (context as? Activity)?.window
        if (state.keepScreenAwake) window?.addFlags(WindowManager.LayoutParams.FLAG_KEEP_SCREEN_ON)
        onDispose { window?.clearFlags(WindowManager.LayoutParams.FLAG_KEEP_SCREEN_ON) }
    }

    val lifecycleOwner = LocalLifecycleOwner.current
    DisposableEffect(lifecycleOwner) {
        val observer = LifecycleEventObserver { _, event ->
            when (event) {
                Lifecycle.Event.ON_PAUSE -> viewModel.saveSessionAndProgress()
                Lifecycle.Event.ON_RESUME -> viewModel.resumeSession()
                else -> {}
            }
        }
        lifecycleOwner.lifecycle.addObserver(observer)
        onDispose { lifecycleOwner.lifecycle.removeObserver(observer) }
    }

    var showTocSheet by remember { mutableStateOf(false) }
    var showSearchSheet by remember { mutableStateOf(false) }
    var showSettingsSheet by remember { mutableStateOf(false) }
    var showJumpDialog by remember { mutableStateOf(false) }
    var showMenu by remember { mutableStateOf(false) }
    var highlightTarget by remember { mutableStateOf<String?>(null) }

    when {
        state.error != null -> ReaderErrorState(message = state.error ?: "", onBack = onBack)
        state.isLoading -> Box(Modifier.fillMaxSize(), contentAlignment = Alignment.Center) { CircularProgressIndicator() }
        else -> {
            Box(
                modifier = Modifier
                    .fillMaxSize()
                    .background(readingColors.pageBackground)
            ) {
                Box(
                    modifier = Modifier
                        .fillMaxSize()
                        .pointerInput(Unit) {
                            detectTapGestures(onTap = { viewModel.toggleControls() })
                        }
                ) {
                    if (state.readingModeEnabled) {
                        ReadingModePager(state = state, viewModel = viewModel, textColor = readingColors.onPageText, onParagraphLongPress = { highlightTarget = it })
                    } else when (state.viewMode) {
                        ReaderViewMode.PAGE -> OriginalPdfPager(state = state, viewModel = viewModel)
                        ReaderViewMode.SCROLL -> OriginalPdfScroll(state = state, viewModel = viewModel)
                    }
                }

                AnimatedVisibility(
                    visible = state.controlsVisible,
                    enter = fadeIn(),
                    exit = fadeOut(),
                    modifier = Modifier.align(Alignment.TopCenter)
                ) {
                    Column {
                        TopAppBar(
                            title = { Text(state.title, maxLines = 1, style = MaterialTheme.typography.titleMedium) },
                            navigationIcon = {
                                IconButton(onClick = onBack) { Icon(Icons.AutoMirrored.Filled.ArrowBack, contentDescription = "Back") }
                            },
                            actions = {
                                IconButton(onClick = { showSearchSheet = true }) { Icon(Icons.Filled.Search, contentDescription = "Search") }
                                IconButton(onClick = { showTocSheet = true }) { Icon(Icons.Filled.List, contentDescription = "Table of contents") }
                                IconButton(onClick = { viewModel.toggleBookmark() }) {
                                    Icon(if (state.isBookmarked) Icons.Filled.Bookmark else Icons.Filled.BookmarkBorder, contentDescription = "Bookmark this page")
                                }
                                Box {
                                    IconButton(onClick = { showMenu = true }) { Icon(Icons.Filled.MoreVert, contentDescription = "More") }
                                    DropdownMenu(expanded = showMenu, onDismissRequest = { showMenu = false }) {
                                        DropdownMenuItem(text = { Text("Bookmarks") }, onClick = { showMenu = false; onOpenBookmarks() })
                                        DropdownMenuItem(text = { Text("Notes") }, onClick = { showMenu = false; onOpenNotes() })
                                        DropdownMenuItem(text = { Text("Highlights") }, onClick = { showMenu = false; onOpenHighlights() })
                                        DropdownMenuItem(text = { Text("Add note on this page") }, leadingIcon = { Icon(Icons.Filled.Edit, contentDescription = null) }, onClick = { showMenu = false; onOpenNotes() })
                                        DropdownMenuItem(text = { Text("Display settings") }, onClick = { showMenu = false; showSettingsSheet = true })
                                    }
                                }
                            }
                        )
                    }
                }

                AnimatedVisibility(
                    visible = state.controlsVisible,
                    enter = fadeIn(),
                    exit = fadeOut(),
                    modifier = Modifier.align(Alignment.BottomCenter)
                ) {
                    Surface(tonalElevation = 3.dp) {
                        Row(
                            modifier = Modifier
                                .fillMaxWidth()
                                .padding(horizontal = 20.dp, vertical = 12.dp),
                            verticalAlignment = Alignment.CenterVertically,
                            horizontalArrangement = Arrangement.SpaceBetween
                        ) {
                            TextButton(onClick = { showJumpDialog = true }) {
                                Text("Page ${state.currentPage + 1} / ${state.pageCount}")
                            }
                            Text(
                                text = "${(((state.currentPage + 1).toFloat() / state.pageCount.coerceAtLeast(1)) * 100).toInt()}%",
                                style = MaterialTheme.typography.bodyMedium
                            )
                        }
                    }
                }
            }

            if (showTocSheet) {
                ModalBottomSheet(onDismissRequest = { showTocSheet = false }) {
                    TocSheetContent(bookId = bookId, onJump = { page -> viewModel.jumpToPage(page); showTocSheet = false })
                }
            }
            if (showSearchSheet) {
                ModalBottomSheet(onDismissRequest = { showSearchSheet = false }) {
                    SearchSheetContent(bookId = bookId, filePath = state.filePath, hasExtractableText = state.readingModeAvailable, onJump = { page -> viewModel.jumpToPage(page); showSearchSheet = false })
                }
            }
            if (showSettingsSheet) {
                ModalBottomSheet(onDismissRequest = { showSettingsSheet = false }) {
                    ReaderDisplaySettingsSheet(
                        readingModeAvailable = state.readingModeAvailable,
                        readingModeEnabled = state.readingModeEnabled,
                        onReadingModeToggle = viewModel::setReadingModeEnabled,
                        viewMode = state.viewMode,
                        onViewModeChange = viewModel::setViewMode,
                        fitWholePage = state.fitWholePage,
                        onFitToggle = viewModel::setFitWholePage
                    )
                }
            }
            if (showJumpDialog) {
                JumpToPageDialog(pageCount = state.pageCount, currentPage = state.currentPage, onDismiss = { showJumpDialog = false }, onJump = { page -> viewModel.jumpToPage(page); showJumpDialog = false })
            }
            highlightTarget?.let { text ->
                HighlightPickerDialog(
                    bookId = bookId,
                    pageNumber = state.currentPage,
                    text = text,
                    onDismiss = { highlightTarget = null }
                )
            }
        }
    }
}

@Composable
private fun ReadingModePager(state: ReaderUiState, viewModel: ReaderViewModel, textColor: androidx.compose.ui.graphics.Color, onParagraphLongPress: (String) -> Unit) {
    val pagerState = rememberPagerState(initialPage = state.currentPage) { state.pageCount.coerceAtLeast(1) }
    LaunchedEffect(pagerState) {
        snapshotFlow { pagerState.currentPage }.collect { page -> viewModel.onPageChanged(page) }
    }
    LaunchedEffect(state.currentPage) {
        if (pagerState.currentPage != state.currentPage) pagerState.scrollToPage(state.currentPage)
    }
    HorizontalPager(state = pagerState, modifier = Modifier.fillMaxSize()) { page ->
        LaunchedEffect(page) { viewModel.requestPageText(page) }
        ReadingModePageContent(
            text = viewModel.pageTexts[page],
            fontSizeSp = state.fontSizeSp,
            lineSpacingMultiplier = state.lineSpacingMultiplier,
            paragraphSpacingSp = state.paragraphSpacingSp,
            fontFamilyOption = state.fontFamily,
            readingWidthFraction = state.readingWidthFraction,
            textColor = textColor,
            onParagraphLongPress = onParagraphLongPress
        )
    }
}

@Composable
private fun OriginalPdfPager(state: ReaderUiState, viewModel: ReaderViewModel) {
    val pagerState = rememberPagerState(initialPage = state.currentPage) { state.pageCount.coerceAtLeast(1) }
    LaunchedEffect(pagerState) {
        snapshotFlow { pagerState.currentPage }.collect { page -> viewModel.onPageChanged(page) }
    }
    LaunchedEffect(state.currentPage) {
        if (pagerState.currentPage != state.currentPage) pagerState.scrollToPage(state.currentPage)
    }
    HorizontalPager(state = pagerState, modifier = Modifier.fillMaxSize()) { page ->
        PdfPageView(
            pageIndex = page,
            bitmap = viewModel.pageBitmaps[page],
            fitWholePage = state.fitWholePage,
            onWidthMeasured = { width -> viewModel.requestPageBitmap(page, width) }
        )
        LaunchedEffect(page) {
            viewModel.requestPageBitmap(page - 1, 800)
            viewModel.requestPageBitmap(page + 1, 800)
        }
    }
}

@Composable
private fun OriginalPdfScroll(state: ReaderUiState, viewModel: ReaderViewModel) {
    val listState = rememberLazyListState()
    LaunchedEffect(listState) {
        snapshotFlow { listState.firstVisibleItemIndex }.collect { page -> viewModel.onPageChanged(page) }
    }
    LaunchedEffect(state.currentPage) {
        if (listState.firstVisibleItemIndex != state.currentPage) listState.scrollToItem(state.currentPage)
    }
    LazyColumn(state = listState, modifier = Modifier.fillMaxSize()) {
        itemsIndexed((0 until state.pageCount).toList()) { _, page ->
            PdfPageView(
                pageIndex = page,
                bitmap = viewModel.pageBitmaps[page],
                fitWholePage = false,
                onWidthMeasured = { width -> viewModel.requestPageBitmap(page, width) },
                modifier = Modifier
                    .fillMaxWidth()
                    .aspectRatio(0.72f)
                    .padding(vertical = 2.dp)
            )
        }
    }
}

@Composable
private fun ReaderErrorState(message: String, onBack: () -> Unit) {
    Box(Modifier.fillMaxSize(), contentAlignment = Alignment.Center) {
        Column(horizontalAlignment = Alignment.CenterHorizontally, modifier = Modifier.padding(32.dp)) {
            Text("Can't open this book", style = MaterialTheme.typography.titleLarge)
            Text(message, style = MaterialTheme.typography.bodyMedium, modifier = Modifier.padding(top = 8.dp))
            Button(onClick = onBack, modifier = Modifier.padding(top = 20.dp)) { Text("Go back") }
        }
    }
}

@Composable
private fun JumpToPageDialog(pageCount: Int, currentPage: Int, onDismiss: () -> Unit, onJump: (Int) -> Unit) {
    var text by remember { mutableStateOf((currentPage + 1).toString()) }
    AlertDialog(
        onDismissRequest = onDismiss,
        title = { Text("Jump to page") },
        text = {
            Column {
                OutlinedTextField(
                    value = text,
                    onValueChange = { text = it.filter { c -> c.isDigit() } },
                    label = { Text("Page (1-$pageCount)") },
                    singleLine = true
                )
                Slider(
                    value = (text.toIntOrNull() ?: (currentPage + 1)).toFloat(),
                    onValueChange = { text = it.toInt().toString() },
                    valueRange = 1f..pageCount.coerceAtLeast(1).toFloat()
                )
            }
        },
        confirmButton = {
            TextButton(onClick = {
                val page = (text.toIntOrNull() ?: 1).coerceIn(1, pageCount.coerceAtLeast(1))
                onJump(page - 1)
            }) { Text("Go") }
        },
        dismissButton = { TextButton(onClick = onDismiss) { Text("Cancel") } }
    )
}
