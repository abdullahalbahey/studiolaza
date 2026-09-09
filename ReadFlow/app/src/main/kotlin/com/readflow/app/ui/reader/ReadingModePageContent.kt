package com.readflow.app.ui.reader

import androidx.compose.foundation.ExperimentalFoundationApi
import androidx.compose.foundation.combinedClickable
import androidx.compose.foundation.layout.Arrangement
import androidx.compose.foundation.layout.Column
import androidx.compose.foundation.layout.fillMaxSize
import androidx.compose.foundation.layout.fillMaxWidth
import androidx.compose.foundation.layout.padding
import androidx.compose.foundation.rememberScrollState
import androidx.compose.foundation.text.selection.SelectionContainer
import androidx.compose.foundation.verticalScroll
import androidx.compose.material3.CircularProgressIndicator
import androidx.compose.material3.MaterialTheme
import androidx.compose.material3.Text
import androidx.compose.runtime.Composable
import androidx.compose.runtime.remember
import androidx.compose.ui.Alignment
import androidx.compose.ui.Modifier
import androidx.compose.ui.graphics.Color
import androidx.compose.ui.text.font.FontFamily
import androidx.compose.ui.unit.dp
import androidx.compose.ui.unit.sp
import com.readflow.app.data.local.datastore.ReaderFontFamilyOption

@OptIn(ExperimentalFoundationApi::class)
@Composable
fun ReadingModePageContent(
    text: String?,
    fontSizeSp: Float,
    lineSpacingMultiplier: Float,
    paragraphSpacingSp: Float,
    fontFamilyOption: ReaderFontFamilyOption,
    readingWidthFraction: Float,
    textColor: Color,
    onParagraphLongPress: (String) -> Unit,
    modifier: Modifier = Modifier
) {
    if (text == null) {
        Column(modifier.fillMaxSize(), horizontalAlignment = Alignment.CenterHorizontally, verticalArrangement = Arrangement.Center) {
            CircularProgressIndicator()
        }
        return
    }

    val paragraphs = remember(text) {
        text.split(Regex("\\n\\s*\\n")).map { it.replace("\n", " ").trim() }.filter { it.isNotEmpty() }
            .ifEmpty { listOf(text.trim()) }
    }
    val fontFamily = fontFamilyOption.toFontFamily()

    SelectionContainer {
        Column(
            modifier = modifier
                .fillMaxSize()
                .verticalScroll(rememberScrollState())
                .padding(vertical = 24.dp),
            horizontalAlignment = Alignment.CenterHorizontally
        ) {
            paragraphs.forEach { paragraph ->
                Text(
                    text = paragraph,
                    color = textColor,
                    fontSize = fontSizeSp.sp,
                    lineHeight = (fontSizeSp * lineSpacingMultiplier).sp,
                    fontFamily = fontFamily,
                    modifier = Modifier
                        .fillMaxWidth(readingWidthFraction)
                        .padding(bottom = paragraphSpacingSp.dp)
                        .combinedClickable(
                            onClick = {},
                            onLongClick = { onParagraphLongPress(paragraph) }
                        )
                )
            }
        }
    }
}

private fun ReaderFontFamilyOption.toFontFamily(): FontFamily = when (this) {
    ReaderFontFamilyOption.DEFAULT -> FontFamily.Default
    ReaderFontFamilyOption.SERIF -> FontFamily.Serif
    ReaderFontFamilyOption.SANS_SERIF -> FontFamily.SansSerif
    ReaderFontFamilyOption.MONOSPACE -> FontFamily.Monospace
}
