package com.readflow.app.data.pdf

/** Reasons a PDF could not be imported or opened, surfaced to the UI as a plain-language message. */
sealed class PdfException(message: String) : Exception(message) {
    class Encrypted : PdfException("This PDF is password-protected and can't be opened yet.")
    class Corrupted : PdfException("This PDF file appears to be damaged or unreadable.")
    class Empty : PdfException("This PDF has no pages.")
    class InvalidFile : PdfException("The selected file isn't a valid PDF.")
    class NotFound : PdfException("The PDF file couldn't be found.")
    class Io(cause: Throwable) : PdfException("Something went wrong while reading the file: ${cause.message}")
}
