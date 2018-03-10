<?php

/**
 * Variables
 *
 * @var int   $blockId
 * @var array $list
 */

echo sprintf('<div class="block-%s">', $blockId);

foreach ($list as $item) {
    echo '<div class="group">';
        echo sprintf(
            '<img src="%s" alt="%s" title="%s" class="cover" />',
            $item['url'],
            $item['alt'],
            $item['alt']
        );

        echo sprintf(
            '<a href="%s" class="link">%s</a>',
            $item['url'],
            $item['alt']
        );
    echo '</div>';
}

echo '</div>';
