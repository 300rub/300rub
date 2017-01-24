<?php

namespace testS\models;

/**
 * Model for working with table "settings"
 *
 * @package testS\models
 */
class SettingModel extends AbstractModel
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
            "iconImageId" => [
                self::FIELD_RELATION => "ImageModel"
            ],
            "seoId"       => [
                self::FIELD_RELATION => "SeoModel"
            ],
        ];
    }
}