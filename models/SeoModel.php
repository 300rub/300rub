<?php

namespace testS\models;

/**
 * Model for working with table "seo"
 *
 * @package testS\models
 */
class SeoModel extends AbstractModel
{

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
                    "required",
                    "max" => 255
                ],
                self::FIELD_VALUE               => [
                    "clearStripTags"
                ],
                self::FIELD_CHANGE_ON_DUPLICATE => [
                    "copyName"
                ],
            ],
            "url"         => [
                self::FIELD_TYPE                => self::FIELD_TYPE_STRING,
                self::FIELD_VALIDATION          => [
                    "required",
                    "url",
                    "max" => 255
                ],
                self::FIELD_VALUE               => [
                    "clearStripTags",
                    "url" => "{name}"
                ],
                self::FIELD_CHANGE_ON_DUPLICATE => [
                    "copyUrl"
                ]
            ],
            "title"       => [
                self::FIELD_TYPE             => self::FIELD_TYPE_STRING,
                self::FIELD_VALIDATION       => [
                    "max" => 100
                ],
                self::FIELD_VALUE            => [
                    "clearStripTags"
                ],
                self::FIELD_SKIP_DUPLICATION => true,
            ],
            "keywords"    => [
                self::FIELD_TYPE             => self::FIELD_TYPE_STRING,
                self::FIELD_VALIDATION       => [
                    "max" => 255
                ],
                self::FIELD_VALUE            => [
                    "clearStripTags"
                ],
                self::FIELD_SKIP_DUPLICATION => true,
            ],
            "description" => [
                self::FIELD_TYPE             => self::FIELD_TYPE_STRING,
                self::FIELD_VALIDATION       => [
                    "max" => 255
                ],
                self::FIELD_VALUE            => [
                    "clearStripTags"
                ],
                self::FIELD_SKIP_DUPLICATION => true,
            ],
        ];
    }
}