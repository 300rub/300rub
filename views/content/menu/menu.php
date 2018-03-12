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

        switch ($level) {
            case 1:
                $levelClass = 'first-level';
                break;
            case 2:
                $levelClass = 'second-level';
                break;
            default:
                $levelClass = 'last-level';
                break;
        }

        if ($instance['isActive'] === true) {
            $activeClass = sprintf('%s-active', $levelClass);
        }

        echo sprintf(
            '<a href="%s" class="%s">%s</a>',
            $instance['url'],
            $levelClass,
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
