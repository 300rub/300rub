<?php

namespace testS\models;

use testS\components\Validator;
use testS\components\ValueGenerator;

/**
 * Model for working with table "searchQueries"
 *
 * @package testS\models
 */
class SearchQueryModel extends AbstractModel
{

    /**
     * Gets table name
     *
     * @return string
     */
    public function getTableName()
    {
        return "searchQueries";
    }

    /**
     * Gets fields info
     *
     * @return array
     */
    public function getFieldsInfo()
    {
        return [
            "searchId"   => [
                self::FIELD_RELATION_TO_PARENT => "SearchModel"
            ],
            "text"       => [
                self::FIELD_TYPE       => self::FIELD_TYPE_STRING,
                self::FIELD_VALIDATION => [
                    Validator::TYPE_REQUIRED,
                    Validator::TYPE_MAX_LENGTH => 255
                ],
                self::FIELD_VALUE      => [
                    ValueGenerator::TYPE_CLEAR_STRIP_TAGS
                ],
            ],
            "date"       => [
                self::FIELD_TYPE => self::FIELD_TYPE_DATETIME,
            ],
            "ip"         => [
                self::FIELD_TYPE       => self::FIELD_TYPE_STRING,
                self::FIELD_VALIDATION => [
                    Validator::TYPE_IP
                ],
            ],
            "ua"         => [
                self::FIELD_TYPE       => self::FIELD_TYPE_STRING,
                self::FIELD_VALIDATION => [
                    Validator::TYPE_REQUIRED,
                    Validator::TYPE_MAX_LENGTH => 255
                ],
            ],
            "port"       => [
                self::FIELD_TYPE => self::FIELD_TYPE_INT,
            ],
            "connection" => [
                self::FIELD_TYPE       => self::FIELD_TYPE_STRING,
                self::FIELD_VALIDATION => [
                    Validator::TYPE_REQUIRED,
                    Validator::TYPE_MAX_LENGTH => 255
                ],
            ],
            "host"       => [
                self::FIELD_TYPE       => self::FIELD_TYPE_STRING,
                self::FIELD_VALIDATION => [
                    Validator::TYPE_REQUIRED,
                    Validator::TYPE_MAX_LENGTH => 255
                ],
            ],
            "ref"        => [
                self::FIELD_TYPE       => self::FIELD_TYPE_STRING,
                self::FIELD_VALIDATION => [
                    Validator::TYPE_REQUIRED,
                    Validator::TYPE_MAX_LENGTH => 255
                ],
            ],
        ];
    }
}