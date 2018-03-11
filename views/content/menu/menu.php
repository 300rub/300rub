<?php

/**
 * Variables
 *
 * @var integer                                $blockId
 * @var integer                                $type
 * @var \ss\models\blocks\menu\DesignMenuModel $designMenuModel
 * @var array                                  $tree
 */

echo sprintf(
    '<div class="block-%s menu menu-%s">',
    $blockId,
    $type
);

echo '<ul>';

foreach ($tree as $instance) {
    echo sprintf(
        '<li><a href="%s">%s</a></li>',
        $instance['url'],
        $instance['name']
    );
}

echo '</ul>';
echo '</div>';
