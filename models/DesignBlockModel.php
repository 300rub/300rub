<?php

namespace testS\models;

/**
 * Model for working with table "designBlocks"
 *
 * @property string $backgroundColorFrom
 * @property string $backgroundColorTo
 * @property int    $gradientDirection
 * @property string $borderColor
 * @property int    $borderStyle
 *
 * @package testS\models
 */
class DesignBlockModel extends AbstractModel
{

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
     * Angles
     */
    const ANGLE_TOP_LEFT = "topLeft";
    const ANGLE_TOP_RIGHT = "topRight";
    const ANGLE_BOTTOM_LEFT = "bottomLeft";
    const ANGLE_BOTTOM_RIGHT = "bottomRight";

    /**
     * Gets model object
     *
     * @return DesignBlockModel
     */
    public static function model()
    {
        $className = __CLASS__;
        return new $className;
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
    protected function getFieldsInfo()
    {
        return [
            "marginTop"               => [
                self::FIELD_TYPE => self::FIELD_TYPE_INT,
                self::FIELD_SET  => ["setMin" => self::MIN_MARGIN_VALUE],
            ],
            "marginRight"             => [
                self::FIELD_TYPE => self::FIELD_TYPE_INT,
                self::FIELD_SET  => ["setMin" => self::MIN_MARGIN_VALUE],
            ],
            "marginBottom"            => [
                self::FIELD_TYPE => self::FIELD_TYPE_INT,
                self::FIELD_SET  => ["setMin" => self::MIN_MARGIN_VALUE],
            ],
            "marginLeft"              => [
                self::FIELD_TYPE => self::FIELD_TYPE_INT,
                self::FIELD_SET  => ["setMin" => self::MIN_MARGIN_VALUE],
            ],
            "paddingTop"              => [
                self::FIELD_TYPE => self::FIELD_TYPE_INT,
                self::FIELD_SET  => ["setMin" => 0],
            ],
            "paddingRight"            => [
                self::FIELD_TYPE => self::FIELD_TYPE_INT,
                self::FIELD_SET  => ["setMin" => 0],
            ],
            "paddingBottom"           => [
                self::FIELD_TYPE => self::FIELD_TYPE_INT,
                self::FIELD_SET  => ["setMin" => 0],
            ],
            "paddingLeft"             => [
                self::FIELD_TYPE => self::FIELD_TYPE_INT,
                self::FIELD_SET  => ["setMin" => 0],
            ],
            "backgroundColorFrom"     => [
                self::FIELD_TYPE => self::FIELD_TYPE_STRING,
                self::FIELD_SET  => ["parseColor"],
            ],
            "backgroundColorTo"       => [
                self::FIELD_TYPE => self::FIELD_TYPE_STRING,
                self::FIELD_SET  => ["parseColor"],
            ],
            "gradientDirection"       => [
                self::FIELD_TYPE => self::FIELD_TYPE_INT,
                self::FIELD_SET  => ["setGradientDirection"],
            ],
            "borderTopWidth"          => [
                self::FIELD_TYPE => self::FIELD_TYPE_INT,
                self::FIELD_SET  => ["setMin" => 0],
            ],
            "borderRightWidth"        => [
                self::FIELD_TYPE => self::FIELD_TYPE_INT,
                self::FIELD_SET  => ["setMin" => 0],
            ],
            "borderBottomWidth"       => [
                self::FIELD_TYPE => self::FIELD_TYPE_INT,
                self::FIELD_SET  => ["setMin" => 0],
            ],
            "borderLeftWidth"         => [
                self::FIELD_TYPE => self::FIELD_TYPE_INT,
                self::FIELD_SET  => ["setMin" => 0],
            ],
            "borderTopLeftRadius"     => [
                self::FIELD_TYPE => self::FIELD_TYPE_INT,
                self::FIELD_SET  => ["setMin" => 0],
            ],
            "borderTopRightRadius"    => [
                self::FIELD_TYPE => self::FIELD_TYPE_INT,
                self::FIELD_SET  => ["setMin" => 0],
            ],
            "borderBottomRightRadius" => [
                self::FIELD_TYPE => self::FIELD_TYPE_INT,
                self::FIELD_SET  => ["setMin" => 0],
            ],
            "borderBottomLeftRadius"  => [
                self::FIELD_TYPE => self::FIELD_TYPE_INT,
                self::FIELD_SET  => ["setMin" => 0],
            ],
            "borderColor"             => [
                self::FIELD_TYPE => self::FIELD_TYPE_STRING,
                self::FIELD_SET  => ["parseColor"],
            ],
            "borderStyle"             => [
                self::FIELD_TYPE => self::FIELD_TYPE_INT,
                self::FIELD_SET  => ["setBorderStyle"],
            ],
        ];
    }

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
            "label"        => "→"
        ],
        self::GRADIENT_DIRECTION_VERTICAL   => [
            "mozLinear"    => "top",
            "webkit"       => "linear, left top, left bottom",
            "webkitLinear" => "top",
            "oLinear"      => "top",
            "msLinear"     => "top",
            "linear"       => "to bottom",
            "ie"           => 0,
            "label"        => "↓"
        ],
        self::GRADIENT_DIRECTION_135DEG     => [
            "mozLinear"    => "-45deg",
            "webkit"       => "linear, left top, right bottom",
            "webkitLinear" => "-45deg",
            "oLinear"      => "-45deg",
            "msLinear"     => "-45deg",
            "linear"       => "135deg",
            "ie"           => 1,
            "label"        => "↘"
        ],
        self::GRADIENT_DIRECTION_45DEG      => [
            "mozLinear"    => "45deg",
            "webkit"       => "linear, left bottom, right top",
            "webkitLinear" => "45deg",
            "oLinear"      => "45deg",
            "msLinear"     => "45deg",
            "linear"       => "45deg",
            "ie"           => 1,
            "label"        => "↗"
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
     * Sets gradient direction
     *
     * @param int $value
     *
     * @return int
     */
    protected function setGradientDirection($value)
    {
        if (!array_key_exists($value, self::$gradientDirectionList)) {
            $value = self::GRADIENT_DIRECTION_HORIZONTAL;
        }

        return $value;
    }

    /**
     * Sets border style
     *
     * @param int $value
     *
     * @return int
     */
    protected function setBorderStyle($value)
    {
        if (!array_key_exists($value, self::$borderStyleList)) {
            $value = self::BORDER_STYLE_NONE;
        }

        return $value;
    }

    /**
     * Values availability
     *
     * @var array
     */
    private $_valuesAvailability = [
        "marginTop"               => true,
        "marginRight"             => true,
        "marginBottom"            => true,
        "marginLeft"              => true,
        "paddingTop"              => true,
        "paddingRight"            => true,
        "paddingBottom"           => true,
        "paddingLeft"             => true,
        "backgroundColorFrom"     => true,
        "backgroundColorTo"       => true,
        "gradientDirection"       => true,
        "borderTopWidth"          => true,
        "borderRightWidth"        => true,
        "borderBottomWidth"       => true,
        "borderLeftWidth"         => true,
        "borderTopLeftRadius"     => true,
        "borderTopRightRadius"    => true,
        "borderBottomRightRadius" => true,
        "borderBottomLeftRadius"  => true,
        "borderColor"             => true,
        "borderStyle"             => true,
    ];

    /**
     * Excepts values
     *
     * @param array $values
     *
     * @return DesignBlockModel
     */
    public function exceptValues(array $values)
    {
        foreach ($values as $value) {
            if (array_key_exists($value, $this->_valuesAvailability)) {
                $this->_valuesAvailability[$value] = false;
            }
        }

        return $this;
    }

    /**
     * Gets margin values
     *
     * @param string $name
     * @param array  $fields
     *
     * @return array
     */
    private function _getAngleValues($name, array $fields)
    {
        $values = [];

        $topLeft = $fields[0];
        $topRight = $fields[1];
        $bottomLeft = $fields[2];
        $bottomRight = $fields[3];

        if ($this->_valuesAvailability[$topLeft] === true) {
            $values[self::ANGLE_TOP_LEFT] = [
                "name"  => sprintf($name, $topLeft),
                "value" => $this->$topLeft
            ];
        }

        if ($this->_valuesAvailability[$topRight] === true) {
            $values[self::ANGLE_TOP_RIGHT] = [
                "name"  => sprintf($name, $topRight),
                "value" => $this->$topRight
            ];
        }

        if ($this->_valuesAvailability[$bottomLeft] === true) {
            $values[self::ANGLE_BOTTOM_RIGHT] = [
                "name"  => sprintf($name, $bottomLeft),
                "value" => $this->$bottomLeft
            ];
        }

        if ($this->_valuesAvailability[$bottomRight] === true) {
            $values[self::ANGLE_BOTTOM_LEFT] = [
                "name"  => sprintf($name, $bottomRight),
                "value" => $this->$bottomRight
            ];
        }

        return $values;
    }

    /**
     * Gets values for object
     *
     * @param string $name Name of object
     *
     * @return array
     */
    public function getValues($name)
    {
        return [
            "angles"          => [
                [
                    "type"   => "margin",
                    "values" => $this->_getAngleValues(
                        $name,
                        [
                            "marginLeft",
                            "marginRight",
                            "marginBottom",
                            "marginLeft"
                        ]
                    )
                ],
                [
                    "type"   => "padding",
                    "values" => $this->_getAngleValues(
                        $name,
                        [
                            "paddingTop",
                            "paddingRight",
                            "paddingBottom",
                            "paddingLeft"
                        ]
                    )
                ],
                [
                    "type"   => "border-width",
                    "values" => $this->_getAngleValues(
                        $name,
                        [
                            "borderTopWidth",
                            "borderRightWidth",
                            "borderBottomWidth",
                            "borderLeftWidth"
                        ]
                    )
                ],
                [
                    "type"   => "border-radius",
                    "values" => $this->_getAngleValues(
                        $name,
                        [
                            "borderTopLeftRadius",
                            "borderTopRightRadius",
                            "borderBottomRightRadius",
                            "borderBottomLeftRadius"
                        ]
                    )
                ],
            ],
            "backgroundColor" => [
                "fromName"      => sprintf($name, "backgroundColorFrom"),
                "fromValue"     => $this->backgroundColorFrom,
                "toName"        => sprintf($name, "backgroundColorTo"),
                "toValue"       => $this->backgroundColorTo,
                "gradientName"  => sprintf($name, "gradientDirection"),
                "gradientValue" => $this->gradientDirection
            ],
            "colors"          => [
                [
                    "type"  => "border-color",
                    "name"  => sprintf($name, "borderColor"),
                    "value" => $this->borderColor
                ]
            ],
            "radios"          => [
                [
                    "type"  => "border-style",
                    "name"  => sprintf($name, "borderStyle"),
                    "value" => $this->borderStyle
                ]
            ]
        ];
    }

    /**
     * Gets gradient direction
     *
     * @return array
     */
    public function getGradientDirection()
    {
        if (array_key_exists($this->gradientDirection, self::$gradientDirectionList)) {
            return self::$gradientDirectionList[$this->gradientDirection];
        }

        return self::$gradientDirectionList[self::GRADIENT_DIRECTION_HORIZONTAL];
    }

    /**
     * Gets border style
     *
     * @return string
     */
    public function getBorderStyle()
    {
        if (array_key_exists($this->borderStyle, self::$borderStyleList)) {
            return self::$borderStyleList[$this->borderStyle];
        }

        return self::$borderStyleList[self::BORDER_STYLE_NONE];
    }
}