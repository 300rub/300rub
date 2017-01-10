<?php

namespace testS\models;

use testS\components\ValueGenerator;

/**
 * Model for working with table "userBlockGroups"
 *
 * @package testS\models
 */
class UserBlockGroupModel extends AbstractModel
{

    /**
     * Gets table name
     *
     * @return string
     */
    public function getTableName()
    {
        return "userBlockGroups";
    }

    /**
     * Gets fields info
     *
     * @return array
     */
    public function getFieldsInfo()
    {
        return [
            "userId"   => [
                self::FIELD_RELATION_TO_PARENT => "UserModel"
            ],
            "blockType"   => [
                self::FIELD_TYPE => self::FIELD_TYPE_INT,
                self::FIELD_VALUE => [
                    ValueGenerator::TYPE_ARRAY_KEY => [BlockModel::$typeList]
                ],
            ],
        ];
    }
}