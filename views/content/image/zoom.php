<?php

/**
 * Variables
 *
 * @var int $blockId
 * @var \ss\models\blocks\image\ImageInstanceModel[] $images
 */

echo sprintf('<div class="block-%s">', $blockId);

foreach ($images as $image) {
    echo sprintf(
        '<a data-fancybox="image-group-%s" href="%s"><img src="%s" alt="%s" title="%s" /></a>',
        $image->get('imageGroupId'),
        $image->get('viewFileModel')->getUrl(),
        $image->get('thumbFileModel')->getUrl(),
        $image->get('alt'),
        $image->get('alt')
    );
}

echo '</div>';