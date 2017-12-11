<?php

/**
 * PHP version 7
 *
 * @category Applications
 * @package  Components
 * @author   Mikhail Vasilev <donvasilion@gmail.com>
 * @license  http://opensource.org/licenses/gpl-license.php GNU Public License
 * @link     -
 */

namespace testS\applications\components;

use testS\applications\App;
use testS\applications\exceptions\ContentException;

/**
 * Class for generation values
 *
 * @category Applications
 * @package  Components
 * @author   Mikhail Vasilev <donvasilion@gmail.com>
 * @license  http://opensource.org/licenses/gpl-license.php GNU Public License
 * @link     -
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
    const STRING = "string";
    const INT = "int";
    const FLOAT = "float";
    const BOOL = "bool";
    const BOOL_INT = "boolInt";
    const DATETIME = "datetime";
    const DATETIME_AS_STRING = "datetimeAsString";
    const ORDERED_ARRAY = "orderedArray";

    /**
     * Generates a value
     *
     * @param string $type  Generator type
     * @param mixed  $value Value
     * @param mixed  $param Additional parameter
     *
     * @return mixed
     */
    public function generate($type, $value, $param = null)
    {
        switch ($type) {
        case self::MIN:
            return $this->_generateMin($value, $param);
        case self::MAX:
            return $this->_generateMax($value, $param);
        case self::MIN_THEN:
            return $this->_generateMinThen($value, $param);
        case self::COLOR:
            return $this->_generateColor($value);
        case self::CLEAR_STRIP_TAGS:
            return $this->_generateWithClearStripTags($value);
        case self::COPY_NAME:
            return $this->_generateNameCopy($value);
        case self::COPY_URL:
            return $this->_generateUrlCopy($value);
        case self::ARRAY_KEY:
            return $this->_generateArrayKey($value, $param);
        case self::URL:
            return $this->_generateUrl($value, $param);
        case self::STRING:
            return $this->_generateString($value);
        case self::INT:
            return $this->_generateInt($value);
        case self::FLOAT:
            return $this->_generateFloat($value);
        case self::BOOL:
            return $this->_generateBool($value);
        case self::BOOL_INT:
            return $this->_generateBoolInt($value);
        case self::DATETIME:
            return $this->_generateDateTime($value);
        case self::DATETIME_AS_STRING:
            return $this->_generateDateTimeAsString($value);
        case self::ORDERED_ARRAY:
            return $this->_generateOrderedKeyValueArrayForJson($value);
        default:
            return $value;
        }
    }

    /**
     * Min value
     *
     * @param int       $value Value
     * @param int|array $min   Min value
     *
     * @return int
     */
    private function _generateMin($value, $min)
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
     * @param int       $value Value
     * @param int|array $max   Max value
     *
     * @return int
     */
    private function _generateMax($value, $max)
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
     * @param int   $value      Value
     * @param array $parameters Additional parameters
     *
     * @return int
     */
    private function _generateMinThen($value, array $parameters)
    {
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
     * @param string $value Value
     *
     * @return string
     */
    private function _generateColor($value)
    {
        $isValid = preg_match(
            '/(.*?)(rgb|rgba)\((\d+),\s*(\d+),\s*(\d+)(?:,\s*(\d+(?:\.\d+)?))?\)/i',
            $value
        );

        if ($isValid) {
            return $value;
        }

        return "";
    }

    /**
     * Clears strip tags
     *
     * @param string $value Value
     *
     * @return string
     */
    private function _generateWithClearStripTags($value)
    {
        $value = preg_replace('/<script\b[^>]*>(.*?)<\/script>/is', "", $value);
        return trim(strip_tags($value));
    }

    /**
     * Copy name
     *
     * @param string $value Value
     *
     * @return string
     */
    private function _generateNameCopy($value)
    {
        return sprintf(
            "%s (%s)",
            $value,
            App::getInstance()->getLanguage()->getMessage("common", "copy")
        );
    }

    /**
     * Copy URL
     *
     * @param string $value Value
     *
     * @return string
     */
    private function _generateUrlCopy($value)
    {
        return $value . "-copy";
    }

    /**
     * Array key
     *
     * @param int|string $value      Value
     * @param array      $parameters Additional parameters
     *
     * @return int|string
     *
     * @throws ContentException
     */
    private function _generateArrayKey($value, array $parameters)
    {
        $list = $parameters[0];
        $defaultValue = null;
        if (isset($parameters[1])) {
            $defaultValue = $parameters[1];
        }

        if (!array_key_exists($value, $list)) {
            if (array_key_exists($defaultValue, $list)) {
                return $defaultValue;
            }

            throw new ContentException(
                "Unable to find value: {value} from array keys: {keys}",
                [
                    "value" => $value,
                    "keys"  => implode(", ", array_keys($list))
                ]
            );
        }

        return $value;
    }

    /**
     * URL
     *
     * @param string $value Value
     * @param string $name  Name to transliterate
     *
     * @return string
     */
    private function _generateUrl($value, $name)
    {
        if ($name !== "" && $value === "") {
            $value = $name;
        }
        $value = App::getInstance()->getLanguage()->getTransliteration($value);
        $value = str_replace(["_", " "], "-", $value);
        $value = strtolower($value);
        $value = preg_replace('~[^-a-z0-9]+~u', '', $value);
        $value = trim($value, "-");

        return $value;
    }

    /**
     * String type
     *
     * @param mixed|string $value Value
     *
     * @return string
     */
    private function _generateString($value)
    {
        return trim((string)$value);
    }

    /**
     * Generates int type
     *
     * @param mixed|string $value Value
     *
     * @return string
     */
    private function _generateInt($value)
    {
        return (int)$value;
    }

    /**
     * Generates float type
     *
     * @param mixed|string $value Value
     *
     * @return string
     */
    private function _generateFloat($value)
    {
        return (float)$value;
    }

    /**
     * Generates bool type
     *
     * @param mixed|string $value Value
     *
     * @return string
     */
    private function _generateBool($value)
    {
        if (is_bool($value)) {
            return $value;
        }

        if (is_int($value)) {
            if ($value > 0) {
                return true;
            }

            return false;
        }

        if (is_string($value)) {
            $value = trim(strtolower($value));
            if ($value === "true" || $value === "1") {
                return true;
            }
        }

        return false;
    }

    /**
     * Generates 1 or 0
     *
     * @param mixed|string $value Value
     *
     * @return string
     */
    private function _generateBoolInt($value)
    {
        if ($value === true) {
            return 1;
        }

        if ($value === false) {
            return 0;
        }

        $value = (int)$value;
        if ($value >= 1) {
            return 1;
        }

        return 0;
    }

    /**
     * Generates DateTime
     *
     * @param mixed|string $value Value
     *
     * @return \DateTime
     */
    private function _generateDateTime($value)
    {
        try {
            $dateTime = new \DateTime($value);
        } catch (\Exception $e) {
            $dateTime = new \DateTime();
        }

        return $dateTime;
    }

    /**
     * Generates DateTime as string
     *
     * @param mixed|\DateTime $value Value
     *
     * @return string
     */
    private function _generateDateTimeAsString($value)
    {
        if ($value instanceof \DateTime) {
            return $value->format("Y-m-d H:i:s");
        }

        return date("Y-m-d H:i:s", time());
    }

    /**
     * Gets value by operator
     *
     * @param int    $value1   Value 1
     * @param int    $value2   Value
     * @param string $operator Operator to compare
     * @param int    $default  Default value
     *
     * @return float|int
     */
    private function _getValueByOperator($value1, $value2, $operator, $default = 0)
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
            return $default;
        }
    }

    /**
     * Generates ordered key value array for json
     *
     * @param array $array Array to order
     *
     * @return array
     */
    private function _generateOrderedKeyValueArrayForJson(array $array)
    {
        asort($array);
        $list = [];

        foreach ($array as $key => $value) {
            $list[] = [
                "key"   => $key,
                "value" => $value
            ];
        }

        return $list;
    }
}