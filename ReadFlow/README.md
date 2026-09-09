# ReadFlow

A local-first PDF/ebook reading app for Android. No account, no backend, no ads. Import a PDF,
read it comfortably across sessions, and the app remembers exactly where you stopped.

## Architecture

MVVM + repository pattern, Kotlin, Jetpack Compose, Material 3, Hilt for DI, Room for structured
local data, DataStore for preferences. One Gradle module (`app`) — a second module would buy
nothing at this size and the spec explicitly asks not to overengineer v1.

```
app/src/main/kotlin/com/readflow/app/
  data/
    local/db/          Room entities, DAOs, AppDatabase (9 tables)
    local/datastore/    Preferences DataStore (theme, reader defaults, library sort/filter)
    pdf/                 PdfImporter, PdfPageRenderer, PdfTextExtractor, PdfBoxInitializer
    repository/          BookRepository, BookContentRepository, Bookmark/Note/Highlight/
                         Session/Goal/Reminder repositories
    backup/              JSON export/import of reading data
  domain/                Pure, unit-testable calculators (progress, stats, goals, reminders)
  reminders/             AlarmManager scheduling, BroadcastReceivers, notification building
  di/                    Hilt modules
  ui/                    One package per screen; Compose + ViewModel per screen
```

### PDF engine

Two libraries, used for what each is actually good at:

- **`android.graphics.pdf.PdfRenderer`** (platform, no dependency) renders pages to bitmaps
  exactly as the PDF is laid out. Used for Original PDF mode and thumbnails. One page is
  rendered at a time, at the container's own pixel width — nothing is upscaled and the whole
  document is never held in memory. A small bounded bitmap cache (`ReaderViewModel`) keeps
  memory flat on a 500+ page book.
- **`com.tom-roush:pdfbox-android`** extracts text, the outline (table of contents), and basic
  metadata. Extraction is lazy per page (cached in a `page_text` Room table) and backfilled for
  the whole book in the background right after import, so search works everywhere once that
  finishes, without blocking the import itself.

Encrypted, corrupted, empty, or otherwise invalid PDFs are caught as typed `PdfException`s and
shown as a plain-language message — they never crash the app. A PDF with no extractable text
(a scanned book) still opens and reads fine in Original PDF mode; Reading Mode, search, and
highlighting are simply unavailable for it, and the UI says so.

### Reading Mode vs Original PDF

Original PDF mode is the bitmap renderer above, in either page-by-page (`HorizontalPager`) or
continuous vertical scroll. Reading Mode reflows the same per-page extracted text into an
ebook-style column with configurable font, size, line/paragraph spacing, and width, using the
*same* page boundaries as the PDF — so page numbers and progress stay meaningful when switching
between the two modes on the same book.

### Highlighting

`PdfRenderer`'s bitmap pages have no text layer, so highlighting only makes sense in Reading
Mode, where the extracted text is real, selectable text. Plain text selection (via
`SelectionContainer`) gives Copy/Share for free through Android's own selection toolbar;
long-pressing a paragraph opens a color + note picker that saves a `Highlight` row tied to that
paragraph. This is a deliberate simplification of "highlight an arbitrary substring across the
original PDF" — that would need mapping text offsets back to PDF glyph coordinates, which is out
of scope for v1 and not something `PdfRenderer` gives you.

### Reminders

`AlarmManager.setExactAndAllowWhileIdle` (falling back to inexact if exact-alarm permission is
off) plus a `BroadcastReceiver` that shows the notification and reschedules its own next
occurrence — not `WorkManager`, since these need to fire at a specific wall-clock time, which is
what `AlarmManager` is for. A `BOOT_COMPLETED` receiver reschedules every enabled reminder after
a reboot, since exact alarms don't survive one.

### Progress persistence

