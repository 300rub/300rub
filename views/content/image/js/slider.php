<?php

/**
 * Variables
 *
 * @var int                                            $blockId
 * @var \ss\models\blocks\image\DesignImageSliderModel $design
 */

echo 'var options = {};';

if ($design->get('hasAutoPlay') === true) {
    echo 'options.$AutoPlay = 1;';

    $playSpeed = $design->get('playSpeed');
    if ($playSpeed !== 0) {
        echo sprintf('options.$Idle = %s;', $playSpeed * 1000);
    }
}

echo 'options.$FillMode = 5;';

echo 'options.$BulletNavigatorOptions = {};';
echo 'options.$BulletNavigatorOptions.$Class = $JssorBulletNavigator$;';
echo 'options.$BulletNavigatorOptions.$ChanceToShow = 2;';
echo 'options.$BulletNavigatorOptions.$AutoCenter = 1;';
echo 'options.$BulletNavigatorOptions.$Steps = 1;';
echo 'options.$BulletNavigatorOptions.$Rows = 1;';
echo 'options.$BulletNavigatorOptions.$Orientation = 1;';

echo 'options.$ArrowNavigatorOptions = {};';
echo 'options.$ArrowNavigatorOptions.$Class = $JssorArrowNavigator$;';
echo 'options.$ArrowNavigatorOptions.$ChanceToShow = 2;';
echo 'options.$ArrowNavigatorOptions.$AutoCenter = 2;';
echo 'options.$ArrowNavigatorOptions.$Steps = 1;';

echo 'options.$ThumbnailNavigatorOptions = {};';
echo 'options.$ThumbnailNavigatorOptions.$Class = $JssorThumbnailNavigator$;';
echo 'options.$ThumbnailNavigatorOptions.$Orientation = 2;';
echo 'options.$ThumbnailNavigatorOptions.$NoDrag = true;';

$effectValues = $design->getEffectValues();
if (count($effectValues) > 0) {
    echo 'var transitions = [];';

    foreach ($effectValues as $effectValue) {
        echo sprintf('transitions.push(%s);', $effectValue);
    }

    echo 'options.$SlideshowOptions = {};';
    echo 'options.$SlideshowOptions.$Class = $JssorSlideshowRunner$;';
    echo 'options.$SlideshowOptions.$Transitions = transitions;';
    echo 'options.$SlideshowOptions.$TransitionsOrder = 1;';
}

echo sprintf('$(".block-%s .slider-container").each(function() {', $blockId);
echo 'var slider = new $JssorSlider$($(this).attr("id"), options);';

if ($design->get('isFullWidth') === true) {
    echo 'var maxWidth = 3000;';
    echo 'function scaleSlider() {';
    echo 'var containerElement = slider.$Elmt.parentNode;';
    echo 'var containerWidth = containerElement.clientWidth;';
    echo 'if (containerWidth) {';
    echo 'var expectedWidth = Math.min(maxWidth || containerWidth, containerWidth);';
    echo 'slider.$ScaleWidth(expectedWidth);';
    echo '}';
    echo 'else {';
    echo 'window.setTimeout(scaleSlider, 30);';
    echo '}';
    echo '}';
    echo 'scaleSlider();';
    echo '$Jssor$.$AddEvent(window, "load", scaleSlider);';
    echo '$Jssor$.$AddEvent(window, "resize", scaleSlider);';
    echo '$Jssor$.$AddEvent(window, "orientationchange", scaleSlider);';
}

if ($design->get('isFullWidth') === false) {
    echo 'var maxWidth = slider.$ScaleWidth();';
    echo 'function scaleSlider() {';
    echo 'var containerElement = slider.$Elmt.parentNode;';
    echo 'var containerWidth = containerElement.clientWidth;';
    echo 'if (containerWidth) {';
    echo 'var expectedWidth = Math.min(maxWidth || containerWidth, containerWidth);';
    echo 'slider.$ScaleWidth(expectedWidth);';
    echo '}';
    echo 'else {';
    echo 'window.setTimeout(scaleSlider, 30);';
    echo '}';
    echo '}';
    echo 'scaleSlider();';
    echo '$Jssor$.$AddEvent(window, "load", scaleSlider);';
    echo '$Jssor$.$AddEvent(window, "resize", scaleSlider);';
    echo '$Jssor$.$AddEvent(window, "orientationchange", scaleSlider);';
}

echo '});';
