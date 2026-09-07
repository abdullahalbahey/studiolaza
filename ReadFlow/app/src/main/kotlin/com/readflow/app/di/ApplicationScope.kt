package com.readflow.app.di

import android.util.Log
import dagger.Module
import dagger.Provides
import dagger.hilt.InstallIn
import dagger.hilt.components.SingletonComponent
import kotlinx.coroutines.CoroutineExceptionHandler
import kotlinx.coroutines.CoroutineScope
import kotlinx.coroutines.Dispatchers
import kotlinx.coroutines.SupervisorJob
import javax.inject.Qualifier
import javax.inject.Singleton

@Qualifier
@Retention(AnnotationRetention.BINARY)
annotation class ApplicationScope

@Module
@InstallIn(SingletonComponent::class)
object CoroutineScopeModule {
    @Provides
    @Singleton
    @ApplicationScope
    fun provideApplicationScope(): CoroutineScope {
        // A SupervisorJob alone only stops sibling coroutines from cancelling each other - it does
        // NOT catch exceptions. Without this handler, any unhandled exception in any appScope.launch
        // block anywhere in the app (progress saves, session recording, indexing, etc.) propagates to
        // the thread's default uncaught-exception handler and kills the whole app process. These are
        // all best-effort background writes; losing one write is far better than crashing the app.
        val exceptionHandler = CoroutineExceptionHandler { _, throwable ->
            Log.e("ReadFlow", "Unhandled exception in application-scope coroutine", throwable)
        }
        return CoroutineScope(SupervisorJob() + Dispatchers.Default + exceptionHandler)
    }
}
