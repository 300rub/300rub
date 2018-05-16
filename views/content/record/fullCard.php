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

echo sprintf('<div class="block-%s full-card">', $blockId);

echo sprintf(
    '<h1 class="full-card-title">%s</h1>',
    $recordInstance->get('seoModel')->get('name')
);

$dateValue = $recordInstance
    ->get('date')
    ->format($record->getFullCardDateFormat());

if ($dateValue !== '') {
    echo sprintf(
        '<div class="full-card-date">%s</div>',
        $recordInstance->get('date')->format($record->getFullCardDateFormat())
    );
}

if ($record->get('hasImages') === true) {
    echo sprintf('<div class="full-card-images">%s</div>', $imagesHtml);
}

echo sprintf(
    '<div class="full-card-text">%s</div>',
    $text
);

echo '</div>';
