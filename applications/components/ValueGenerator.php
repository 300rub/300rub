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
abstract class ValueGenerator
{

    /**
     * Types
     */
    const MIN = "Min";
    const MAX = "Max";
    const MIN_THEN = "MinThen";
    const COLOR = "Color";
    const CLEAR_STRIP_TAGS = "ClearStripTags";
    const COPY_NAME = "CopyName";
    const COPY_URL = "CopyUrl";
    const ARRAY_KEY = "ArrayKey";
    const URL = "Url";
    const STRING = "String";
    const INT = "Int";
    const FLOAT = "Float";
    const BOOL = "Bool";
    const BOOL_INT = "BoolInt";
    const DATETIME = "Datetime";
    const DATETIME_AS_STRING = "DatetimeAsString";
    const ORDERED_ARRAY = "OrderedArray";

    protected static $typeList = [
        self::MIN,
        self::MAX,
        self::MIN_THEN,
        self::COLOR,
        self::CLEAR_STRIP_TAGS,
        self::COPY_NAME,
        self::COPY_URL,
        self::ARRAY_KEY,
        self::URL,
        self::STRING,
        self::INT,
        self::FLOAT,
        self::BOOL,
        self::BOOL_INT,
        self::DATETIME,
        self::DATETIME_AS_STRING,
        self::ORDERED_ARRAY,
    ];

    /**
     * Generates value
     *
     * @param mixed $value Initial value
     * @param mixed $param Param
     *
     * @return mixed
     */
    abstract public function generate($value, $param);

    /**
     * Generates a value
     *
     * @param string $type  Generator type
     * @param mixed  $value Value
     * @param mixed  $param Additional parameter
     *
     * @return mixed
     */
    public static function factory($type, $value, $param = null)
    {
        if (!in_array($type, self::$typeList)) {
            return $value;
        }

        /**
         * @var ValueGenerator $object
         */
        $className = "\\testS\\applications\\components\\ValueGenerator\\" . $type;
        $object = new $className;

        return $object->generate($value, $param);
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
    protected function getValueByOperator($value1, $value2, $operator, $default = 0)
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