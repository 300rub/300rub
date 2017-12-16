<?php

namespace testS\models\blocks\text;

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
     * Default size
     */
    const DEFAULT_SIZE = 14;

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
    const FAMILY_OPEN_SANS = 0;
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
        self::FAMILY_OPEN_SANS     => [
            "family" => '"Open Sans", sans-serif',
            "name"   => "Open Sans"
        ],
        self::FAMILY_ARIAL         => [
            "family" => 'Arial, Helvetica, sans-serif',
            "name"   => "Arial, Helvetica"
        ],
        self::FAMILY_ARIAL_BLACK   => [
            "family" => 'Arial Black", Gadget, sans-serif',
            "name"   => "Arial Black, Gadget"
        ],
        self::FAMILY_COMIC_SANS_MS => [
            "family" => 'Comic Sans MS", cursive',
            "name"   => "Comic Sans MS"
        ],
        self::FAMILY_COURIER_NEW   => [
            "family" => 'Courier New", Courier, monospace',
            "name"   => "Courier New"
        ],
        self::FAMILY_GEORGIA       => [
            "family" => 'Georgia, serif',
            "name"   => "Georgia"
        ],
        self::FAMILY_IMPACT        => [
            "family" => 'Impact, Charcoal, sans-serif',
            "name"   => "Impact, Charcoal"
        ],
        self::FAMILY_MONACO        => [
            "family" => 'Lucida Console", Monaco, monospace',
            "name"   => "Lucida Console, Monaco"
        ],
        self::FAMILY_LUCIDA_GRANDE => [
            "family" => 'Lucida Sans Unicode", "Lucida Grande", sans-serif',
            "name"   => "Lucida Sans Unicode"
        ],
        self::FAMILY_PALATINO      => [
            "family" => 'Palatino Linotype", "Book Antiqua", Palatino, serif',
            "name"   => "Palatino"
        ],
        self::FAMILY_TAHOMA        => [
            "family" => 'Tahoma, Geneva, sans-serif',
            "name"   => "Tahoma, Geneva"
        ],
        self::FAMILY_TIMES         => [
            "family" => 'Times New Roman", Times, serif',
            "name"   => "Times New Roman, Times"
        ],
        self::FAMILY_HELVETICA     => [
            "family" => 'Trebuchet MS", Helvetica, sans-serif',
            "name"   => "Trebuchet MS, Helvetica"
        ],
        self::FAMILY_VERDANA       => [
            "family" => 'Verdana, Geneva, sans-serif',
            "name"   => "Verdana, Geneva"
        ],
        self::FAMILY_GENEVA        => [
            "family" => 'MS Sans Serif", Geneva, sans-serif',
            "name"   => "MS Sans Serif, Geneva"
        ],
        self::FAMILY_MS_SERIF      => [
            "family" => '"MS Serif", "New York", serif',
            "name"   => "MS Serif, New York"
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
            "textExample" => Language::t("design", "textExample"),
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
                    ValueGenerator::ARRAY_KEY => [self::$familyList, self::FAMILY_OPEN_SANS]
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

        $values = $this->get(null, $except);
        if (array_key_exists("size", $values)
            && $values["size"] === 0
        ) {
            $values["size"] = self::DEFAULT_SIZE;
        }

        return [
            "selector"  => $selector,
            "id"        => View::generateCssId($selector, self::TYPE),
            "type"      => self::TYPE,
            "title"     => $title,
            "namespace" => $namespace,
            "labels"    => self::getLabels(),
            "values"    => $values,
        ];
    }

    /**
     * Gets family
     *
     * @return string
     */
    public function getFamily()
    {
        $family = $this->get("family");
        if (array_key_exists($family, self::$familyList)) {
            return self::$familyList[$family];
        }

        return self::$familyList[self::FAMILY_OPEN_SANS];
    }

    /**
     * Gets text align
     *
     * @return string
     */
    public function getAlign()
    {
        $align = $this->get("align");
        if (array_key_exists($align, self::$textAlignList)) {
            return self::$textAlignList[$align];
        }

        return self::$textAlignList[self::TEXT_ALIGN_LEFT];
    }

    /**
     * Gets text decoration
     *
     * @param bool $isHover
     *
     * @return string
     */
    public function getDecoration($isHover = false)
    {
        if ($isHover === true) {
            $decoration = $this->get("decorationHover");
        } else {
            $decoration = $this->get("decoration");
        }

        if (array_key_exists($decoration, self::$textDecorationList)) {
            return self::$textDecorationList[$decoration];
        }

        return self::$textDecorationList[self::TEXT_DECORATION_NONE];
    }

    /**
     * Gets text transform
     *
     * @param bool $isHover
     *
     * @return string
     */
    public function getTransform($isHover = false)
    {
        if ($isHover === true) {
            $transform = $this->get("transformHover");
        } else {
            $transform = $this->get("transform");
        }

        if (array_key_exists($transform, self::$textTransformList)) {
            return self::$textTransformList[$transform];
        }

        return self::$textTransformList[self::TEXT_TRANSFORM_NONE];
    }
}