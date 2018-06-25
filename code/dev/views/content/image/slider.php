<?php

/**
 * Variables
 *
 * @var \ss\models\blocks\image\ImageInstanceModel[] $images
 * @var \ss\models\blocks\image\ImageModel           $image
 */

if (count($images) === 0) {
    return '';
}

$width = $image->get('cropWidth');
$height = $image->get('cropHeight');

$maxWidth = 100;
$maxHeight = 100;

$imageHtml = '';
foreach ($images as $imageInstance) {
    $alt = $imageInstance->get('alt');
    $link = $imageInstance->get('link');
    $openElement = '<div>';

    if ($link !== '') {
        $openElement = sprintf('<a href="%s">', $link);
    }

    $imageHtml .= $openElement;
    $imageHtml .= sprintf(
        '<img data-u="image" src="%s" alt="%s" />',
        $imageInstance->get('viewFileModel')->getUrl(),
        $alt
    );
    $imageHtml .= sprintf(
        '<div data-u="thumb">%s</div>',
        $imageInstance->get('alt')
    );
    $closeElement = '</div>';

    if ($link !== '') {
        $closeElement = '</a>';
    }

    $imageHtml .= $closeElement;

    if ($imageInstance->get('width') > $maxWidth) {
        $maxWidth = $imageInstance->get('width');
    }

    if ($imageInstance->get('height') > $maxHeight) {
        $maxHeight = $imageInstance->get('height');
    }
}

if ($width === 0
    || $height === 0
) {
    $width = $maxWidth;
    $height = $maxHeight;
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

echo sprintf(
    '<div ' .
    'data-u="thumbnavigator" ' .
    'class="description-wrapper" ' .
    'style="position:absolute;top:0;left:0;width:%spx;height:32px;">',
    $width
);
echo '<div data-u="slides">';
echo sprintf(
    '<div ' .
    'data-u="prototype" ' .
    'style="position:absolute;top:0;left:0;width:%spx;height:32px;">',
    $width
);
echo '<div ' .
    'class="description" ' .
    'data-u="thumbnailtemplate" ' .
    'style="position:absolute;top:0;left:0;width:100%;height:100%;">' .
    '</div>';
echo '</div>';
echo '</div>';
echo '</div>';

echo '<div data-u="navigator" style="position:absolute;bottom:12px;">';
echo '<div data-u="prototype" class="i" style="width:16px;height:16px;">';
echo '<div class="bullet"></div>';
echo '</div>';
echo '</div>';

echo '<div ' .
    'data-u="arrowleft" ' .
    'class="arrow" ' .
    'style="position:absolute;width:60px;height:60px;left:0">';
echo '<i class="fas fa-chevron-left"></i>';
echo '</div>';

echo '<div ' .
    'data-u="arrowright" ' .
    'class="arrow" ' .
    'style="position:absolute;width:60px;height:60px;right:0">';
echo '<i class="fas fa-chevron-right"></i>';
echo '</div>';

echo '</div>';
