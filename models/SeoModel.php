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