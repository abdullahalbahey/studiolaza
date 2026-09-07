# PDFBox-Android
-dontwarn org.apache.**
-dontwarn org.bouncycastle.**
-keep class com.tom_roush.pdfbox.** { *; }
-keep class com.tom_roush.harmony.** { *; }
-keep class com.tom_roush.fontbox.** { *; }
# PDFBox-Android's JPXFilter references com.gemalto.jp2 (a JPEG2000 codec) as an optional
# dependency it never bundles - we don't ship it either since JPX/JPEG2000 images inside a PDF
# are rare and the filter degrades gracefully without it. Without this, R8 in full mode treats
# the missing classes as a hard build error rather than just a warning.
-dontwarn com.gemalto.jp2.**

# Room
-keep class * extends androidx.room.RoomDatabase
-dontwarn androidx.room.paging.**

# Keep data classes used by Room / DataStore serialization
-keepclassmembers class com.readflow.app.data.local.db.** { *; }

# Hilt / Dagger generated code is kept automatically by the Hilt Gradle plugin
