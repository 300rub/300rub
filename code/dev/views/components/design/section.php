<?php

/**
 * Variables
 *
 * @var \ss\models\sections\SectionModel $model
 * @var string                           $selector
 */

$padding = $model->get('padding');
$padding = $padding + 50;
if ($padding > 0) {
    echo sprintf(
        '%s{padding-left:%spx;}',
        $selector,
        $padding
    );
}
