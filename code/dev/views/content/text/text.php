<?php

use ss\models\blocks\text\TextModel;

/**
 * Variables
 *
 * @var int    $blockId
 * @var string $text
 * @var int    $type
 */

switch ($type) {
    case TextModel::TYPE_H1:
        $tag = 'h1';
        break;
    case TextModel::TYPE_H2:
        $tag = 'h2';
        break;
    case TextModel::TYPE_H3:
        $tag = 'h3';
        break;
    default:
        $tag = 'div';
        break;
}

echo sprintf(
    '<%s class="block-%s">%s</%s>',
    $tag,
    $blockId,
    $text,
    $tag
);
