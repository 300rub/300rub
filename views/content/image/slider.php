<?php

/**
 * Variables
 *
 * @var int $blockId
 * @var \ss\models\blocks\image\ImageInstanceModel[] $images
 * @var \ss\models\blocks\image\ImageModel           $image
 */

echo sprintf('<div class="block-%s">', $blockId);

if (count($images) > 0) {
    $width = $image->get('cropWidth');
    $height = $image->get('cropHeight');

    $minWidth = 2000;
    $minHeight = 2000;

    $imageHtml = '';
    foreach ($images as $imageInstance) {
        $imageHtml .= sprintf(
            '<div><img data-u="image" src="%s" /></div>',
            $imageInstance->get('viewFileModel')->getUrl()
        );

        if ($imageInstance->get('width') < $minWidth) {
            $minWidth = $imageInstance->get('width');
        }

        if ($imageInstance->get('height') < $minHeight) {
            $minHeight = $imageInstance->get('height');
        }
    }

    if ($width === 0
        || $height === 0
    ) {
        $width = $minWidth;
        $height = $minHeight;
    }

    echo sprintf(
        '<div id="slider-%s" class="slider-container" ' .
        'style="width:%spx;height:%spx;">',
        uniqid(),
        $width,
        $height
    );

    echo sprintf(
        '<div data-u="slides" class="slides" ' .
        'style="width:%spx;height:%spx;">',
        $width,
        $height
    );

    echo $imageHtml;

    echo '</div>';
?>

    <div data-u="navigator" class="jssorb031" style="position:absolute;bottom:12px;right:12px;" data-autocenter="1" data-scale="0.5" data-scale-bottom="0.75">
        <div data-u="prototype" class="i" style="width:16px;height:16px;">
            <svg viewBox="0 0 16000 16000" style="position:absolute;top:0;left:0;width:100%;height:100%;">
                <circle class="b" cx="8000" cy="8000" r="5800"></circle>
            </svg>
        </div>
    </div>

    <div data-u="arrowleft" class="jssora051" style="width:55px;height:55px;top:0px;left:25px;" data-autocenter="2" data-scale="0.75" data-scale-left="0.75">
        <svg viewBox="0 0 16000 16000" style="position:absolute;top:0;left:0;width:100%;height:100%;">
            <polyline class="a" points="11040,1920 4960,8000 11040,14080 "></polyline>
        </svg>
    </div>

    <div data-u="arrowright" class="jssora051" style="width:55px;height:55px;top:0px;right:25px;" data-autocenter="2" data-scale="0.75" data-scale-right="0.75">
        <svg viewBox="0 0 16000 16000" style="position:absolute;top:0;left:0;width:100%;height:100%;">
            <polyline class="a" points="4960,1920 11040,8000 4960,14080 "></polyline>
        </svg>
    </div>

    <style>
        .jssora051 {display:block;position:absolute;cursor:pointer;}
        .jssora051 .a {fill:none;stroke:#fff;stroke-width:360;stroke-miterlimit:10;}
        .jssora051:hover {opacity:.8;}
        .jssora051.jssora051dn {opacity:.5;}
        .jssora051.jssora051ds {opacity:.3;pointer-events:none;}
    </style>
<?php
    echo '</div>';
}

echo '</div>';
