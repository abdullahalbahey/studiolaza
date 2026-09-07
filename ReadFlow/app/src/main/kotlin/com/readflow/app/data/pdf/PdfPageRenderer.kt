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
            } catch (e: Throwable) {
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
                val pageWidth = page.width.coerceAtLeast(1)
                val pageHeight = page.height.coerceAtLeast(1)
                val safeWidth = targetWidthPx.coerceAtLeast(1)
                val scale = safeWidth / pageWidth.toFloat()
                var bitmapWidth = safeWidth
                var bitmapHeight = (pageHeight * scale).toInt().coerceAtLeast(1)

                // Some PDFs - scanned or print-oriented exports especially - have pages far
                // taller (relative to width) than a phone screen. Rendering those at full screen
                // width with no cap can produce a single bitmap tens of megabytes in size; with
                // several pages cached at once (see trimBitmapCache), that reliably
                // OutOfMemoryErrors the whole app. Cap the total pixel budget instead of just
                // matching the requested width, shrinking outlier pages rather than crashing.
                val pixelBudget = MAX_BITMAP_PIXELS
                val actualPixels = bitmapWidth.toLong() * bitmapHeight.toLong()
                if (actualPixels > pixelBudget) {
                    val shrink = kotlin.math.sqrt(pixelBudget.toDouble() / actualPixels.toDouble())
                    bitmapWidth = (bitmapWidth * shrink).toInt().coerceAtLeast(1)
                    bitmapHeight = (bitmapHeight * shrink).toInt().coerceAtLeast(1)
                }

                val bitmap = Bitmap.createBitmap(bitmapWidth, bitmapHeight, Bitmap.Config.ARGB_8888)
                bitmap.eraseColor(Color.WHITE)
                page.render(bitmap, null, null, PdfRenderer.Page.RENDER_MODE_FOR_DISPLAY)
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

    companion object {
        // ~4M pixels (e.g. a 2000x2000-equivalent budget) is plenty sharp for on-screen reading
        // and keeps a single cached page bitmap under ~16MB at ARGB_8888, regardless of a PDF's
        // own page dimensions.
        private const val MAX_BITMAP_PIXELS = 4_000_000L
    }
}
