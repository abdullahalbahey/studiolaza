package com.readflow.app.data.pdf

import android.content.Context
import android.graphics.Bitmap
import android.net.Uri
import dagger.hilt.android.qualifiers.ApplicationContext
import kotlinx.coroutines.Dispatchers
import kotlinx.coroutines.withContext
import java.io.File
import java.io.FileOutputStream
import java.security.DigestInputStream
import java.security.MessageDigest
import java.util.UUID
import javax.inject.Inject
import javax.inject.Singleton

data class ImportedPdfInfo(
    val filePath: String,
    val title: String,
    val author: String?,
    val pageCount: Int,
    val coverPath: String?,
    val hasExtractableText: Boolean,
    val fileSizeBytes: Long,
    val fileHash: String
)

@Singleton
class PdfImporter @Inject constructor(
    @ApplicationContext private val context: Context,
    private val textExtractor: PdfTextExtractor
) {

    private val booksDir: File get() = File(context.filesDir, "books").apply { mkdirs() }
    private val coversDir: File get() = File(context.filesDir, "covers").apply { mkdirs() }

    /** Copies the picked PDF into app-private storage and extracts everything needed to add it to the library. */
    suspend fun importFromUri(uri: Uri, displayName: String?): ImportedPdfInfo = withContext(Dispatchers.IO) {
        val id = UUID.randomUUID().toString()
        val destFile = File(booksDir, "$id.pdf")
        val hash = copyAndHash(uri, destFile)

        val renderer = PdfPageRenderer(destFile.absolutePath)
        try {
            renderer.open()
            val pageCount = renderer.pageCount
            if (pageCount <= 0) {
                destFile.delete()
                throw PdfException.Empty()
            }
            val coverPath = generateCover(renderer, id)
            val (extractedTitle, author) = textExtractor.extractMetadata(destFile.absolutePath)
            val hasText = textExtractor.hasExtractableText(destFile.absolutePath)

            ImportedPdfInfo(
                filePath = destFile.absolutePath,
                title = extractedTitle ?: prettifyFileName(displayName),
                author = author,
                pageCount = pageCount,
                coverPath = coverPath,
                hasExtractableText = hasText,
                fileSizeBytes = destFile.length(),
                fileHash = hash
            )
        } catch (e: PdfException) {
            destFile.delete()
            throw e
        } catch (e: Exception) {
            destFile.delete()
            throw PdfException.Corrupted()
        } finally {
            renderer.close()
        }
    }

    fun deleteBookFiles(filePath: String?, coverPath: String?) {
        filePath?.let { runCatching { File(it).delete() } }
        coverPath?.let { runCatching { File(it).delete() } }
    }

    private fun copyAndHash(uri: Uri, destFile: File): String {
        val digest = MessageDigest.getInstance("SHA-256")
        val input = context.contentResolver.openInputStream(uri) ?: throw PdfException.NotFound()
        input.use { rawInput ->
            DigestInputStream(rawInput, digest).use { digestInput ->
                FileOutputStream(destFile).use { output ->
                    val buffer = ByteArray(64 * 1024)
                    var bytesRead: Int
                    var totalRead = 0L
                    while (digestInput.read(buffer).also { bytesRead = it } != -1) {
                        output.write(buffer, 0, bytesRead)
                        totalRead += bytesRead
                    }
                    if (totalRead == 0L) {
                        destFile.delete()
                        throw PdfException.Empty()
                    }
                }
            }
        }
        return digest.digest().joinToString("") { "%02x".format(it) }
    }

    private suspend fun generateCover(renderer: PdfPageRenderer, id: String): String? {
        return try {
            val bitmap: Bitmap = renderer.renderPage(0, targetWidthPx = 480)
            val coverFile = File(coversDir, "$id.png")
            FileOutputStream(coverFile).use { out ->
                bitmap.compress(Bitmap.CompressFormat.PNG, 90, out)
            }
            bitmap.recycle()
            coverFile.absolutePath
        } catch (e: Exception) {
            null
        }
    }

    private fun prettifyFileName(displayName: String?): String {
        val base = (displayName ?: "Untitled Book").substringBeforeLast(".pdf", displayName ?: "Untitled Book")
        return base.replace('_', ' ').replace('-', ' ').trim().ifBlank { "Untitled Book" }
    }
}
