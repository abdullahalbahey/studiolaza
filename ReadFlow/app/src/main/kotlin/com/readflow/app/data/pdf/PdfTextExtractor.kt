package com.readflow.app.data.pdf

import android.content.Context
import com.tom_roush.pdfbox.pdmodel.PDDocument
import com.tom_roush.pdfbox.pdmodel.interactive.documentnavigation.outline.PDOutlineItem
import com.tom_roush.pdfbox.pdmodel.interactive.documentnavigation.outline.PDOutlineNode
import com.tom_roush.pdfbox.text.PDFTextStripper
import dagger.hilt.android.qualifiers.ApplicationContext
import java.io.File
import javax.inject.Inject
import javax.inject.Singleton

data class TocNode(val title: String, val pageNumber: Int, val level: Int)

/**
 * Best-effort text and outline extraction backed by PDFBox-Android. All entry points swallow
 * their own failures and return null/empty rather than throwing, since a book that only fails
 * to extract text is still fully readable in Original PDF mode.
 */
@Singleton
class PdfTextExtractor @Inject constructor(
    @ApplicationContext private val context: Context
) {

    private fun open(filePath: String): PDDocument? {
        PdfBoxInitializer.ensureInit(context)
        return try {
            val doc = PDDocument.load(File(filePath))
            if (doc.isEncrypted) {
                doc.close()
                null
            } else {
                doc
            }
        } catch (e: Exception) {
            null
        }
    }

    /** Extracts text for a single page (0-based). Returns null if extraction isn't possible. */
    fun extractPageText(filePath: String, pageIndex: Int): String? {
        val doc = open(filePath) ?: return null
        return try {
            doc.use {
                if (pageIndex < 0 || pageIndex >= it.numberOfPages) return@use null
                val stripper = PDFTextStripper()
                stripper.startPage = pageIndex + 1
                stripper.endPage = pageIndex + 1
                stripper.getText(it).trim()
            }
        } catch (e: Exception) {
            null
        }
    }

    /** Extracts text for every page. May take a while on large books - call off the main thread. */
    fun extractAllPagesText(filePath: String): Map<Int, String>? {
        val doc = open(filePath) ?: return null
        return try {
            doc.use {
                val stripper = PDFTextStripper()
                val result = LinkedHashMap<Int, String>()
                for (pageNumber in 1..it.numberOfPages) {
                    stripper.startPage = pageNumber
                    stripper.endPage = pageNumber
                    result[pageNumber - 1] = stripper.getText(it).trim()
                }
                result
            }
        } catch (e: Exception) {
            null
        }
    }

    /** Quick heuristic: does this PDF have a meaningful amount of extractable text? */
    fun hasExtractableText(filePath: String): Boolean {
        val doc = open(filePath) ?: return false
        return try {
            doc.use {
                val pagesToCheck = minOf(it.numberOfPages, 3)
                if (pagesToCheck <= 0) return@use false
                val stripper = PDFTextStripper()
                stripper.startPage = 1
                stripper.endPage = pagesToCheck
                stripper.getText(it).trim().length > 40
            }
        } catch (e: Exception) {
            false
        }
    }

    /** Extracts document metadata: title/author, when present in the PDF's info dictionary. */
    fun extractMetadata(filePath: String): Pair<String?, String?> {
        val doc = open(filePath) ?: return null to null
        return try {
            doc.use {
                val info = it.documentInformation
                info?.title?.trim()?.takeIf { t -> t.isNotBlank() } to
                    info?.author?.trim()?.takeIf { a -> a.isNotBlank() }
            }
        } catch (e: Exception) {
            null to null
        }
    }

    /** Extracts a flattened table of contents from the PDF's outline, if present. */
    fun extractToc(filePath: String): List<TocNode> {
        val doc = open(filePath) ?: return emptyList()
        return try {
            doc.use { document ->
                val outline = document.documentCatalog?.documentOutline ?: return@use emptyList()
                val nodes = mutableListOf<TocNode>()
                walkOutline(outline, document, 0, nodes)
                nodes
            }
        } catch (e: Exception) {
            emptyList()
        }
    }

    private fun walkOutline(
        node: PDOutlineNode,
        document: PDDocument,
        level: Int,
        out: MutableList<TocNode>
    ) {
        var child: PDOutlineItem? = node.firstChild
        while (child != null) {
            val title = child.title?.trim().orEmpty()
            if (title.isNotEmpty()) {
                val pageNumber = resolvePageNumber(child, document)
                if (pageNumber != null) {
                    out.add(TocNode(title = title, pageNumber = pageNumber, level = level))
                }
            }
            walkOutline(child, document, level + 1, out)
            child = child.nextSibling
        }
    }

    private fun resolvePageNumber(item: PDOutlineItem, document: PDDocument): Int? {
        return try {
            val page = item.findDestinationPage(document) ?: return null
            val index = document.pages.indexOf(page)
            if (index >= 0) index else null
        } catch (e: Exception) {
            null
        }
    }
}
