<?php

namespace testS\models;

/**
 * Model for working with table "tabGroups"
 *
 * @package testS\models
 */
class TabGroupModel extends AbstractModel
{

    /**
     * Gets table name
     *
     * @return string
     */
    public function getTableName()
    {
        return "tabGroups";
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
                self::FIELD_RELATION_TO_PARENT   => "TabModel",
                self::FIELD_NOT_CHANGE_ON_UPDATE => true,
            ],
        ];
    }
}