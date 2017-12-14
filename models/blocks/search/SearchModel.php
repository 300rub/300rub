<?php

namespace testS\models;

/**
 * Model for working with table "search"
 *
 * @package testS\models
 */
class SearchModel extends AbstractModel
{

    /**
     * Gets table name
     *
     * @return string
     */
    public function getTableName()
    {
        return "search";
    }

    /**
     * Gets fields info
     *
     * @return array
     */
    public function getFieldsInfo()
    {
        return [
            "formId"      => [
                self::FIELD_RELATION => "FormModel"
            ],
            "searchDesignId"          => [
                self::FIELD_RELATION => "DesignSearchModel"
            ],
        ];
    }
}