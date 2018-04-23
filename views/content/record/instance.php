<?php

use ss\models\blocks\record\DesignRecordModel;

/**
 * Variables
 *
 * @var int                                          $blockId
 * @var \ss\models\blocks\record\RecordModel         $record
 * @var \ss\models\blocks\record\DesignRecordModel   $designRecordModel
 * @var \ss\models\blocks\record\RecordInstanceModel $recordInstance
 * @var string                                       $text
 */

echo sprintf('<div class="block-%s">', $blockId);

$datePosition = $designRecordModel->get('fullCardDatePosition');
switch ($datePosition) {
    case DesignRecordModel::FULL_CART_DATE_POSITION_LEFT:
        $dateClass = 'float-left';
        break;
    case DesignRecordModel::FULL_CART_DATE_POSITION_RIGHT:
        $dateClass = 'float-right';
        break;
    default:
        $dateClass = 'hidden';
        break;
}
echo sprintf(
    '<div class="date %s">%s</div>',
    $dateClass,
    $recordInstance->get('date')->format($record->getFullCardDateFormat())
);

echo sprintf(
    '<h1>%s</h1>',
    $recordInstance->get('seoModel')->get('name')
);

echo sprintf(
    '<div>%s</div>',
    $text
);

echo '</div>';
