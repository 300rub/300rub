<?php

namespace testS\models;

use testS\components\ValueGenerator;

/**
 * Model for working with table "catalogBins"
 *
 * @package testS\models
 */
class CatalogBinModel extends AbstractModel
{

    /**
     * Statuses
     */
    const STATUS_ADDED = 0;

    /**
     * Gets a status list
     *
     * @return array
     */
    public static function getStatusList()
    {
        return [
            self::STATUS_ADDED => ""
        ];
    }

    /**
     * Gets table name
     *
     * @return string
     */
    public function getTableName()
    {
        return "catalogBins";
    }

    /**
     * Gets fields info
     *
     * @return array
     */
    public function getFieldsInfo()
    {
        return [
            "catalogId"         => [
                self::FIELD_RELATION => "CatalogModel"
            ],
            "catalogInstanceId" => [
                self::FIELD_RELATION => "CatalogInstanceModel"
            ],
            "count"             => [
                self::FIELD_TYPE  => self::FIELD_TYPE_INT,
                self::FIELD_VALUE => [
                    ValueGenerator::MIN => 0
                ],
            ],
            "status"            => [
                self::FIELD_TYPE  => self::FIELD_TYPE_INT,
                self::FIELD_VALUE => [
                    ValueGenerator::ARRAY_KEY => [
                        self::getStatusList(),
                        self::STATUS_ADDED
                    ]
                ],
            ],
        ];
    }
}