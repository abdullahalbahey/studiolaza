package com.readflow.app.data.pdf

import android.graphics.Bitmap
import android.graphics.Color
import android.graphics.pdf.PdfRenderer
import android.os.ParcelFileDescriptor
import kotlinx.coroutines.Dispatchers
import kotlinx.coroutines.sync.Mutex
import kotlinx.coroutines.sync.withLock
import kotlinx.coroutines.withContext
import java.io.Closeable
import java.io.File

/**
 * Renders individual pages of a PDF to bitmaps on demand using the platform's
 * [PdfRenderer], which preserves the PDF's original layout exactly. Never loads
 * the whole document into memory - only one page bitmap is materialized at a time.
 *
 * Not thread-safe by itself; all access is serialized through [mutex] since
 * [PdfRenderer] only allows one open page at a time.
 */
class PdfPageRenderer(private val filePath: String) : Closeable {

    private val mutex = Mutex()
    private var pfd: ParcelFileDescriptor? = null
    private var renderer: PdfRenderer? = null

    val pageCount: Int get() = renderer?.pageCount ?: 0

    suspend fun open() = withContext(Dispatchers.IO) {
        mutex.withLock {
            if (renderer != null) return@withLock
            val file = File(filePath)
            if (!file.exists()) throw PdfException.NotFound()
            try {
                pfd = ParcelFileDescriptor.open(file, ParcelFileDescriptor.MODE_READ_ONLY)
                renderer = PdfRenderer(pfd!!)
                if (renderer!!.pageCount <= 0) throw PdfException.Empty()
            } catch (e: SecurityException) {
                closeInternal()
                throw PdfException.Encrypted()
            } catch (e: PdfException) {
                closeInternal()
                throw e
            } catch (e: Exception) {
                closeInternal()
                throw PdfException.Corrupted()
            }
        }
    }

    suspend fun pageSize(index: Int): Pair<Int, Int> = withContext(Dispatchers.IO) {
        mutex.withLock {
            val r = renderer ?: throw PdfException.NotFound()
            r.openPage(index).use { page -> page.width to page.height }
        }
    }

    /** Renders [index] (0-based) scaled so its width matches [targetWidthPx]. */
    suspend fun renderPage(index: Int, targetWidthPx: Int): Bitmap = withContext(Dispatchers.IO) {
        mutex.withLock {
            val r = renderer ?: throw PdfException.NotFound()
            r.openPage(index).use { page ->
                val safeWidth = targetWidthPx.coerceAtLeast(1)
                val scale = safeWidth / page.width.toFloat()
                val height = (page.height * scale).toInt().coerceAtLeast(1)
                val bitmap = Bitmap.createBitmap(safeWidth, height, Bitmap.Config.ARGB_8888)
                bitmap.eraseColor(Color.WHITE)
                page.render(bitmap, null, null, android.graphics.pdf.PdfRenderer.Page.RENDER_MODE_FOR_DISPLAY)
                bitmap
            }
        }
    }

    private fun closeInternal() {
        renderer?.close()
        pfd?.close()
        renderer = null
        pfd = null
    }

    override fun close() {
        closeInternal()
    }
}
