<?php

/**
 * Variables
 *
 * @var int    $blockId
 * @var string $instances
 * @var int    $viewType
 */

use ss\models\blocks\record\DesignRecordModel;

echo sprintf('<div class="record-list block-%s">', $blockId);

switch ($viewType) {
    case DesignRecordModel::SHORT_CART_VIEW_TYPE_GRID_1:
        $viewType = 'view-grid-1';
        break;
    case DesignRecordModel::SHORT_CART_VIEW_TYPE_GRID_2:
        $viewType = 'view-grid-2';
        break;
    case DesignRecordModel::SHORT_CART_VIEW_TYPE_GRID_3:
        $viewType = 'view-grid-3';
        break;
    default:
        $viewType = 'view-list';
        break;
}

echo sprintf('<div class="instances %s">%s</div>', $viewType, $instances);

echo '</div>';