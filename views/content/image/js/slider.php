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
}

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
echo 'new $JssorSlider$($(this).attr("id"), options);';
echo '});';
