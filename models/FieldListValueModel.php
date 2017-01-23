<?php

namespace testS\models;

use testS\components\ValueGenerator;
use testS\components\Validator;

/**
 * Model for working with table "fieldListValues"
 *
 * @package testS\models
 */
class FieldListValueModel extends AbstractModel
{

    /**
     * Gets table name
     *
     * @return string
     */
    public function getTableName()
    {
        return "fieldListValues";
    }

    /**
     * Gets fields info
     *
     * @return array
     */
    public function getFieldsInfo()
    {
        return [
            "fieldTemplateId" => [
                self::FIELD_RELATION_TO_PARENT => "FieldTemplateModel",
            ],
            "value"           => [
                self::FIELD_TYPE       => self::FIELD_TYPE_STRING,
                self::FIELD_VALIDATION => [
                    Validator::TYPE_MAX_LENGTH => 255,
                ],
                self::FIELD_VALUE      => [
                    ValueGenerator::TYPE_CLEAR_STRIP_TAGS
                ],
            ],
            "sort"            => [
                self::FIELD_TYPE => self::FIELD_TYPE_INT,
            ],
            "isChecked"       => [
                self::FIELD_TYPE => self::FIELD_TYPE_BOOL,
            ],
        ];
    }
}