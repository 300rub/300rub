<?php

namespace testS\components;

/**
 * Class for generation values
 *
 * @package testS\components
 */
class ValueGenerator
{

    /**
     * Min value
     *
     * @param int $value
     * @param int $min
     *
     * @return int
     */
    public static function min($value, $min)
    {
        if ($value < $min) {
            $value = $min;
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
    public static function minThen($value, array $parameters) {
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
    public static function color($value)
    {
        if (preg_match('/(.*?)(rgb|rgba)\((\d+),\s*(\d+),\s*(\d+)(?:,\s*(\d+(?:\.\d+)?))?\)/i', $value)) {
            return $value;
        }

        return "";
    }

    /**
     * Array key
     *
     * @param int|string $value
     * @param array $parameters
     *
     * @return int|string
     */
    public static function arrayKey($value, array $parameters)
    {
        $list = $parameters[0];
        $defaultValue = $parameters[1];

        if (!array_key_exists($value, $list)) {
            return $defaultValue;
        }

        return $value;
    }

    /**
     * Clears strip tags
     *
     * @param string $value
     *
     * @return string
     */
    public static function clearStripTags($value)
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
    public static function copyName($value)
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
    public static function copyUrl($value)
    {
        return $value . "-copy" . rand(1000, 100000);
    }

    /**
     * URL
     *
     * @param string $value
     * @param string $name
     *
     * @return string
     */
    public static function url($value, $name)
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
}