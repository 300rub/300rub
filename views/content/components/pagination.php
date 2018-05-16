<?php

/**
 * Variables
 *
 * @var array $tree Tree
 */

use ss\application\components\helpers\Pagination;

echo '<div class="pagination">';

foreach ($tree as $item) {
    switch ($item['type']) {
        case Pagination::TYPE_FIRST:
            $value = '<i class="fas fa-chevron-left"></i>' .
                '<i class="fas fa-chevron-left"></i>';
            break;
        case Pagination::TYPE_PREV:
            $value = '<i class="fas fa-chevron-left"></i>';
            break;
        case Pagination::TYPE_NEXT:
            $value = '<i class="fas fa-chevron-right"></i>';
            break;
        case Pagination::TYPE_LAST:
            $value = '<i class="fas fa-chevron-right"></i>' .
                '<i class="fas fa-chevron-right"></i>';
            break;
        default:
            $value = $item['value'];
            break;
    }

    $activeClass = '';
    if ($item['isActive'] === true) {
        $activeClass = 'active';
    }

    echo sprintf(
        '<a href="%s" class="%s">%s</a> ',
        $item['url'],
        $activeClass,
        $value
    );
}

echo '</div>';
