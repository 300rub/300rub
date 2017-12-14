<?php

namespace testS\models;

/**
 * Model for working with table "fields"
 *
 * @package testS\models
 */
class FieldModel extends AbstractModel
{

    /**
     * Gets table name
     *
     * @return string
     */
    public function getTableName()
    {
        return "fields";
    }

    /**
     * Gets fields info
     *
     * @return array
     */
    public function getFieldsInfo()
    {
        return [
            "designFieldId"       => [
                self::FIELD_RELATION => "DesignFieldModel"
            ],
        ];
    }
}