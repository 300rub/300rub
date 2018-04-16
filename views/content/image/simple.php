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

    $link = $image->get('link');
    echo sprintf('<div class="image-container%s">', $align);
    if ($link !== '') {
        echo sprintf('<a href="%s">', $link);
    }
    echo sprintf(
        '<img src="%s" alt="%s" title="%s" class="image" />',
        $image->get('viewFileModel')->getUrl(),
        $image->get('alt'),
        $image->get('alt')
    );
    if ($link !== '') {
        echo '</a>';
    }

    echo sprintf(
        '<div class="description%s%s">%s</div>',
        $descriptionHidden,
        $align,
        $image->get('alt')
    );

    echo '</div>';
}

echo '</div>';
