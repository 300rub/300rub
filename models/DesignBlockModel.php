<?php

namespace testS\models;

use testS\components\Language;
use testS\components\ValueGenerator;

/**
 * Model for working with table "designBlocks"
 *
 * @package testS\models
 */
class DesignBlockModel extends AbstractModel
{

    /**
     * Type
     */
    const TYPE = "block";

    /**
     * Min margin value
     */
    const MIN_MARGIN_VALUE = -300;

    /**
     * Min border width value
     */
    const MIN_BORDER_WIDTH_VALUE = 0;

    /**
     * Gradient directions
     */
    const GRADIENT_DIRECTION_HORIZONTAL = 0;
    const GRADIENT_DIRECTION_VERTICAL = 1;
    const GRADIENT_DIRECTION_135DEG = 2;
    const GRADIENT_DIRECTION_45DEG = 3;

    /**
     * Border styles
     */
    const BORDER_STYLE_NONE = 0;
    const BORDER_STYLE_SOLID = 1;
    const BORDER_STYLE_DOTTED = 2;
    const BORDER_STYLE_DASHED = 3;

    /**
     * List of gradient directions options
     *
     * @var array
     */
    public static $gradientDirectionList = [
        self::GRADIENT_DIRECTION_HORIZONTAL => [
            "mozLinear"    => "left",
            "webkit"       => "linear, left top, right top",
            "webkitLinear" => "left",
            "oLinear"      => "left",
            "msLinear"     => "left",
            "linear"       => "to right",
            "ie"           => 1,
        ],
        self::GRADIENT_DIRECTION_VERTICAL   => [
            "mozLinear"    => "top",
            "webkit"       => "linear, left top, left bottom",
            "webkitLinear" => "top",
            "oLinear"      => "top",
            "msLinear"     => "top",
            "linear"       => "to bottom",
            "ie"           => 0,
        ],
        self::GRADIENT_DIRECTION_135DEG     => [
            "mozLinear"    => "-45deg",
            "webkit"       => "linear, left top, right bottom",
            "webkitLinear" => "-45deg",
            "oLinear"      => "-45deg",
            "msLinear"     => "-45deg",
            "linear"       => "135deg",
            "ie"           => 1,
        ],
        self::GRADIENT_DIRECTION_45DEG      => [
            "mozLinear"    => "45deg",
            "webkit"       => "linear, left bottom, right top",
            "webkitLinear" => "45deg",
            "oLinear"      => "45deg",
            "msLinear"     => "45deg",
            "linear"       => "45deg",
            "ie"           => 1,
        ],
    ];

    /**
     * List of border styles
     *
     * @var array
     */
    public static $borderStyleList = [
        self::BORDER_STYLE_NONE   => "none",
        self::BORDER_STYLE_SOLID  => "solid",
        self::BORDER_STYLE_DOTTED => "dotted",
        self::BORDER_STYLE_DASHED => "dashed",
    ];

    /**
     * Gets labels
     *
     * @return array
     */
    public static function getLabels()
    {
        return [
            "margin"          => Language::t("design", "margin"),
            "padding"         => Language::t("design", "padding"),
            "setHover"        => Language::t("design", "setHover"),
            "useAnimation"    => Language::t("design", "useAnimation"),
            "background"      => Language::t("design", "background"),
            "backgroundColor" => Language::t("design", "backgroundColor"),
            "useGradient"     => Language::t("design", "useGradient"),
        ];
    }

    /**
     * Gets table name
     *
     * @return string
     */
    public function getTableName()
    {
        return "designBlocks";
    }

