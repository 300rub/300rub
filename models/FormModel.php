<?php

namespace testS\models;

use testS\components\Validator;
use testS\components\ValueGenerator;

/**
 * Model for working with table "forms"
 *
 * @package testS\models
 */
class FormModel extends AbstractModel
{

    /**
     * Gets table name
     *
     * @return string
     */
    public function getTableName()
    {
        return "forms";
    }

    /**
     * Gets fields info
     *
     * @return array
     */
    public function getFieldsInfo()
    {
        return [
            "designFormId" => [
                self::FIELD_RELATION => "DesignFormModel"
            ],
            "hasLabel"     => [
                self::FIELD_TYPE => self::FIELD_TYPE_BOOL
            ],
            "successText"  => [
                self::FIELD_TYPE       => self::FIELD_TYPE_STRING,
                self::FIELD_VALIDATION => [
                    Validator::TYPE_MAX_LENGTH => 255
                ],
                self::FIELD_VALUE      => [
                    ValueGenerator::TYPE_CLEAR_STRIP_TAGS
                ],
            ],
        ];
    }
}