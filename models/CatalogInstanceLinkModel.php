<?php

namespace testS\models;

/**
 * Model for working with table "catalogInstanceLinks"
 *
 * @package testS\models
 */
class CatalogInstanceLinkModel extends AbstractModel
{

    /**
     * Gets table name
     *
     * @return string
     */
    public function getTableName()
    {
        return "catalogInstanceLinks";
    }

    /**
     * Gets fields info
     *
     * @return array
     */
    public function getFieldsInfo()
    {
        return [
            "catalogInstanceId"     => [
                self::FIELD_RELATION_TO_PARENT => "CatalogInstanceModel"
            ],
            "linkCatalogInstanceId" => [
                self::FIELD_RELATION_TO_PARENT => "CatalogInstanceModel"
            ],
        ];
    }
}