    /**
     * Gets fields info
     *
     * @return array
     */
    public function getFieldsInfo()
    {
        return [
            "marginTop"                    => [
                self::FIELD_TYPE  => self::FIELD_TYPE_INT,
                self::FIELD_VALUE => [
                    ValueGenerator::MIN => self::MIN_MARGIN_VALUE
                ],
            ],
            "marginTopHover"               => [
                self::FIELD_TYPE  => self::FIELD_TYPE_INT,
                self::FIELD_VALUE => [
                    ValueGenerator::MIN => self::MIN_MARGIN_VALUE
                ],
            ],
            "marginRight"                  => [
                self::FIELD_TYPE  => self::FIELD_TYPE_INT,
                self::FIELD_VALUE => [
                    ValueGenerator::MIN => self::MIN_MARGIN_VALUE
                ],
            ],
            "marginRightHover"             => [
                self::FIELD_TYPE  => self::FIELD_TYPE_INT,
                self::FIELD_VALUE => [
                    ValueGenerator::MIN => self::MIN_MARGIN_VALUE
                ],
            ],
            "marginBottom"                 => [
                self::FIELD_TYPE  => self::FIELD_TYPE_INT,
                self::FIELD_VALUE => [
                    ValueGenerator::MIN => self::MIN_MARGIN_VALUE
                ],
            ],
            "marginBottomHover"            => [
                self::FIELD_TYPE  => self::FIELD_TYPE_INT,
                self::FIELD_VALUE => [
                    ValueGenerator::MIN => self::MIN_MARGIN_VALUE
                ],
            ],
            "marginLeft"                   => [
                self::FIELD_TYPE  => self::FIELD_TYPE_INT,
                self::FIELD_VALUE => [
                    ValueGenerator::MIN => self::MIN_MARGIN_VALUE
                ],
            ],
            "marginLeftHover"              => [
                self::FIELD_TYPE  => self::FIELD_TYPE_INT,
                self::FIELD_VALUE => [
                    ValueGenerator::MIN => self::MIN_MARGIN_VALUE
                ],
            ],
            "hasMarginHover"               => [
                self::FIELD_TYPE => self::FIELD_TYPE_BOOL,
            ],
            "hasMarginAnimation"           => [
                self::FIELD_TYPE => self::FIELD_TYPE_BOOL,
            ],
            "paddingTop"                   => [
                self::FIELD_TYPE  => self::FIELD_TYPE_INT,
                self::FIELD_VALUE => [
                    ValueGenerator::MIN => 0
                ],
            ],
            "paddingTopHover"              => [
                self::FIELD_TYPE  => self::FIELD_TYPE_INT,
                self::FIELD_VALUE => [
                    ValueGenerator::MIN => 0
                ],
            ],
            "paddingRight"                 => [
                self::FIELD_TYPE  => self::FIELD_TYPE_INT,
                self::FIELD_VALUE => [
                    ValueGenerator::MIN => 0
                ],
            ],
            "paddingRightHover"            => [
                self::FIELD_TYPE  => self::FIELD_TYPE_INT,
                self::FIELD_VALUE => [
                    ValueGenerator::MIN => 0
                ],
            ],
            "paddingBottom"                => [
                self::FIELD_TYPE  => self::FIELD_TYPE_INT,
                self::FIELD_VALUE => [
                    ValueGenerator::MIN => 0
                ],
            ],
            "paddingBottomHover"           => [
                self::FIELD_TYPE  => self::FIELD_TYPE_INT,
                self::FIELD_VALUE => [
                    ValueGenerator::MIN => 0
                ],
            ],
            "paddingLeft"                  => [
                self::FIELD_TYPE  => self::FIELD_TYPE_INT,
                self::FIELD_VALUE => [
                    ValueGenerator::MIN => 0
                ],
            ],
            "paddingLeftHover"             => [
                self::FIELD_TYPE  => self::FIELD_TYPE_INT,
                self::FIELD_VALUE => [
                    ValueGenerator::MIN => 0
                ],
            ],
            "hasPaddingHover"              => [
                self::FIELD_TYPE => self::FIELD_TYPE_BOOL,
            ],
            "hasPaddingAnimation"          => [
                self::FIELD_TYPE => self::FIELD_TYPE_BOOL,
            ],
            "backgroundColorFrom"          => [
                self::FIELD_TYPE  => self::FIELD_TYPE_STRING,
                self::FIELD_VALUE => [
                    ValueGenerator::COLOR
                ],
            ],
            "backgroundColorFromHover"     => [
                self::FIELD_TYPE  => self::FIELD_TYPE_STRING,
                self::FIELD_VALUE => [
                    ValueGenerator::COLOR
                ],
            ],
            "backgroundColorTo"            => [
                self::FIELD_TYPE  => self::FIELD_TYPE_STRING,
                self::FIELD_VALUE => [
                    ValueGenerator::COLOR
                ],
            ],
            "backgroundColorToHover"       => [
                self::FIELD_TYPE  => self::FIELD_TYPE_STRING,
                self::FIELD_VALUE => [
                    ValueGenerator::COLOR
                ],
            ],
            "gradientDirection"            => [
                self::FIELD_TYPE  => self::FIELD_TYPE_INT,
                self::FIELD_VALUE => [
                    ValueGenerator::ARRAY_KEY => [
                        self::$gradientDirectionList,
                        self::GRADIENT_DIRECTION_HORIZONTAL
                    ]
                ],
            ],
            "gradientDirectionHover"       => [
                self::FIELD_TYPE  => self::FIELD_TYPE_INT,
                self::FIELD_VALUE => [
                    ValueGenerator::ARRAY_KEY => [
                        self::$gradientDirectionList,
                        self::GRADIENT_DIRECTION_HORIZONTAL
                    ]
                ],
            ],
            "hasBackgroundHover"           => [
                self::FIELD_TYPE => self::FIELD_TYPE_BOOL,
            ],
            "hasBackgroundAnimation"       => [
                self::FIELD_TYPE => self::FIELD_TYPE_BOOL,
            ],
            "borderTopLeftRadius"          => [
                self::FIELD_TYPE  => self::FIELD_TYPE_INT,
                self::FIELD_VALUE => [
                    ValueGenerator::MIN => 0
                ],
            ],
            "borderTopLeftRadiusHover"     => [
                self::FIELD_TYPE  => self::FIELD_TYPE_INT,
                self::FIELD_VALUE => [
                    ValueGenerator::MIN => 0
                ],
            ],
            "borderTopRightRadius"         => [
                self::FIELD_TYPE  => self::FIELD_TYPE_INT,
                self::FIELD_VALUE => [
                    ValueGenerator::MIN => 0
                ],
            ],
            "borderTopRightRadiusHover"    => [
                self::FIELD_TYPE  => self::FIELD_TYPE_INT,
                self::FIELD_VALUE => [
                    ValueGenerator::MIN => 0
                ],
            ],
            "borderBottomRightRadius"      => [
                self::FIELD_TYPE  => self::FIELD_TYPE_INT,
                self::FIELD_VALUE => [
                    ValueGenerator::MIN => 0
                ],
            ],
            "borderBottomRightRadiusHover" => [
                self::FIELD_TYPE  => self::FIELD_TYPE_INT,
                self::FIELD_VALUE => [
                    ValueGenerator::MIN => 0
                ],
            ],
            "borderBottomLeftRadius"       => [
                self::FIELD_TYPE  => self::FIELD_TYPE_INT,
                self::FIELD_VALUE => [
                    ValueGenerator::MIN => 0
                ],
            ],
            "borderBottomLeftRadiusHover"  => [
                self::FIELD_TYPE  => self::FIELD_TYPE_INT,
                self::FIELD_VALUE => [
                    ValueGenerator::MIN => 0
                ],
            ],
            "hasBorderRadiusHover"         => [
                self::FIELD_TYPE => self::FIELD_TYPE_BOOL,
            ],
            "hasBorderRadiusAnimation"     => [
                self::FIELD_TYPE => self::FIELD_TYPE_BOOL,
            ],
            "borderTopWidth"               => [
                self::FIELD_TYPE  => self::FIELD_TYPE_INT,
                self::FIELD_VALUE => [
                    ValueGenerator::MIN => 0
                ],
            ],
            "borderTopWidthHover"          => [
                self::FIELD_TYPE  => self::FIELD_TYPE_INT,
                self::FIELD_VALUE => [
                    ValueGenerator::MIN => 0
                ],
            ],
            "borderRightWidth"             => [
                self::FIELD_TYPE  => self::FIELD_TYPE_INT,
                self::FIELD_VALUE => [
                    ValueGenerator::MIN => 0
                ],
            ],
            "borderRightWidthHover"        => [
                self::FIELD_TYPE  => self::FIELD_TYPE_INT,
                self::FIELD_VALUE => [
                    ValueGenerator::MIN => 0
                ],
            ],
            "borderBottomWidth"            => [
                self::FIELD_TYPE  => self::FIELD_TYPE_INT,
                self::FIELD_VALUE => [
                    ValueGenerator::MIN => 0
                ],
            ],
            "borderBottomWidthHover"       => [
                self::FIELD_TYPE  => self::FIELD_TYPE_INT,
                self::FIELD_VALUE => [
                    ValueGenerator::MIN => 0
                ],
            ],
            "borderLeftWidth"              => [
                self::FIELD_TYPE  => self::FIELD_TYPE_INT,
                self::FIELD_VALUE => [
                    ValueGenerator::MIN => 0
                ],
            ],
            "borderLeftWidthHover"         => [
                self::FIELD_TYPE  => self::FIELD_TYPE_INT,
                self::FIELD_VALUE => [
                    ValueGenerator::MIN => 0
                ],
            ],
            "borderColor"                  => [
                self::FIELD_TYPE  => self::FIELD_TYPE_STRING,
                self::FIELD_VALUE => [
                    ValueGenerator::COLOR
                ],
            ],
            "borderColorHover"             => [
                self::FIELD_TYPE  => self::FIELD_TYPE_STRING,
                self::FIELD_VALUE => [
                    ValueGenerator::COLOR
                ],
            ],
            "borderStyle"                  => [
                self::FIELD_TYPE  => self::FIELD_TYPE_INT,
                self::FIELD_VALUE => [
                    ValueGenerator::ARRAY_KEY => [self::$borderStyleList, self::BORDER_STYLE_NONE]
                ],
            ],
            "borderStyleHover"             => [
                self::FIELD_TYPE  => self::FIELD_TYPE_INT,
                self::FIELD_VALUE => [
                    ValueGenerator::ARRAY_KEY => [self::$borderStyleList, self::BORDER_STYLE_NONE]
                ],
            ],
            "hasBorderHover"               => [
                self::FIELD_TYPE => self::FIELD_TYPE_BOOL,
            ],
            "hasBorderAnimation"           => [
                self::FIELD_TYPE => self::FIELD_TYPE_BOOL,
            ],
            "width"                        => [
                self::FIELD_TYPE  => self::FIELD_TYPE_INT,
                self::FIELD_VALUE => [
                    ValueGenerator::MIN => 0
                ],
            ],
        ];
    }

    /**
     * Gets gradient direction
     *
     * @param bool $isHover
     *
     * @return array
     */
    public function getGradientDirection($isHover = false)
    {
        if ($isHover === false) {
            $gradientDirection = $this->get("gradientDirection");
        } else {
            $gradientDirection = $this->get("gradientDirectionHover");
        }

        if (array_key_exists($gradientDirection, self::$gradientDirectionList)) {
            return self::$gradientDirectionList[$gradientDirection];
        }

        return self::$gradientDirectionList[self::GRADIENT_DIRECTION_HORIZONTAL];
    }

    /**
     * Gets border style
     *
     * @param bool $isHover
     *
     * @return string
     */
    public function getBorderStyle($isHover = false)
    {
        if ($isHover === false) {
            $borderStyle = $this->get("borderStyle");
        } else {
            $borderStyle = $this->get("borderStyleHover");
        }

        if (array_key_exists($borderStyle, self::$borderStyleList)) {
            return self::$borderStyleList[$borderStyle];
        }

        return self::$borderStyleList[self::BORDER_STYLE_NONE];
    }
}