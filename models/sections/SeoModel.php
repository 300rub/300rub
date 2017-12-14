<?php

namespace testS\models;

use testS\components\Validator;
use testS\components\ValueGenerator;

/**
 * Model for working with table "seo"
 *
 * @package testS\models
 */
class SeoModel extends AbstractModel
{

    /**
     * Page title
     *
     * @var string
     */
    private static $_title;

    /**
     * Page keywords
     *
     * @var string
     */
    private static $_keywords;

    /**
     * Page description
     *
     * @var string
     */
    private static $_description;

    /**
     * Sets page title
     *
     * @param string $title
     */
    public static function setTitle($title)
    {
        self::$_title = $title;
    }

    /**
     * Gets page title
     *
     * @return string
     */
    public static function getTitle()
    {
        return self::$_title;
    }

    /**
     * Sets page keywords
     *
     * @param string $keywords
     */
    public static function setKeywords($keywords)
    {
        self::$_keywords = $keywords;
    }

    /**
     * Gets page keywords
     *
     * @return string
     */
    public static function getKeywords()
    {
        return self::$_keywords;
    }

    /**
     * Sets page description
     *
     * @param string $description
     */
    public static function setDescription($description)
    {
        self::$_description = $description;
    }

    /**
     * Gets page description
     *
     * @return string
     */
    public static function getDescription()
    {
        return self::$_description;
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
    public function getFieldsInfo()
    {
        return [
            "name"        => [
                self::FIELD_TYPE                => self::FIELD_TYPE_STRING,
                self::FIELD_VALIDATION          => [
                    Validator::TYPE_REQUIRED,
                    Validator::TYPE_MAX_LENGTH => 255
                ],
                self::FIELD_VALUE               => [
                    ValueGenerator::CLEAR_STRIP_TAGS
                ],
                self::FIELD_CHANGE_ON_DUPLICATE => [
                    ValueGenerator::COPY_NAME
                ],
            ],
            "url"         => [
                self::FIELD_TYPE                => self::FIELD_TYPE_STRING,
                self::FIELD_VALIDATION          => [
                    Validator::TYPE_REQUIRED,
                    Validator::TYPE_URL,
                    Validator::TYPE_MAX_LENGTH => 255
                ],
                self::FIELD_VALUE               => [
                    ValueGenerator::CLEAR_STRIP_TAGS,
                    ValueGenerator::URL => "{name}"
                ],
                self::FIELD_CHANGE_ON_DUPLICATE => [
                    ValueGenerator::COPY_URL
                ]
            ],
            "title"       => [
                self::FIELD_TYPE             => self::FIELD_TYPE_STRING,
                self::FIELD_VALIDATION       => [
                    Validator::TYPE_MAX_LENGTH => 100
                ],
                self::FIELD_VALUE            => [
                    ValueGenerator::CLEAR_STRIP_TAGS,
                ],
                self::FIELD_SKIP_DUPLICATION => true,
            ],
            "keywords"    => [
                self::FIELD_TYPE             => self::FIELD_TYPE_STRING,
                self::FIELD_VALIDATION       => [
                    Validator::TYPE_MAX_LENGTH => 255
                ],
                self::FIELD_VALUE            => [
                    ValueGenerator::CLEAR_STRIP_TAGS,
                ],
                self::FIELD_SKIP_DUPLICATION => true,
            ],
            "description" => [
                self::FIELD_TYPE             => self::FIELD_TYPE_STRING,
                self::FIELD_VALIDATION       => [
                    Validator::TYPE_MAX_LENGTH => 255
                ],
                self::FIELD_VALUE            => [
                    ValueGenerator::CLEAR_STRIP_TAGS,
                ],
                self::FIELD_SKIP_DUPLICATION => true,
            ],
        ];
    }
}