<?php

namespace testS\models;

/**
 * Model for working with table "tabInstances"
 *
 * @package testS\models
 */
class TabInstanceModel extends AbstractModel
{

    /**
     * Gets table name
     *
     * @return string
     */
    public function getTableName()
    {
        return "tabInstances";
    }

    /**
     * Gets fields info
     *
     * @return array
     */
    public function getFieldsInfo()
    {
        return [
            "tabGroupId"     => [
                self::FIELD_RELATION_TO_PARENT => "TabGroupModel",
            ],
            "textInstanceId" => [
                self::FIELD_RELATION => "TextInstanceModel",
            ],
            "tabTemplateId"  => [
                self::FIELD_RELATION_TO_PARENT => "TabTemplateModel",
            ],
        ];
    }
}