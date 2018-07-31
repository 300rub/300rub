<?php

/**
 * Variables
 *
 * @var integer $blockId
 * @var integer $type
 * @var string  $tree
 */

echo sprintf(
    '<div class="block-%s menu menu-%s">%s</div>',
    $blockId,
    $type,
    $tree
);
