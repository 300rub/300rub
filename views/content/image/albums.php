<?php

/**
 * Variables
 *
 * @var int                                       $blockId
 * @var \ss\models\blocks\image\ImageGroupModel[] $albums
 */

echo sprintf('<div class="block-%s">', $blockId);

foreach ($albums as $album) {
    echo '<div class="album">';

    $image = $album->getCover();
    if ($image !== null) {
        echo sprintf(
            '<a href="%s">',
            $album->getUri()
        );
        echo sprintf(
            '<img src="%s" alt="%s" title="%s" />',
            $image->get('thumbFileModel')->getUrl(),
            $image->get('alt'),
            $image->get('alt')
        );
        echo '</a>';
    }

    echo $album->getCount();

    echo sprintf(
        '<a href="%s">%s</a>',
        $album->getUri(),
        $album->get('seoModel')->get('name')
    );
    echo '</div>';
}

echo '</div>';
