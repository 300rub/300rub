<?php

namespace testS\models;

use testS\components\Validator;
use testS\components\ValueGenerator;

/**
 * Model for working with table "feedback"
 *
 * @package testS\models
 */
class FeedbackModel extends AbstractModel
{

    /**
     * Gets table name
     *
     * @return string
     */
    public function getTableName()
    {
        return "feedback";
    }

    /**
     * Gets fields info
     *
     * @return array
     */
    public function getFieldsInfo()
    {
        return [
            "formId"                => [
                self::FIELD_RELATION => "FormModel"
            ],
            "subjectFormInstanceId" => [
                self::FIELD_RELATION => "FormInstanceModel"
            ],
            "subjectText"           => [
                self::FIELD_TYPE       => self::FIELD_TYPE_STRING,
                self::FIELD_VALIDATION => [
                    Validator::TYPE_MAX_LENGTH => 255
                ],
                self::FIELD_VALUE      => [
                    ValueGenerator::CLEAR_STRIP_TAGS
                ],
            ],
            "host"                  => [
                self::FIELD_TYPE       => self::FIELD_TYPE_STRING,
                self::FIELD_VALIDATION => [
                    Validator::TYPE_MAX_LENGTH => 255,
                    ValueGenerator::CLEAR_STRIP_TAGS
                ],
            ],
            "port"                  => [
                self::FIELD_TYPE => self::FIELD_TYPE_INT,
            ],
            "type"                  => [
                self::FIELD_TYPE       => self::FIELD_TYPE_STRING,
                self::FIELD_VALIDATION => [
                    Validator::TYPE_MAX_LENGTH => 25
                ],
                self::FIELD_VALUE => [
                    ValueGenerator::CLEAR_STRIP_TAGS
                ]
            ],
            "user"                  => [
                self::FIELD_TYPE       => self::FIELD_TYPE_STRING,
                self::FIELD_VALIDATION => [
                    Validator::TYPE_MAX_LENGTH => 255,
                ],
                self::FIELD_VALUE => [
                    ValueGenerator::CLEAR_STRIP_TAGS
                ]
            ],
            "password"              => [
                self::FIELD_TYPE       => self::FIELD_TYPE_STRING,
                self::FIELD_VALIDATION => [
                    Validator::TYPE_MAX_LENGTH => 255
                ],
            ],
        ];
    }
}