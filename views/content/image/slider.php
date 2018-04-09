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
    echo '</div>';
}

echo '</div>';
