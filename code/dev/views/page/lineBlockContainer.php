<?php

/**
 * Variables
 *
 * @var array $data
 * @var array $item
 *
 * phpcs:disable PSR1.Files.SideEffects
 */

$html .= sprintf(
    '<div class="grid width-%s" ' .
    'style="margin-left: %s%%;">%s</div>',
    $item['width'],
    $item['left'],
    $data
);
