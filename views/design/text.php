<?php

/**
 * Variables
 *
 * @var DesignTextModel $model
 * @var string          $id
 * @var string          $selector
 *
 * phpcs:disable Generic.Files.InlineHTML
 */

use ss\models\blocks\text\DesignTextModel;

$css = '';

$family = $model->get('family');
if ($family !== DesignTextModel::FAMILY_OPEN_SANS) {
    $css .= sprintf('font-family:%s;', $model->getFamily());
}

$size = $model->get('size');
if ($size !== 0 && $size !== DesignTextModel::DEFAULT_SIZE) {
    $css .= sprintf('font-size:%s;', $size);
}

$color = $model->get('color');
if ($color !== '') {
    $css .= sprintf('color:%s;', $color);
}

$isItalic = $model->get('isItalic');
if ($isItalic === true) {
    $css .= 'font-style:italic;';
}

$isBold = $model->get('isBold');
if ($isBold === true) {
    $css .= 'font-weight:bold;';
}

$align = $model->get('align');
if ($align !== DesignTextModel::TEXT_ALIGN_LEFT) {
    $css .= sprintf('text-align:%s;', $model->getAlign());
}

$decoration = $model->get('decoration');
if ($decoration !== DesignTextModel::TEXT_DECORATION_NONE) {
    $css .= sprintf('text-decoration:%s;', $model->getDecoration(false));
}

$transform = $model->get('transform');
if ($transform !== DesignTextModel::TEXT_TRANSFORM_NONE) {
    $css .= sprintf('text-transform:%s;', $model->getTransform(false));
}

$letterSpacing = $model->get('letterSpacing');
if ($letterSpacing !== 0) {
    $css .= sprintf('letter-spacing:%spx;', $letterSpacing);
}

$lineHeight = $model->get('lineHeight');
if ($lineHeight !== 0) {
    $finalLineHeight = (1.4 + $lineHeight / 100);
    $css .= sprintf('line-height:%s;', $finalLineHeight);
}

if ($css !== '') {
    echo sprintf('%s{%s}', $selector, $css);
}

if ($model->get('hasHover') === true) {
    $css = '';

    $sizeHover = $model->get('sizeHover');
    if ($sizeHover !== $size) {
        $css .= sprintf('font-size:%s;', $sizeHover);
    }

    $colorHover = $model->get('colorHover');
    if ($colorHover !== ''
        && $colorHover !== $color
    ) {
        $css .= sprintf('color:%s;', $colorHover);
    }

    $isItalicHover = $model->get('isItalicHover');
    if ($isItalicHover !== $isItalic) {
        if ($isItalicHover === true) {
            $css .= 'font-style:italic;';
        } else {
            $css .= 'font-style:normal;';
        }
    }

    $isBoldHover = $model->get('isBoldHover');
    if ($isBoldHover !== $isBold) {
        if ($isBoldHover === true) {
            $css .= 'font-weight:bold;';
        } else {
            $css .= 'font-weight:normal;';
        }
    }

    $decorationHover = $model->get('decorationHover');
    if ($decoration !== $decorationHover) {
        $css .= sprintf('text-decoration:%s;', $model->getDecoration(true));
    }

    $transformHover = $model->get('transformHover');
    if ($decoration !== $transformHover) {
        $css .= sprintf('text-transform:%s;', $model->getTransform(true));
    }

    $letterSpacingHover = $model->get('letterSpacingHover');
    if ($letterSpacingHover !== $letterSpacingHover) {
        $css .= sprintf('letter-spacing:%spx;', $letterSpacingHover);
    }

    $lineHeightHover = $model->get('lineHeightHover');
    if ($lineHeightHover !== $lineHeight) {
        $finalLineHeight = (1.4 + $lineHeightHover / 100);
        $css .= sprintf('line-height:%s;', $finalLineHeight);
    }

    if ($css !== '') {
        echo sprintf('%s:hover{%s}', $selector, $css);
    }
}
