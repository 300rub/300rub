<?php

namespace testS\models;

use testS\components\ValueGenerator;
use testS\components\Validator;

/**
 * Model for working with table "fieldInstances"
 *
 * @package testS\models
 */
class FieldInstanceModel extends AbstractModel
{

    /**
     * Gets table name
     *
     * @return string
     */
    public function getTableName()
    {
        return "fieldInstances";
    }

    /**
     * Gets fields info
     *
     * @return array
     */
    public function getFieldsInfo()
    {
        return [
            "fieldGroupId"    => [
                self::FIELD_RELATION_TO_PARENT => "FieldGroupModel",
            ],
            "fieldTemplateId" => [
                self::FIELD_RELATION_TO_PARENT => "FieldTemplateModel",
            ],
            "value"           => [
                self::FIELD_TYPE       => self::FIELD_TYPE_STRING,
                self::FIELD_VALIDATION => [
                    Validator::TYPE_MAX_LENGTH => 255,
                ],
                self::FIELD_VALUE      => [
                    ValueGenerator::CLEAR_STRIP_TAGS
                ],
            ],
        ];
    }
}