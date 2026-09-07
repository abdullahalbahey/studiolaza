package com.readflow.app.data.drive

import com.readflow.app.data.pdf.ImportedPdfInfo
import com.readflow.app.data.pdf.PdfImporter
import kotlinx.coroutines.Dispatchers
import kotlinx.coroutines.withContext
import org.json.JSONObject
import java.io.BufferedInputStream
import java.io.IOException
import java.net.HttpURLConnection
import java.net.URL
import java.net.URLEncoder
import javax.inject.Inject
import javax.inject.Singleton

data class DriveFile(val id: String, val name: String)

sealed class DriveFolderException(message: String) : Exception(message) {
    class InvalidLink : DriveFolderException("That doesn't look like a Google Drive folder link.")
    class MissingApiKey : DriveFolderException("Importing a Drive folder needs a Google Drive API key. Add one in Settings first.")
    class NotFoundOrPrivate : DriveFolderException(
        "This folder couldn't be read. Make sure it's shared as \"Anyone with the link\" and the folder ID is correct."
    )
    class Network(message: String) : DriveFolderException(message)
}

/**
 * Lists and downloads PDFs from a public Google Drive folder using the Drive API v3 directly
 * over HTTPS (no extra HTTP client dependency - [HttpURLConnection] and the platform's built-in
 * `org.json` are enough). Listing a folder's contents always requires an API key; there's no
 * unauthenticated way to do it.
 */
@Singleton
class DriveFolderImporter @Inject constructor() {

    companion object {
        private val FOLDER_ID_REGEX = Regex("/folders/([a-zA-Z0-9_-]{10,})")
        private val BARE_ID_REGEX = Regex("^[a-zA-Z0-9_-]{10,}$")

        fun extractFolderId(input: String): String? {
            val trimmed = input.trim()
            if (trimmed.isEmpty()) return null
            FOLDER_ID_REGEX.find(trimmed)?.let { return it.groupValues[1] }
            if (BARE_ID_REGEX.matches(trimmed)) return trimmed
            return null
        }

        private fun enc(value: String): String = URLEncoder.encode(value, "UTF-8")
    }

    suspend fun listPdfFiles(folderId: String, apiKey: String): List<DriveFile> = withContext(Dispatchers.IO) {
        val files = mutableListOf<DriveFile>()
        var pageToken: String? = null
        do {
            val query = enc("'$folderId' in parents and mimeType='application/pdf' and trashed=false")
            val urlStr = buildString {
                append("https://www.googleapis.com/drive/v3/files?q=")
                append(query)
                append("&fields=nextPageToken,files(id,name)&pageSize=1000&key=")
                append(enc(apiKey))
                if (pageToken != null) {
                    append("&pageToken=")
                    append(enc(pageToken!!))
                }
            }
            val connection = URL(urlStr).openConnection() as HttpURLConnection
            connection.requestMethod = "GET"
            connection.connectTimeout = 15_000
            connection.readTimeout = 20_000
            try {
                val code = connection.responseCode
                when {
                    code == 404 || code == 403 -> throw DriveFolderException.NotFoundOrPrivate()
                    code !in 200..299 -> throw DriveFolderException.Network("Google Drive returned an error ($code) while listing this folder.")
                }
                val body = connection.inputStream.bufferedReader().use { it.readText() }
                val json = JSONObject(body)
                val filesArray = json.optJSONArray("files")
                if (filesArray != null) {
                    for (i in 0 until filesArray.length()) {
                        val obj = filesArray.getJSONObject(i)
                        files += DriveFile(obj.getString("id"), obj.getString("name"))
                    }
                }
                pageToken = if (json.has("nextPageToken")) json.getString("nextPageToken") else null
            } catch (e: DriveFolderException) {
                throw e
            } catch (e: IOException) {
                throw DriveFolderException.Network("Could not reach Google Drive to list this folder.")
            } finally {
                connection.disconnect()
            }
        } while (pageToken != null)
        files
    }

    /** Downloads [file]'s bytes and hands them straight to [pdfImporter] without buffering the whole file in memory. */
    suspend fun downloadAndImport(file: DriveFile, apiKey: String, pdfImporter: PdfImporter): ImportedPdfInfo =
        withContext(Dispatchers.IO) {
            val urlStr = "https://www.googleapis.com/drive/v3/files/${enc(file.id)}?alt=media&key=${enc(apiKey)}"
            val connection = URL(urlStr).openConnection() as HttpURLConnection
            connection.requestMethod = "GET"
            connection.connectTimeout = 15_000
            connection.readTimeout = 60_000
            try {
                val code = connection.responseCode
                if (code !in 200..299) {
                    throw DriveFolderException.Network("Couldn't download \"${file.name}\" from Drive (error $code).")
                }
                BufferedInputStream(connection.inputStream).use { input ->
                    pdfImporter.importFromStream(input, file.name)
                }
            } finally {
                connection.disconnect()
            }
        }
}
