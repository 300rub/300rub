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

function printMenuTree($tree, $level)
{
    echo '<ul>';
    foreach ($tree as $instance) {
        echo '<li>';

        echo sprintf(
            '<a href="%s" class="level-%s">%s</a>',
            $instance['url'],
            $level,
            $instance['name']
        );

        if (count($instance['children'])) {
            printMenuTree($instance['children'], $level + 1);
        }

        echo '</li>';
    }

    echo '</ul>';
}
printMenuTree($tree, 1);

echo '</div>';
