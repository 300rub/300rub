<?php

/**
 * Variables
 *
 * @var \ss\models\blocks\image\ImageGroupModel $album
 * @var string                                  $uri
 */

echo '<div class="album">';

$image = $album->getCover();
echo sprintf(
    '<a href="%s" class="image-container">',
    $uri
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
    $uri,
    $album->get('seoModel')->get('name')
);

echo '<div class="clear"></div>';

echo '</div>';
