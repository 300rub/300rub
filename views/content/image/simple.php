<?php

/**
 * Variables
 *
 * @var int                                          $blockId
 * @var \ss\models\blocks\image\ImageInstanceModel[] $images
 */

echo sprintf('<div class="block-%s">', $blockId);

foreach ($images as $image) {
    echo '<div class="image-container">';
        echo sprintf(
            '<img src="%s" alt="%s" title="%s" class="image" />',
            $image->get('viewFileModel')->getUrl(),
            $image->get('alt'),
            $image->get('alt')
        );
        echo sprintf(
            '<div class="description">%s</div>',
            $image->get('alt')
        );
    echo '</div>';
}

echo '</div>';