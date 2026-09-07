package com.readflow.app.ui.reader

import android.graphics.Bitmap
import androidx.compose.foundation.Image
import androidx.compose.foundation.gestures.awaitEachGesture
import androidx.compose.foundation.gestures.calculatePan
import androidx.compose.foundation.gestures.calculateZoom
import androidx.compose.foundation.layout.Box
import androidx.compose.foundation.layout.fillMaxSize
import androidx.compose.material3.CircularProgressIndicator
import androidx.compose.material3.MaterialTheme
import androidx.compose.runtime.Composable
import androidx.compose.runtime.getValue
import androidx.compose.runtime.mutableFloatStateOf
import androidx.compose.runtime.remember
import androidx.compose.runtime.setValue
import androidx.compose.ui.Alignment
import androidx.compose.ui.Modifier
import androidx.compose.ui.geometry.Offset
import androidx.compose.ui.graphics.asImageBitmap
import androidx.compose.ui.graphics.graphicsLayer
import androidx.compose.ui.input.pointer.pointerInput
import androidx.compose.ui.input.pointer.positionChanged
import androidx.compose.ui.layout.ContentScale
import androidx.compose.ui.layout.onSizeChanged

/**
 * Renders one PDF page bitmap, preserving the PDF's original layout. Requests the bitmap at the
 * container's own pixel width so nothing is upscaled, and supports pinch-to-zoom / pan on top.
 */
@Composable
fun PdfPageView(
    pageIndex: Int,
    bitmap: Bitmap?,
    fitWholePage: Boolean,
    onWidthMeasured: (Int) -> Unit,
    modifier: Modifier = Modifier
) {
    var scale by remember(pageIndex) { mutableFloatStateOf(1f) }
    var offset by remember(pageIndex) { mutableFloatStateOf(0f) }
    var offsetY by remember(pageIndex) { mutableFloatStateOf(0f) }

    Box(
        modifier = modifier
            .fillMaxSize()
            .onSizeChanged { size -> if (size.width > 0) onWidthMeasured(size.width) }
            .pointerInput(pageIndex) {
                // Deliberately not detectTransformGestures: it consumes every drag, including a
                // plain single-finger swipe, which would stop the enclosing HorizontalPager from
                // ever seeing the touch and turning the page. Only claim the gesture for an actual
                // pinch (2+ pointers) or a one-finger pan while already zoomed in - otherwise leave
                // it unconsumed so a swipe at the default zoom level reaches the pager.
                awaitEachGesture {
                    do {
                        val event = awaitPointerEvent()
                        val zoomChange = event.calculateZoom()
                        val panChange = event.calculatePan()
                        val isMultiTouch = event.changes.size > 1
                        if (isMultiTouch || scale > 1f) {
                            if (zoomChange != 1f || panChange != Offset.Zero) {
                                scale = (scale * zoomChange).coerceIn(1f, 4f)
                                if (scale > 1f) {
                                    offset += panChange.x
                                    offsetY += panChange.y
                                } else {
                                    offset = 0f
                                    offsetY = 0f
                                }
                            }
                            event.changes.forEach { if (it.positionChanged()) it.consume() }
                        }
                    } while (event.changes.any { it.pressed })
                }
            },
        contentAlignment = Alignment.Center
    ) {
        if (bitmap != null) {
            Image(
                bitmap = bitmap.asImageBitmap(),
                contentDescription = null,
                contentScale = if (fitWholePage) ContentScale.Fit else ContentScale.FillWidth,
                modifier = Modifier
                    .fillMaxSize()
                    .graphicsLayer(
                        scaleX = scale,
                        scaleY = scale,
                        translationX = offset,
                        translationY = offsetY
                    )
            )
        } else {
            CircularProgressIndicator(color = MaterialTheme.colorScheme.primary)
        }
    }
}
