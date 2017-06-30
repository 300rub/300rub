<?php

namespace testS\models;

use testS\components\Validator;
use testS\components\ValueGenerator;

/**
 * Model for working with table "catalogOrders"
 *
 * @package testS\models
 */
class CatalogOrderModel extends AbstractModel
{

    /**
     * Gets table name
     *
     * @return string
     */
    public function getTableName()
    {
        return "catalogOrders";
    }

    /**
     * Gets fields info
     *
     * @return array
     */
    public function getFieldsInfo()
    {
        return [
            "catalogBinId" => [
                self::FIELD_RELATION_TO_PARENT   => "CatalogBinModel",
                self::FIELD_SKIP_DUPLICATION     => true,
                self::FIELD_NOT_CHANGE_ON_UPDATE => true,
            ],
            "formId"       => [
                self::FIELD_RELATION_TO_PARENT   => "FormModel",
                self::FIELD_SKIP_DUPLICATION     => true,
                self::FIELD_NOT_CHANGE_ON_UPDATE => true,
            ],
            "email"        => [
                self::FIELD_TYPE                 => self::FIELD_TYPE_STRING,
                self::FIELD_VALIDATION           => [
                    Validator::TYPE_EMAIL
                ],
                self::FIELD_SKIP_DUPLICATION     => true,
            ],
        ];
    }
}