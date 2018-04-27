<?php

/**
 * Variables
 *
 * @var int                                          $blockId
 * @var \ss\models\blocks\record\RecordModel         $record
 * @var \ss\models\blocks\record\DesignRecordModel   $designRecordModel
 * @var \ss\models\blocks\record\RecordInstanceModel $recordInstance
 * @var string                                       $text
 * @var string                                       $imagesHtml
 */

use ss\models\blocks\record\DesignRecordModel;

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
    '<div class="full-card-date %s">%s</div>',
    $dateClass,
    $recordInstance->get('date')->format($record->getFullCardDateFormat())
);

echo sprintf(
    '<h1 class="full-card-title">%s</h1>',
    $recordInstance->get('seoModel')->get('name')
);

if ($record->get('hasImages') === true) {
    echo $imagesHtml;
}

echo sprintf(
    '<div class="full-card-text">%s</div>',
    $text
);

echo '</div>';