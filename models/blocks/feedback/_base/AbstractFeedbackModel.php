<?php

namespace testS\models\blocks\feedback\_base;

use testS\application\components\Validator;
use testS\application\components\ValueGenerator;
use testS\models\blocks\feedback\_abstract\AbstractFeedbackModel as Model;

/**
 * Abstract model for working with table "feedback"
 */
abstract class AbstractFeedbackModel extends Model
{

    /**
     * Gets table name
     *
     * @return string
     */
    public function getTableName()
    {
        return 'feedback';
    }

    /**
     * Gets fields info
     *
     * @return array
     */
    public function getFieldsInfo()
    {
        return [
            'formId' => [
                self::FIELD_RELATION
                    => '\\testS\\models\\blocks\\helpers\\form\\FormModel'
            ],
            'subjectFormInstanceId' => [
                self::FIELD_RELATION
                    => '\\testS\\models\\blocks\\helpers\\' .
                        'form\\FormInstanceModel'
            ],
            'subjectText' => [
                self::FIELD_TYPE => self::FIELD_TYPE_STRING,
                self::FIELD_VALIDATION => [
                    Validator::TYPE_MAX_LENGTH => 255
                ],
                self::FIELD_VALUE => [
                    ValueGenerator::CLEAR_STRIP_TAGS
                ],
            ],
            'host' => [
                self::FIELD_TYPE => self::FIELD_TYPE_STRING,
                self::FIELD_VALIDATION => [
                    Validator::TYPE_MAX_LENGTH => 255,
                    ValueGenerator::CLEAR_STRIP_TAGS
                ],
            ],
            'port' => [
                self::FIELD_TYPE => self::FIELD_TYPE_INT,
            ],
            'type' => [
                self::FIELD_TYPE => self::FIELD_TYPE_STRING,
                self::FIELD_VALIDATION => [
                    Validator::TYPE_MAX_LENGTH => 25
                ],
                self::FIELD_VALUE => [
                    ValueGenerator::CLEAR_STRIP_TAGS
                ]
            ],
            'user' => [
                self::FIELD_TYPE => self::FIELD_TYPE_STRING,
                self::FIELD_VALIDATION => [
                    Validator::TYPE_MAX_LENGTH => 255,
                ],
                self::FIELD_VALUE => [
                    ValueGenerator::CLEAR_STRIP_TAGS
                ]
            ],
            'password' => [
                self::FIELD_TYPE => self::FIELD_TYPE_STRING,
                self::FIELD_VALIDATION => [
                    Validator::TYPE_MAX_LENGTH => 255
                ],
            ],
        ];
    }
}
