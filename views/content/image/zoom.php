<?php

/**
 * Variables
 *
 * @var \ss\models\blocks\image\ImageInstanceModel[] $images
 */

foreach ($images as $image) {
    echo sprintf(
        '<a ' .
        'class="image-container ' .
        'zoom-image-container" ' .
        'data-fancybox="image-group-%s" href="%s">',
        $image->get('imageGroupId'),
        $image->get('viewFileModel')->getUrl()
    );

    echo sprintf(
        '<img src="%s" alt="%s" title="%s" />',
        $image->get('thumbFileModel')->getUrl(),
        $image->get('alt'),
        $image->get('alt')
    );

    echo '</a>';
}
