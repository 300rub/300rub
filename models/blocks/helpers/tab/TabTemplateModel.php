<?php

namespace testS\models;

use testS\components\ValueGenerator;
use testS\components\Validator;

/**
 * Model for working with table "tabTemplates"
 *
 * @package testS\models
 */
class TabTemplateModel extends AbstractModel
{

    /**
     * Gets table name
     *
     * @return string
     */
    public function getTableName()
    {
        return "tabTemplates";
    }

    /**
     * Gets fields info
     *
     * @return array
     */
    public function getFieldsInfo()
    {
        return [
            "tabId" => [
                self::FIELD_RELATION_TO_PARENT => "TabModel",
            ],
            "sort"  => [
                self::FIELD_TYPE => self::FIELD_TYPE_INT,
            ],
            "label" => [
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