package com.readflow.app.data.repository

import com.readflow.app.data.drive.DriveFolderException
import com.readflow.app.data.drive.DriveFolderImporter
import com.readflow.app.data.pdf.PdfImporter
import javax.inject.Inject
import javax.inject.Singleton

enum class FolderImportOutcome { ADDED, DUPLICATE, FAILED }

data class FolderImportItem(val name: String, val outcome: FolderImportOutcome, val errorMessage: String? = null)

data class FolderImportSummary(val filesFound: Int, val items: List<FolderImportItem>) {
    val added: Int get() = items.count { it.outcome == FolderImportOutcome.ADDED }
    val duplicates: Int get() = items.count { it.outcome == FolderImportOutcome.DUPLICATE }
    val failed: Int get() = items.count { it.outcome == FolderImportOutcome.FAILED }
}

/**
 * Imports every PDF directly inside a public Drive folder, one file at a time (Drive API keys
 * are rate-limited, and one-at-a-time keeps memory bounded since each file streams straight to
 * disk). Each file goes through the same duplicate-by-hash check as a normal local import.
 */
@Singleton
class DriveFolderRepository @Inject constructor(
    private val driveFolderImporter: DriveFolderImporter,
    private val pdfImporter: PdfImporter,
    private val bookRepository: BookRepository
) {
    suspend fun importFolder(
        folderLink: String,
        apiKey: String?,
        onProgress: (done: Int, total: Int, currentName: String) -> Unit
    ): FolderImportSummary {
        val folderId = DriveFolderImporter.extractFolderId(folderLink) ?: throw DriveFolderException.InvalidLink()
        if (apiKey.isNullOrBlank()) throw DriveFolderException.MissingApiKey()

        val files = driveFolderImporter.listPdfFiles(folderId, apiKey)
        val items = mutableListOf<FolderImportItem>()

        files.forEachIndexed { index, file ->
            onProgress(index, files.size, file.name)
            try {
                val info = driveFolderImporter.downloadAndImport(file, apiKey, pdfImporter)
                when (bookRepository.importDriveBook(info)) {
                    is DriveBookImportResult.Success -> items += FolderImportItem(file.name, FolderImportOutcome.ADDED)
                    is DriveBookImportResult.Duplicate -> items += FolderImportItem(file.name, FolderImportOutcome.DUPLICATE)
                }
            } catch (e: Throwable) {
                items += FolderImportItem(file.name, FolderImportOutcome.FAILED, e.message ?: "Import failed")
            }
        }
        onProgress(files.size, files.size, "")

        return FolderImportSummary(files.size, items)
    }
}
