package com.readflow.app.ui.common

import android.content.Context
import android.net.Uri
import android.provider.OpenableColumns

fun Context.queryDisplayName(uri: Uri): String? {
    return try {
        contentResolver.query(uri, arrayOf(OpenableColumns.DISPLAY_NAME), null, null, null)?.use { cursor ->
            val nameIndex = cursor.getColumnIndex(OpenableColumns.DISPLAY_NAME)
            if (cursor.moveToFirst() && nameIndex >= 0) cursor.getString(nameIndex) else null
        }
    } catch (e: Exception) {
        null
    }
}
