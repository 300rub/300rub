<?php

namespace testS\models;

/**
 * Model for working with table "settings"
 *
 * @package testS\models
 */
class SettingsModel extends AbstractModel
{

    /**
     * Gets table name
     *
     * @return string
     */
    public function getTableName()
    {
        return "settings";
    }

    /**
     * Gets fields info
     *
     * @return array
     */
    public function getFieldsInfo()
    {
        return [
            "type" => [
                self::FIELD_TYPE => self::FIELD_TYPE_INT
            ],
            "value"       => [
                self::FIELD_TYPE => self::FIELD_TYPE_STRING
            ],
        ];
    }
}