<?php

/**
 * Variables
 *
 * @var array $item
 *
 * phpcs:disable PSR1.Files.SideEffects
 */

echo sprintf(
    '<div class="grid width-%s" ' .
    'style="margin-left: %s%%;">%s</div>',
    $item['width'],
    $item['left'],
    $item['html']
);
