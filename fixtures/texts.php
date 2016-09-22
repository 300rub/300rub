<?php

use components\Language;
use models\TextModel;

return [
    1 => [
        "name"     => "Default. Without styles",
        "language" => Language::LANGUAGE_EN_ID,
        "text"     => "Default. Without styles. The quick brown fox jumps over the lazy dog 0123456789.",
    ],
    2 => [
        "name"     => "First level title. Without styles",
        "language" => Language::LANGUAGE_EN_ID,
        "type"     => TextModel::TYPE_H1,
        "text"     => "First level title. Without styles. The quick brown fox jumps over the lazy dog 0123456789.",
    ],
    3 => [
        "name"     => "Second level title. Without styles",
        "language" => Language::LANGUAGE_EN_ID,
        "type"     => TextModel::TYPE_H2,
        "text"     => "Second level title. Without styles. The quick brown fox jumps over the lazy dog 0123456789.",
    ],
    4 => [
        "name"     => "Third level title. Without styles",
        "language" => Language::LANGUAGE_EN_ID,
        "type"     => TextModel::TYPE_H3,
        "text"     => "Third level title. Without styles. The quick brown fox jumps over the lazy dog 0123456789.",
    ],
    5 => [
        "name"     => "Address. Without styles",
        "language" => Language::LANGUAGE_EN_ID,
        "type"     => TextModel::TYPE_ADRESS,
        "text"     => "Address. Without styles. The quick brown fox jumps over the lazy dog 0123456789.",
    ],
    6 => [
        "name"     => "Important text. Without styles",
        "language" => Language::LANGUAGE_EN_ID,
        "type"     => TextModel::TYPE_MARK,
        "text"     => "Important text. Without styles. The quick brown fox jumps over the lazy dog 0123456789.",
    ],
    7 => [
        "name"             => "Default. With design",
        "language"         => Language::LANGUAGE_EN_ID,
        "text"             => "Default. With design. The quick brown fox jumps over the lazy dog 0123456789.",
        "designTextModel"  => [
            "size"          => 25,
            "family"        => 3,
            "color"         => "#777777",
            "isItalic"      => 1,
            "isBold"        => 1,
            "align"         => 1,
            "decoration"    => 1,
            "transform"     => 1,
            "letterSpacing" => 0,
            "lineHeight"    => 0,
        ],
        "designBlockModel" => [
            "marginTop"               => 10,
            "marginRight"             => 20,
            "marginBottom"            => 30,
            "marginLeft"              => 40,
            "paddingTop"              => 40,
            "paddingRight"            => 30,
            "paddingBottom"           => 20,
            "paddingLeft"             => 10,
            "backgroundColorFrom"     => "rgba(200,200,200,0.7)",
            "backgroundColorTo"       => "rgba(240,240,240,0.7)",
            "gradientDirection"       => 0,
            "borderTopLeftRadius"     => 10,
            "borderTopRightRadius"    => 20,
            "borderBottomRightRadius" => 30,
            "borderBottomLeftRadius"  => 40,
            "borderTopWidth"          => 2,
            "borderRightWidth"        => 2,
            "borderBottomWidth"       => 2,
            "borderLeftWidth"         => 2,
            "borderStyle"             => 1,
            "borderColor"             => "rgb(65,65,65)",
        ],
    ],
    8 => [
        "name"     => "Default. With editor",
        "language" => Language::LANGUAGE_EN_ID,
        "isEditor" => true,
        "text"     => "<p>Default. With editor. <strong>The quick</strong> <em>brown</em> fox jumps over the lazy dog 0123456789.</p>",
    ],
];