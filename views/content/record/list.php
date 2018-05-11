<?php

/**
 * Variables
 *
 * @var int     $blockId
 * @var string  $instances
 * @var string  $pagination
 * @var boolean $useAutoload
 */

echo sprintf('<div class="block-%s">', $blockId);

echo sprintf('<div class="instances">%s</div>', $instances);

if ($useAutoload === false) {
    echo $pagination;
}

if ($useAutoload === true) {
    echo '<div class="autoload">';
    echo '<i class="fas fa-sync fa-spin"></i>';
    echo '</div>';
}

echo '</div>';
