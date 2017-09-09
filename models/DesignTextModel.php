<?php

namespace testS\models;

use testS\components\Language;
use testS\components\ValueGenerator;
use testS\components\View;

/**
 * Model for working with table "designTexts"
 *
 * @package testS\models
 */
class DesignTextModel extends AbstractModel
{

    /**
     * Type
     */
    const TYPE = "text";

    /**
     * Min size value
     */
    const MIN_SIZE_VALUE = 4;

    /**
     * Min letter spacing value
     */
    const MIN_LETTER_SPACING_VALUE = -10;

    /**
     * Min line height value
     */
    const MIN_LINE_HEIGHT_VALUE = 10;

    /**
     * Font family types
     */
    const FAMILY_MYRAD = 0;
    const FAMILY_ARIAL = 1;
    const FAMILY_ARIAL_BLACK = 2;
    const FAMILY_COMIC_SANS_MS = 3;
    const FAMILY_COURIER_NEW = 4;
    const FAMILY_GEORGIA = 5;
    const FAMILY_IMPACT = 6;
    const FAMILY_MONACO = 7;
    const FAMILY_LUCIDA_GRANDE = 8;
    const FAMILY_PALATINO = 9;
    const FAMILY_TAHOMA = 10;
    const FAMILY_TIMES = 11;
    const FAMILY_HELVETICA = 12;
    const FAMILY_VERDANA = 13;
    const FAMILY_GENEVA = 14;
    const FAMILY_MS_SERIF = 15;

    /**
     * Text align types
     */
    const TEXT_ALIGN_LEFT = 0;
    const TEXT_ALIGN_CENTER = 1;
    const TEXT_ALIGN_RIGHT = 2;
    const TEXT_ALIGN_JUSTIFY = 3;

    /**
     * Text decoration types
     */
    const TEXT_DECORATION_NONE = 0;
    const TEXT_DECORATION_UNDERLINE = 1;
    const TEXT_DECORATION_LINE_THROUGH = 2;
    const TEXT_DECORATION_OVERLINE = 3;

    /**
     * Text transform types
     */
    const TEXT_TRANSFORM_NONE = 0;
    const TEXT_TRANSFORM_UPPERCASE = 1;
    const TEXT_TRANSFORM_LOWERCASE = 2;
    const TEXT_TRANSFORM_CAPITALIZE = 3;

    /**
     * List of font family types
     *
     * @var array
     */
    public static $familyList = [
        self::FAMILY_MYRAD         => [
            "class" => "font-family-myrad",
            "name"  => "MyriadPro"
        ],
        self::FAMILY_ARIAL         => [
            "class" => "font-family-arial",
            "name"  => "Arial, Helvetica"
        ],
        self::FAMILY_ARIAL_BLACK   => [
            "class" => "font-family-arial-black",
            "name"  => "Arial Black, Gadget"
        ],
        self::FAMILY_COMIC_SANS_MS => [
            "class" => "font-family-comic-sans",
            "name"  => "Comic Sans MS"
        ],
        self::FAMILY_COURIER_NEW   => [
            "class" => "font-family-courier-new",
            "name"  => "Courier New"
        ],
        self::FAMILY_GEORGIA       => [
            "class" => "font-family-georgia",
            "name"  => "Georgia"
        ],
        self::FAMILY_IMPACT        => [
            "class" => "font-family-impact",
            "name"  => "Impact, Charcoal"
        ],
        self::FAMILY_MONACO        => [
            "class" => "font-family-monaco",
            "name"  => "Lucida Console, Monaco"
        ],
        self::FAMILY_LUCIDA_GRANDE => [
            "class" => "font-family-lucida-grande",
            "name"  => "Lucida Sans Unicode"
        ],
        self::FAMILY_PALATINO      => [
            "class" => "font-family-palatino",
            "name"  => "Palatino"
        ],
        self::FAMILY_TAHOMA        => [
            "class" => "font-family-tahoma",
            "name"  => "Tahoma, Geneva"
        ],
        self::FAMILY_TIMES         => [
            "class" => "font-family-times",
            "name"  => "Times New Roman, Times"
        ],
        self::FAMILY_HELVETICA     => [
            "class" => "font-family-helvetica",
            "name"  => "Trebuchet MS, Helvetica"
        ],
        self::FAMILY_VERDANA       => [
            "class" => "font-family-verdana",
            "name"  => "Verdana, Geneva"
        ],
        self::FAMILY_GENEVA        => [
            "class" => "font-family-geneva",
            "name"  => "MS Sans Serif, Geneva"
        ],
        self::FAMILY_MS_SERIF      => [
            "class" => "font-family-ms-serif",
            "name"  => "MS Serif, New York"
        ]
    ];

    /**
     * List of text align types
     *
     * @var array
     */
    public static $textAlignList = [
        self::TEXT_ALIGN_LEFT    => "left",
        self::TEXT_ALIGN_CENTER  => "center",
        self::TEXT_ALIGN_RIGHT   => "right",
        self::TEXT_ALIGN_JUSTIFY => "justify",
    ];

    /**
     * List of text decoration types
     *
     * @var array
     */
    public static $textDecorationList = [
        self::TEXT_DECORATION_NONE         => "none",
        self::TEXT_DECORATION_UNDERLINE    => "underline",
        self::TEXT_DECORATION_LINE_THROUGH => "line-through",
        self::TEXT_DECORATION_OVERLINE     => "overline",
    ];

    /**
     * List of text transform types
     *
     * @var array
     */
    public static $textTransformList = [
        self::TEXT_TRANSFORM_NONE       => "none",
        self::TEXT_TRANSFORM_UPPERCASE  => "uppercase",
        self::TEXT_TRANSFORM_LOWERCASE  => "lowercase",
        self::TEXT_TRANSFORM_CAPITALIZE => "capitalize",
    ];

