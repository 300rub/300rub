<?php

/**
 * Variables
 *
 * @var int                                            $blockId
 * @var \ss\models\blocks\record\RecordModel           $record
 * @var \ss\models\blocks\record\RecordInstanceModel[] $recordInstances
 */

echo sprintf('<div class="block-%s">', $blockId);

foreach ($recordInstances as $recordInstance) {
    echo '<div class="record-card">';

    if ($record->get('hasCover') === true
        && (int)$recordInstance->get('coverImageInstanceId') > 0
    ) {
        var_dump($recordInstance->get('coverImageInstanceModel'));
    }

    echo '</div>';
}

echo '</div>';
