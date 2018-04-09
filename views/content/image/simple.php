<?php

/**
 * Variables
 *
 * @var int                                            $blockId
 * @var \ss\models\blocks\image\ImageInstanceModel[]   $images
 * @var \ss\models\blocks\image\DesignImageSimpleModel $design
 */

echo sprintf('<div class="block-%s">', $blockId);

foreach ($images as $image) {
    $descriptionHidden = '';
    if ($design->get('useDescription') === false) {
        $descriptionHidden = ' hidden';
    }

    $align = $design->getAlignmentValue();
    if ($align !== '') {
        $align = ' ' . $align;
    }

    echo sprintf('<div class="image-container%s">', $align);
    echo sprintf(
        '<img src="%s" alt="%s" title="%s" class="image" />',
        $image->get('viewFileModel')->getUrl(),
        $image->get('alt'),
        $image->get('alt')
    );

    echo sprintf(
        '<div class="description%s%s">%s</div>',
        $image->get('alt'),
        $descriptionHidden,
        $align
    );

    echo '</div>';
}

echo '</div>';
