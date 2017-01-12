<?php

namespace testS\models;

/**
 * Model for working with table "help"
 *
 * @package testS\models
 */
class HelpModel extends AbstractModel
{

    /**
     * Gets table name
     *
     * @return string
     */
    public function getTableName()
    {
        return "help";
    }

    /**
     * Gets fields info
     *
     * @return array
     */
    public function getFieldsInfo()
    {
        return [
            "language" => [
                self::FIELD_TYPE => self::FIELD_TYPE_STRING,
            ],
            "category" => [
                self::FIELD_TYPE => self::FIELD_TYPE_STRING,
            ],
            "name"     => [
                self::FIELD_TYPE => self::FIELD_TYPE_STRING,
            ],
            "content"  => [
                self::FIELD_TYPE => self::FIELD_TYPE_STRING,
            ],
        ];
    }
}