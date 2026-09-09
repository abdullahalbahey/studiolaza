package com.readflow.app.data.pdf

import android.content.Context
import com.tom_roush.pdfbox.android.PDFBoxResourceLoader

/** PDFBox-Android requires a one-time resource init before any [com.tom_roush.pdfbox.pdmodel.PDDocument] use. */
object PdfBoxInitializer {
    @Volatile private var initialized = false

    fun ensureInit(context: Context) {
        if (initialized) return
        synchronized(this) {
            if (!initialized) {
                PDFBoxResourceLoader.init(context.applicationContext)
                initialized = true
            }
        }
    }
}
