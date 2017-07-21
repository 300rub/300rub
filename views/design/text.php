<?php

/**
 * @var \testS\models\DesignTextModel $model
 * @var string                        $id
 * @var string                        $selector
 */

$css = "";

$size = $model->get("size");
if ($size !== 0) {
    $css .= sprintf("font-size:%s;", $size);
}

$color = $model->get("color");
if ($color !== "") {
    $css .= sprintf("color:%s;", $color);
}

$isItalic = $model->get("isItalic");
if ($isItalic !== "") {
    $css .= sprintf("color:%s;", $color);
}

if ($css !== "") {
    echo sprintf("%s{%s}", $selector, $css);
}

$css = "";

$sizeHover = $model->get("sizeHover");
if ($sizeHover !== 0) {
    $css .= sprintf("font-size:%s;", $sizeHover);
}

$colorHover = $model->get("colorHover");
if ($colorHover !== "") {
    $css .= sprintf("color:%s;", $colorHover);
}

if ($css !== "") {
    echo sprintf("%s:hover{%s}", $selector, $css);
}