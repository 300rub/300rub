<?php

/**
 * Variables
 *
 * @var integer                                $blockId
 * @var integer                                $type
 * @var \ss\models\blocks\menu\DesignMenuModel $designMenuModel
 * @var array                                  $tree
 *
 * phpcs:disable Squiz.Functions.GlobalFunction
 * phpcs:disable PSR1.Files.SideEffects
 */

echo sprintf(
    '<div class="block-%s menu menu-%s">',
    $blockId,
    $type
);

/**
 * Builds structure
 *
 * @param array $tree  Tree
 * @param int   $level Lever
 *
 * @return string
 */
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
            $levelClass .= '-active';
        }

        echo sprintf(
            '<a href="%s" class="%s">%s</a>',
            $instance['url'],
            $levelClass,
            $instance['name']
        );

        if (count($instance['children']) > 0) {
            printMenuTree($instance['children'], ($level + 1));
        }

        echo '</li>';
    }

    echo '</ul>';
}
printMenuTree($tree, 1);

echo '</div>';
