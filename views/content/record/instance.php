<?php

/**
 * Variables
 *
 * @var int                                          $blockId
 * @var \ss\models\blocks\record\RecordInstanceModel $recordInstance
 */

echo sprintf('<div class="block-%s">', $blockId);

echo sprintf(
    '<h1>%s</h1>',
    $recordInstance->get('seoModel')->get('name')
);

echo sprintf(
    '<div>%s</div>',
    $recordInstance->get('textTextInstanceModel')->get('text')
);

echo '</div>';
