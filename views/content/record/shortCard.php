<?php

/**
 * Variables
 *
 * @var \ss\models\blocks\record\RecordModel         $record
 * @var \ss\models\blocks\record\RecordInstanceModel $recordInstance
 * @var string                                       $urlBase
 */

$name = $recordInstance->get('seoModel')->get('name');
$url = sprintf(
    '%s/%s',
    $urlBase,
    $recordInstance->get('seoModel')->get('url')
);

echo '<div class="record-card-container">';

echo '<div class="record-card">';

if ($record->get('hasCover') === true
    && (int)$recordInstance->get('coverImageInstanceId') > 0
) {
    $imageInstance = $recordInstance->get('coverImageInstanceModel');
    if ($imageInstance !== null) {
        $imageInstance->get('thumbFileModel')->getUrl();

        echo '<div class="cover-container">';

        echo sprintf('<a href="%s">', $url);

        echo sprintf(
            '<img src="%s" alt="%s" title="%s" />',
            $imageInstance->get('thumbFileModel')->getUrl(),
            $name,
            $name
        );

        echo '</a>';

        echo '</div>';
    }
}

echo '<div class="short-card-body">';

echo sprintf(
    '<a href="%s" class="short-card-title">%s</a>',
    $url,
    $name
);

echo sprintf(
    '<div class="short-card-date">%s</div>',
    $recordInstance->get('date')->format($record->getShortCardDateFormat())
);

if ($record->get('hasDescription') === true) {
    echo sprintf(
        '<div class="short-card-description">%s</div>',
        $recordInstance->get('descriptionTextInstanceModel')->get('text')
    );
}

echo '</div>';

echo '<div class="clear"></div>';

echo '</div>';

echo '</div>';
