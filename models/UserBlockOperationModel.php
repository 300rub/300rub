<?php

namespace testS\models;

use testS\components\Validator;

/**
 * Model for working with table "userBlockOperations"
 *
 * @package testS\models
 */
class UserBlockOperationModel extends AbstractModel
{

    /**
     * Gets table name
     *
     * @return string
     */
    public function getTableName()
    {
        return "userBlockOperations";
    }

    /**
     * Gets fields info
     *
     * @return array
     */
    public function getFieldsInfo()
    {
        return [
            "userBlockId"   => [
                self::FIELD_RELATION_TO_PARENT => "UserBlockModel"
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