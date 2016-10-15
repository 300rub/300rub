<?php

namespace testS\models;

/**
 * Model for working with table "designBlocks"
 *
 * @property int $gradientDirection
 * @property int $borderStyle
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
     * Values
     *
     * @var array
     */
    private $_values = [];

    /**
     * Values availability
     *
     * @var array
     */
    private $_valuesAvailability = [];

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
     * Executes after finding
     */
    protected function afterFind()
    {
        $this->_setDefaultValuesAvailability();
    }

    /**
     * Sets default values availability
     *
     * @return DesignBlockModel
     */
    private function _setDefaultValuesAvailability()
    {
        foreach (array_keys($this->getFieldsInfo()) as $field) {
            $this->_valuesAvailability[$field] = true;
        }

        return $this;
    }

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
     * Sets value
     *
     * @param string $group
     * @param string $type
     * @param string $field
     * @param string $name
     *
     * @return DesignBlockModel
     */
    private function _setValue($group, $type, $field, $name)
    {
        if (!array_key_exists($field, $this->_valuesAvailability)) {
            return $this;
        }

        if (!property_exists($this, $field)) {
            return $this;
        }

        if ($this->_valuesAvailability[$field] === false) {
            return $this;
        }

        if (!array_key_exists($group, $this->_values)) {
            $this->_values[$group] = [];
        }

        if (!array_key_exists($type, $this->_values[$group])) {
            $this->_values[$group][$type] = [];
        }

        $this->_values[$group][$type][$field] = [
            "name"  => sprintf($name, $field),
            "value" => $this->$field
        ];

        return $this;
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
        $this
            ->_setValue("angles", "margin", "marginTop", $name)
            ->_setValue("angles", "margin", "marginRight", $name)
            ->_setValue("angles", "margin", "marginBottom", $name)
            ->_setValue("angles", "margin", "marginLeft", $name)
            ->_setValue("angles", "padding", "paddingTop", $name)
            ->_setValue("angles", "padding", "paddingRight", $name)
            ->_setValue("angles", "padding", "paddingBottom", $name)
            ->_setValue("angles", "padding", "paddingLeft", $name)
            ->_setValue("angles", "border-width", "borderTopWidth", $name)
            ->_setValue("angles", "border-width", "borderRightWidth", $name)
            ->_setValue("angles", "border-width", "borderBottomWidth", $name)
            ->_setValue("angles", "border-width", "borderLeftWidth", $name)
            ->_setValue("angles", "border-radius", "borderTopLeftRadius", $name)
            ->_setValue("angles", "border-radius", "borderTopRightRadius", $name)
            ->_setValue("angles", "border-radius", "borderBottomRightRadius", $name)
            ->_setValue("angles", "border-radius", "borderBottomLeftRadius", $name)
            ->_setValue("background", "background", "backgroundColorFrom", $name)
            ->_setValue("background", "background", "backgroundColorTo", $name)
            ->_setValue("background", "background", "gradientDirection", $name)
            ->_setValue("colors", "border-color", "borderColor", $name)
            ->_setValue("radios", "border-style", "borderStyle", $name);

        return $this->_values;
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