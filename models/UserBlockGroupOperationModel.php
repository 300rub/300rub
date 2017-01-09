<?php

namespace testS\models;

use testS\components\Validator;

/**
 * Model for working with table "userBlockGroupOperations"
 *
 * @package testS\models
 */
class UserBlockGroupOperationModel extends AbstractModel
{

    /**
     * Gets table name
     *
     * @return string
     */
    public function getTableName()
    {
        return "userBlockGroupOperations";
    }

    /**
     * Gets fields info
     *
     * @return array
     */
    public function getFieldsInfo()
    {
        return [
            "userBlockGroupId"   => [
                self::FIELD_RELATION => ["UserBlockGroupModel"]
            ],
            "operation"   => [
                self::FIELD_TYPE => self::FIELD_TYPE_STRING,
                self::FIELD_VALIDATION  => [
                    Validator::TYPE_REQUIRED,
                    Validator::TYPE_MAX_LENGTH => 50
                ],
            ],
        ];
    }
}