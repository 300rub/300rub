<?php

namespace testS\models;

use testS\components\Validator;
use testS\components\ValueGenerator;

/**
 * Model for working with table "formListValues"
 *
 * @package testS\models
 */
class FormListValueModel extends AbstractModel
{

    /**
     * Gets table name
     *
     * @return string
     */
    public function getTableName()
    {
        return "formListValues";
    }

    /**
     * Gets fields info
     *
     * @return array
     */
    public function getFieldsInfo()
    {
        return [
            "formInstanceId" => [
                self::FIELD_RELATION_TO_PARENT => "FormInstanceModel"
            ],
            "sort"           => [
                self::FIELD_TYPE => self::FIELD_TYPE_INT
            ],
            "value"          => [
                self::FIELD_TYPE       => self::FIELD_TYPE_STRING,
                self::FIELD_VALIDATION => [
                    Validator::TYPE_MAX_LENGTH => 255
                ],
                self::FIELD_VALUE      => [
                    ValueGenerator::TYPE_CLEAR_STRIP_TAGS
                ],
            ],
            "isChecked"      => [
                self::FIELD_TYPE => self::FIELD_TYPE_BOOL
            ],
        ];
    }
}