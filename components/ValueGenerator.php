<?php

namespace testS\components;

use testS\components\exceptions\ModelException;

/**
 * Class for generation values
 *
 * @package testS\components
 */
class ValueGenerator
{

    /**
     * Types
     */
    const MIN = "min";
    const MAX = "max";
    const MIN_THEN = "minThen";
    const COLOR = "color";
    const CLEAR_STRIP_TAGS = "clearStripTags";
    const COPY_NAME = "copyName";
    const COPY_URL = "copyUrl";
    const ARRAY_KEY = "arrayKey";
    const URL = "url";

    /**
     * Generates a value
     *
     * @param string $type
     * @param mixed  $value
     * @param mixed  $param
     *
     * @return mixed
     */
    public static function generate($type, $value, $param = null)
    {
        switch ($type) {
            case self::MIN:
                return self::_generateMin($value, $param);
            case self::MAX:
                return self::_generateMax($value, $param);
            case self::MIN_THEN:
                return self::_generateMinThen($value, $param);
            case self::COLOR:
                return self::_generateColor($value);
            case self::CLEAR_STRIP_TAGS:
                return self::_generateWithClearStripTags($value);
            case self::COPY_NAME:
                return self::_generateNameCopy($value);
            case self::COPY_URL:
                return self::_generateUrlCopy($value);
            case self::ARRAY_KEY:
                return self::_generateArrayKey($value, $param);
            case self::URL:
                return self::_generateUrl($value, $param);
            default:
                return $value;
        }
    }

    /**
     * Min value
     *
     * @param int       $value
     * @param int|array $min
     *
     * @return int
     */
    private static function _generateMin($value, $min)
    {
        if (is_array($min)) {
            $operator = "+";
            if (!empty($min[2])) {
                $operator = $min[2];
            }

            $min = self::_getValueByOperator($min[0], $min[1], $operator, -99999);
        }

        if ($value < $min) {
            $value = $min;
        }

        return $value;
    }

    /**
     * Max value
     *
     * @param int       $value
     * @param int|array $max
     *
     * @return int
     */
    private static function _generateMax($value, $max)
    {
        if (is_array($max)) {
            $operator = "-";
            if (!empty($max[2])) {
                $operator = $max[2];
            }

            $max = self::_getValueByOperator($max[0], $max[1], $operator, 99999);
        }

        if ($value > $max) {
            $value = $max;
        }

        return $value;
    }

    /**
     * Min then
     *
     * @param int   $value
     * @param array $parameters
     *
     * @return int
     */
    private static function _generateMinThen($value, array $parameters) {
        $min = $parameters[0];
        $defaultValue = $parameters[1];

        if ($value <= $min) {
           return $defaultValue;
        }

        return $value;
    }

    /**
     * Color
     *
     * @param string $value
     *
     * @return string
     */
    private static function _generateColor($value)
    {
        if (preg_match('/(.*?)(rgb|rgba)\((\d+),\s*(\d+),\s*(\d+)(?:,\s*(\d+(?:\.\d+)?))?\)/i', $value)) {
            return $value;
        }

        return "";
    }

    /**
     * Clears strip tags
     *
     * @param string $value
     *
     * @return string
     */
    private static function _generateWithClearStripTags($value)
    {
        return trim(strip_tags($value));
    }

    /**
     * Copy name
     *
     * @param string $value
     *
     * @return string
     */
    private static function _generateNameCopy($value)
    {
        return Language::t("common", "copy") . " " . $value;
    }

    /**
     * Copy URL
     *
     * @param string $value
     *
     * @return string
     */
    private static function _generateUrlCopy($value)
    {
        return $value . "-copy";
    }

    /**
     * Array key
     *
     * @param int|string $value
     * @param array $parameters
     *
     * @return int|string
     *
     * @throws ModelException
     */
    private static function _generateArrayKey($value, array $parameters)
    {
        $list = $parameters[0];
        $defaultValue = null;
        if (isset($parameters[1])) {
            $defaultValue = $parameters[1];
        }

        if (!array_key_exists($value, $list)) {
            if (array_key_exists($defaultValue, $list)) {
                return $defaultValue;
            } else {
                throw new ModelException(
                    "Unable to find value: {value} from array keys: {keys}",
                    [
                        "value" => $value,
                        "keys" => implode(", ", array_keys($list))
                    ]
                );
            }
        }

        return $value;
    }

    /**
     * URL
     *
     * @param string $value
     * @param string $name
     *
     * @return string
     */
    private static function _generateUrl($value, $name)
    {
        if ($name !== "" && $value === "") {
            $value = $name;
        }
        $value = Language::translit($value);
        $value = str_replace(["_", " "], "-", $value);
        $value = strtolower($value);
        $value = preg_replace('~[^-a-z0-9]+~u', '', $value);
        $value = trim($value, "-");

        return $value;
    }

    /**
     * Gets value by operator
     *
     * @param int $value1
     * @param int $value2
     * @param string $operator
     * @param int $defaultValue
     *
     * @return float|int
     */
    private static function _getValueByOperator($value1, $value2, $operator, $defaultValue = 0)
    {
        switch ($operator) {
            case "-":
                return $value1 - $value2;
            case "+":
                return $value1 + $value2;
            case "*":
                return $value1 * $value2;
            case "/":
                return $value1 / $value2;
            default:
                return $defaultValue;
        }
    }
}