    /**
     * Gets labels
     *
     * @return array
     */
    public static function getLabels()
    {
        return [
            "mouseHoverEffect" => Language::t("design", "mouseHoverEffect"),
        ];
    }

    /**
     * Gets table name
     *
     * @return string
     */
    public function getTableName()
    {
        return "designTexts";
    }

    /**
     * Gets fields info
     *
     * @return array
     */
    public function getFieldsInfo()
    {
        return [
            "size"                => [
                self::FIELD_TYPE  => self::FIELD_TYPE_INT,
                self::FIELD_VALUE => [
                    ValueGenerator::MIN_THEN => [self::MIN_SIZE_VALUE, 0],
                ],
            ],
            "sizeHover"           => [
                self::FIELD_TYPE  => self::FIELD_TYPE_INT,
                self::FIELD_VALUE => [
                    ValueGenerator::MIN_THEN => [self::MIN_SIZE_VALUE, 0],
                ],
            ],
            "family"              => [
                self::FIELD_TYPE  => self::FIELD_TYPE_INT,
                self::FIELD_VALUE => [
                    ValueGenerator::ARRAY_KEY => [self::$familyList, self::FAMILY_MYRAD]
                ],
            ],
            ValueGenerator::COLOR => [
                self::FIELD_TYPE  => self::FIELD_TYPE_STRING,
                self::FIELD_VALUE => [
                    ValueGenerator::COLOR
                ],
            ],
            "colorHover"          => [
                self::FIELD_TYPE  => self::FIELD_TYPE_STRING,
                self::FIELD_VALUE => [
                    ValueGenerator::COLOR
                ],
            ],
            "isItalic"            => [
                self::FIELD_TYPE => self::FIELD_TYPE_BOOL,
            ],
            "isItalicHover"       => [
                self::FIELD_TYPE => self::FIELD_TYPE_BOOL,
            ],
            "isBold"              => [
                self::FIELD_TYPE => self::FIELD_TYPE_BOOL,
            ],
            "isBoldHover"         => [
                self::FIELD_TYPE => self::FIELD_TYPE_BOOL,
            ],
            "align"               => [
                self::FIELD_TYPE  => self::FIELD_TYPE_INT,
                self::FIELD_VALUE => [
                    ValueGenerator::ARRAY_KEY => [self::$textAlignList, self::TEXT_ALIGN_LEFT]
                ],
            ],
            "decoration"          => [
                self::FIELD_TYPE  => self::FIELD_TYPE_INT,
                self::FIELD_VALUE => [
                    ValueGenerator::ARRAY_KEY => [self::$textDecorationList, self::TEXT_DECORATION_NONE]
                ],
            ],
            "decorationHover"     => [
                self::FIELD_TYPE  => self::FIELD_TYPE_INT,
                self::FIELD_VALUE => [
                    ValueGenerator::ARRAY_KEY => [self::$textDecorationList, self::TEXT_DECORATION_NONE]
                ],
            ],
            "transform"           => [
                self::FIELD_TYPE  => self::FIELD_TYPE_INT,
                self::FIELD_VALUE => [
                    ValueGenerator::ARRAY_KEY => [self::$textTransformList, self::TEXT_TRANSFORM_NONE]
                ],
            ],
            "transformHover"      => [
                self::FIELD_TYPE  => self::FIELD_TYPE_INT,
                self::FIELD_VALUE => [
                    ValueGenerator::ARRAY_KEY => [self::$textTransformList, self::TEXT_TRANSFORM_NONE]
                ],
            ],
            "letterSpacing"       => [
                self::FIELD_TYPE  => self::FIELD_TYPE_INT,
                self::FIELD_VALUE => [
                    ValueGenerator::MIN => self::MIN_LETTER_SPACING_VALUE
                ],
            ],
            "letterSpacingHover"  => [
                self::FIELD_TYPE  => self::FIELD_TYPE_INT,
                self::FIELD_VALUE => [
                    ValueGenerator::MIN => self::MIN_LETTER_SPACING_VALUE
                ],
            ],
            "lineHeight"          => [
                self::FIELD_TYPE  => self::FIELD_TYPE_INT,
                self::FIELD_VALUE => [
                    ValueGenerator::MIN_THEN => [self::MIN_LINE_HEIGHT_VALUE, 0],
                ],
            ],
            "lineHeightHover"     => [
                self::FIELD_TYPE  => self::FIELD_TYPE_INT,
                self::FIELD_VALUE => [
                    ValueGenerator::MIN_THEN => [self::MIN_LINE_HEIGHT_VALUE, 0],
                ],
            ],
            "hasHover"            => [
                self::FIELD_TYPE => self::FIELD_TYPE_BOOL,
            ],
        ];
    }

    /**
     * Gets design
     *
     * @param string $selector
     * @param string $namespace
     * @param array  $except
     * @param string $title
     *
     * @return array
     */
    public function getDesign($selector, $namespace = null, array $except = null, $title = null)
    {
        if ($title === null) {
            $title = Language::t("design", "textDesign");
        }

        if ($namespace === null) {
            $namespace = "designTextModel";
        }

        if ($except === null) {
            $except = ["id"];
        }

        return [
            "selector"  => $selector,
            "id"        => View::generateCssId($selector, self::TYPE),
            "type"      => self::TYPE,
            "title"     => $title,
            "namespace" => $namespace,
            "labels"    => self::getLabels(),
            "values"    => $this->get(null, $except),
        ];
    }
}