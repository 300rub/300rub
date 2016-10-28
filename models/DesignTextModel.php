<?php

namespace testS\models;

/**
 * Model for working with table "designTexts"
 *
 * @property int $align
 * @property int $decoration
 * @property int $transform
 * @property int $family
 *
 * @package testS\models
 */
class DesignTextModel extends AbstractDesignModel
{

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
     * Default line-height value
     */
    const DEFAULT_LINE_HEIGHT = 140;

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
            "class" => "l-font-family-myrad",
            "name"  => "MyriadPro"
        ],
        self::FAMILY_ARIAL         => [
            "class" => "l-font-family-arial",
            "name"  => "Arial, Helvetica"
        ],
        self::FAMILY_ARIAL_BLACK   => [
            "class" => "l-font-family-arial-black",
            "name"  => "Arial Black, Gadget"
        ],
        self::FAMILY_COMIC_SANS_MS => [
            "class" => "l-font-family-comic-sans",
            "name"  => "Comic Sans MS"
        ],
        self::FAMILY_COURIER_NEW   => [
            "class" => "l-font-family-courier-new",
            "name"  => "Courier New"
        ],
        self::FAMILY_GEORGIA       => [
            "class" => "l-font-family-georgia",
            "name"  => "Georgia"
        ],
        self::FAMILY_IMPACT        => [
            "class" => "l-font-family-impact",
            "name"  => "Impact, Charcoal"
        ],
        self::FAMILY_MONACO        => [
            "class" => "l-font-family-monaco",
            "name"  => "Lucida Console, Monaco"
        ],
        self::FAMILY_LUCIDA_GRANDE => [
            "class" => "l-font-family-lucida-grande",
            "name"  => "Lucida Sans Unicode"
        ],
        self::FAMILY_PALATINO      => [
            "class" => "l-font-family-palatino",
            "name"  => "Palatino"
        ],
        self::FAMILY_TAHOMA        => [
            "class" => "l-font-family-tahoma",
            "name"  => "Tahoma, Geneva"
        ],
        self::FAMILY_TIMES         => [
            "class" => "l-font-family-times",
            "name"  => "Times New Roman, Times"
        ],
        self::FAMILY_HELVETICA     => [
            "class" => "l-font-family-helvetica",
            "name"  => "Trebuchet MS, Helvetica"
        ],
        self::FAMILY_VERDANA       => [
            "class" => "l-font-family-verdana",
            "name"  => "Verdana, Geneva"
        ],
        self::FAMILY_GENEVA        => [
            "class" => "l-font-family-geneva",
            "name"  => "MS Sans Serif, Geneva"
        ],
        self::FAMILY_MS_SERIF      => [
            "class" => "l-font-family-ms-serif",
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
    protected function getFieldsInfo()
    {
        return [
            "size"          => [
                self::FIELD_TYPE  => self::FIELD_TYPE_INT,
                self::FIELD_VALUE => [
                    "min" => self::MIN_SIZE_VALUE
                ],
            ],
            "family"        => [
                self::FIELD_TYPE  => self::FIELD_TYPE_INT,
                self::FIELD_VALUE => [
                    "arrayKey" => [self::$familyList, self::FAMILY_MYRAD]
                ],
            ],
            "color"         => [
                self::FIELD_TYPE  => self::FIELD_TYPE_STRING,
                self::FIELD_VALUE => ["color"],
            ],
            "isItalic"      => [
                self::FIELD_TYPE => self::FIELD_TYPE_BOOL,
            ],
            "isBold"        => [
                self::FIELD_TYPE => self::FIELD_TYPE_BOOL,
            ],
            "align"         => [
                self::FIELD_TYPE  => self::FIELD_TYPE_INT,
                self::FIELD_VALUE => [
                    "arrayKey" => [self::$textAlignList, self::TEXT_ALIGN_LEFT]
                ],
            ],
            "decoration"    => [
                self::FIELD_TYPE  => self::FIELD_TYPE_INT,
                self::FIELD_VALUE => [
                    "arrayKey" => [self::$textDecorationList, self::TEXT_DECORATION_NONE]
                ],
            ],
            "transform"     => [
                self::FIELD_TYPE  => self::FIELD_TYPE_INT,
                self::FIELD_VALUE => [
                    "arrayKey" => [self::$textTransformList, self::TEXT_TRANSFORM_NONE]
                ],
                self::FIELD_VALUE => ["setTransform"],
            ],
            "letterSpacing" => [
                self::FIELD_TYPE  => self::FIELD_TYPE_INT,
                self::FIELD_VALUE => ["min" => self::MIN_LETTER_SPACING_VALUE],
            ],
            "lineHeight"    => [
                self::FIELD_TYPE  => self::FIELD_TYPE_INT,
                self::FIELD_VALUE => [
                    "minThen" => [self::MIN_LINE_HEIGHT_VALUE, self::DEFAULT_LINE_HEIGHT],
                ],
            ],
        ];
    }

    /**
     * Gets values for object
     *
     * @param string $name Object name
     *
     * @return array
     */
    public function getValues($name)
    {
        $this
            ->setDesignValue("fontFamily", "font-family", "family", $name)
            ->setDesignValue("spinners", "font-size", "size", $name)
            ->setDesignValue("spinners", "letter-spacing", "letterSpacing", $name)
            ->setDesignValue("spinners", "line-height", "lineHeight", $name)
            ->setDesignValue("colors", "color", "color", $name)
            ->setDesignValue("checkboxes", "font-style", "isItalic", $name)
            ->setDesignValue("checkboxes", "font-weight", "isBold", $name)
            ->setDesignValue("radios", "text-align", "align", $name)
            ->setDesignValue("radios", "text-decoration", "decoration", $name)
            ->setDesignValue("radios", "text-transform", "transform", $name);

        return $this->designValues;
    }

    /**
     * Gets CSS text-align value
     *
     * @return string
     */
    public function getTextAlign()
    {
        if (array_key_exists($this->align, self::$textAlignList)) {
            return self::$textAlignList[$this->align];
        }

        return "";
    }

    /**
     * Gets CSS text-decoration value
     *
     * @return string
     */
    public function getTextDecoration()
    {
        if (array_key_exists($this->decoration, self::$textDecorationList)) {
            return self::$textDecorationList[$this->decoration];
        }

        return self::$textDecorationList[self::TEXT_DECORATION_NONE];
    }

    /**
     * Gets CSS text-transform value
     *
     * @return string
     */
    public function getTextTransform()
    {
        if (array_key_exists($this->transform, self::$textTransformList)) {
            return self::$textTransformList[$this->transform];
        }

        return self::$textTransformList[self::TEXT_TRANSFORM_NONE];
    }

    /**
     * Gets CSS font-family value
     *
     * @return string
     */
    public function getFontFamilyClass()
    {
        if ($this->family !== self::FAMILY_MYRAD
            && array_key_exists($this->family, self::$familyList)
        ) {
            return self::$familyList[$this->family]["class"];
        }

        return "";
    }
}