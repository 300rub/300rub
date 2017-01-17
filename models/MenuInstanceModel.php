<?php

namespace testS\models;

use testS\components\Validator;
use testS\components\ValueGenerator;

/**
 * Model for working with table "menuInstances"
 *
 * @package testS\models
 */
class MenuInstanceModel extends AbstractModel
{

    /**
     * Gets table name
     *
     * @return string
     */
    public function getTableName()
    {
        return "menuInstances";
    }

    /**
     * Gets fields info
     *
     * @return array
     */
    public function getFieldsInfo()
    {
        return [
            "menuId"    => [
                self::FIELD_RELATION_TO_PARENT => "MenuModel"
            ],
            "parentId"  => [
                self::FIELD_RELATION_TO_PARENT => "MenuInstanceModel"
            ],
            "sectionId" => [
                self::FIELD_RELATION => "SectionModel"
            ],
            "icon"      => [
                self::FIELD_TYPE       => self::FIELD_TYPE_STRING,
                self::FIELD_VALIDATION => [
                    Validator::TYPE_MAX_LENGTH => 50
                ],
                self::FIELD_VALUE      => [
                    ValueGenerator::TYPE_CLEAR_STRIP_TAGS
                ],
            ],
            "subName"   => [
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