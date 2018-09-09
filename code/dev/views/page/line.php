<?php

/**
 * Variables
 *
 * @var int    $id
 * @var string $lineStructure
 *
 * phpcs:disable PSR1.Files.SideEffects
 */

echo sprintf(
    '<div class="line-%s"><div class="line-container">%s</div></div>',
    $id,
    $lineStructure
);
