<?php

namespace testS\models;

use testS\components\Language;

/**
 * Model for working with table "seo"
 *
 * @property string $name
 *
 * @package testS\models
 */
class SeoModel extends AbstractModel
{

    /**
     * Gets model object
     *
     * @return SeoModel
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
        return "seo";
    }

    /**
     * Gets fields info
     *
     * @return array
     */
    protected function getFieldsInfo()
    {
        return [
            "name" => [
                self::FIELD_VALIDATION          => ["required", "max" => 255],
                self::FIELD_SET                 => ["clearStripTags"],
                self::FIELD_CHANGE_ON_DUPLICATE => "getCopyName",
            ],
            "url" => [
                self::FIELD_VALIDATION          => ["required", "url", "max" => 255],
                self::FIELD_SET                 => ["clearStripTags", "parseUrl"],
                self::FIELD_CHANGE_ON_DUPLICATE => "getCopyUrl"
            ],
            "title" => [
                self::FIELD_VALIDATION        => ["max" => 100],
                self::FIELD_SET               => ["clearStripTags"],
                self::FIELD_SKIP_DUPLICATION  => true,
            ],
            "keywords" => [
                self::FIELD_VALIDATION        => ["max" => 255],
                self::FIELD_SET               => ["clearStripTags"],
                self::FIELD_SKIP_DUPLICATION  => true,
            ],
            "description" => [
                self::FIELD_VALIDATION        => ["max" => 255],
                self::FIELD_SET               => ["clearStripTags"],
                self::FIELD_SKIP_DUPLICATION  => true,
            ],
        ];
    }

    /**
     * Parses URL
     *
     * @param string $value
     *
     * @return string
     */
    protected function parseUrl($value)
    {
        if ($this->name && !$value) {
            $value = $this->name;
        }
        $value = Language::translit($value);
        $value = str_replace(["_", " "], "-", $value);
        $value = strtolower($value);
        $value = preg_replace('~[^-a-z0-9]+~u', '', $value);
        $value = trim($value, "-");

        return $value;
    }

    /**
     * Adds url condition to SQL
     *
     * @param string $url URL
     *
     * @return SeoModel
     */
    public function byUrl($url)
    {
        $this->getDb()->addWhere(sprintf("%s.url = :url", $this->getTableName()));
        $this->getDb()->addParameter("url", $url);

        return $this;
    }

    /**
     * Gets copy URL
     *
     * @param string $value
     *
     * @return string
     */
    protected function getCopyUrl($value)
    {
        return $value . "-copy" . rand(1000, 100000);
    }
}