Every page turn calls `BookRepository.updateProgress` immediately (fire-and-forget, on an
application-scoped `CoroutineScope` so it isn't cancelled if the screen is leaving). A
`ReadingSession` is recorded and reading time is added on `ON_PAUSE`/leaving the reader, not
only on a clean close, so backgrounding the app or killing the process loses at most the
currently-open session's time-on-book — never the page position.

## What's real vs. simplified in this v1

Everything listed in the brief is implemented and wired end-to-end: import, native+text PDF
rendering, Reading Mode, TOC, search, bookmarks, notes, highlights, reading goals, reading
statistics (streaks, averages, estimated completion from actual pace), reminders with exact
alarms, light/dark/sepia/high-contrast themes, settings, JSON export/import of reading data, and
duplicate-import handling. Deliberate v1 simplifications, each noted in code where it applies:

- Highlighting is paragraph-granularity in Reading Mode only (see above) — not free-form
  substring highlighting over the original PDF bitmap.
- OCR for scanned PDFs is not implemented; the architecture doesn't block adding it later
  (`PdfTextExtractor` is the single seam it would plug into) but no OCR ships in v1, per the
  brief's own instruction not to require it.
- AI features (summarize, ask questions, flashcards, etc.) are explicitly out of v1 per the
  brief. Nothing in the data model or reader precludes adding them later, and no book content
  is ever sent anywhere — the app has no network calls at all.

## Tests

`app/src/test/kotlin` has real unit tests, not placeholders:

- `domain/ProgressCalculatorTest`, `StatsCalculatorTest`, `GoalCalculatorTest`,
  `ReminderScheduleCalculatorTest` — pure logic, zero Android dependencies. **These were
  actually compiled and run** (in a throwaway plain-Kotlin JVM harness against Maven Central,
  since that's what this sandbox has network access to) and all 31 cases pass.
- `data/local/db/BookDaoTest` — Room + Robolectric, covering insert/query, duplicate detection
  by file hash, progress/reading-time updates, and cascade delete of a book's bookmarks. This
  one needs the Android framework jars Robolectric pulls in, which this sandbox can't fetch (see
  below), so it's written to the standard pattern but not executed here — run it with
  `./gradlew test` on a machine with normal internet access.

## Building the APK

**This sandbox could not build the APK itself.** Its network policy allows Maven Central and the
Gradle plugin portal but blocks `dl.google.com` / `maven.google.com` — which is where every
AndroidX, Compose, and Room artifact (and the Android SDK itself) is hosted. There's no way
around that from in here; a normal machine or CI runner doesn't have this restriction.

To build it yourself:

1. Install Android Studio (Koala or newer) or just the command-line SDK tools, with
   **SDK Platform 34** and **Build-Tools 34.0.0**.
2. Open the `ReadFlow/` folder in Android Studio (it will offer to sync Gradle — let it; this
   downloads AndroidX/Compose/Room/Hilt/PdfBox-Android from Google's Maven and Maven Central,
   which needs real internet access) — or from a terminal in `ReadFlow/`:

   ```bash
   ./gradlew assembleDebug
   ```

   The debug APK lands at `app/build/outputs/apk/debug/app-debug.apk`.

3. For a release build, either let Android Studio's Build > Generate Signed Bundle/APK flow
   create and sign a keystore, or set these environment variables before running Gradle:

   ```bash
   export READFLOW_KEYSTORE_PATH=/path/to/your.keystore
   export READFLOW_KEYSTORE_PASSWORD=...
   export READFLOW_KEY_ALIAS=...
   export READFLOW_KEY_PASSWORD=...
   ./gradlew assembleRelease
   ```

   The release APK lands at `app/build/outputs/apk/release/app-release.apk`. Without those
   variables set, `assembleRelease` still runs (minified, `proguard-rules.pro` applied) but
   produces an **unsigned** APK you'd need to sign separately before installing.

4. Run tests with `./gradlew test` (unit tests) — the Robolectric DAO test in particular needs
   real internet access to fetch Robolectric's Android framework jars the first time.

### Installing

`adb install app/build/outputs/apk/debug/app-debug.apk`, or copy the APK to the device and open
it (allow "install unknown apps" for whichever app you use to open it). Minimum Android 8.0
(API 26); target/compile SDK 34.

## Privacy

Everything lives in this app's private storage: imported PDFs are copied into
`filesDir/books/`, thumbnails into `filesDir/covers/`, and all structured data (progress,
bookmarks, notes, highlights, goals, reminders, reading sessions) in a local Room database. The
app makes no network calls, has no account/login, and Export only ever writes reading *data*
(not the PDFs themselves) to a file you explicitly choose via the system file picker.
