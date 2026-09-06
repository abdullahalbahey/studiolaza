# PDFBox-Android
-dontwarn org.apache.**
-dontwarn org.bouncycastle.**
-keep class com.tom_roush.pdfbox.** { *; }
-keep class com.tom_roush.harmony.** { *; }
-keep class com.tom_roush.fontbox.** { *; }

# Room
-keep class * extends androidx.room.RoomDatabase
-dontwarn androidx.room.paging.**

# Keep data classes used by Room / DataStore serialization
-keepclassmembers class com.readflow.app.data.local.db.** { *; }

# Hilt / Dagger generated code is kept automatically by the Hilt Gradle plugin
