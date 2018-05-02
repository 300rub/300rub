<?php

/**
 * Variables
 *
 * @var int                                             $blockId
 * @var \ss\models\blocks\record\RecordInstanceModel[] $recordInstances
 */

echo sprintf('<div class="block-%s">', $blockId);

foreach ($recordInstances as $recordInstance) {
    echo '<div class="record-card">';
    echo 123;
    echo '</div>';
}

echo '</div>';
