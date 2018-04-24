<?php

/**
 * Variables
 *
 * @var \ss\models\blocks\image\ImageGroupModel[] $albums
 */

foreach ($albums as $album) {
    echo '<div class="album">';

    $image = $album->getCover();
    echo sprintf(
        '<a href="%s" class="image-container">',
        $album->getUri()
    );

    if ($image !== null) {
        echo sprintf(
            '<img src="%s" alt="%s" title="%s" class="image" />',
            $image->get('thumbFileModel')->getUrl(),
            $image->get('alt'),
            $image->get('alt')
        );
    }

    echo sprintf('<span class="count">%s</span>', $album->getCount());

    echo '</a>';

    echo sprintf(
        '<a href="%s" class="name">%s</a>',
        $album->getUri(),
        $album->get('seoModel')->get('name')
    );

    echo '<div class="clear"></div>';

    echo '</div>';
}
