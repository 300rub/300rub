<?php

/**
 * Variables
 *
 * @var \ss\models\blocks\record\RecordCloneModel    $recordClone
 * @var \ss\models\blocks\record\RecordInstanceModel $recordInstance
 * @var string                                       $url
 */

use ss\application\components\helpers\DateTime;

$name = $recordInstance->get('seoModel')->get('name');

echo '<div class="record-card-container">';

echo '<div class="record-card">';

if ($recordClone->get('hasCover') === true
    && (int)$recordInstance->get('coverImageInstanceId') > 0
) {
    $imageInstance = $recordInstance->get('coverImageInstanceModel');
    if ($imageInstance !== null) {
        echo '<div class="cover-container">';

        if ($recordClone->get('hasCoverZoom') === false) {
            echo sprintf('<a href="%s">', $url);
        }

        if ($recordClone->get('hasCoverZoom') === true) {
            echo sprintf(
                '<a ' .
                'data-fancybox="record-cover-%s" ' .
                'data-type="image" ' .
                'data-caption="%s"' .
                'href="%s">',
                $imageInstance->getId(),
                $imageInstance->get('alt'),
                $imageInstance->get('viewFileModel')->getUrl()
            );
        }

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

$dateValue = DateTime::create($recordInstance->get('date'))
    ->getValue($recordClone->get('dateType'));

if ($dateValue !== '') {
    echo sprintf(
        '<div class="short-card-date">%s</div>',
        $dateValue
    );
}

if ($recordClone->get('hasDescription') === true) {
    echo sprintf(
        '<div class="short-card-description">%s</div>',
        $recordInstance->get('descriptionTextInstanceModel')->get('text')
    );
}

echo '</div>';

echo '<div class="clear"></div>';

echo '</div>';

echo '</div>';
