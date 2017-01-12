<?php

namespace testS\models;

use testS\components\Validator;

/**
 * Model for working with table "userSettingsOperations"
 *
 * @package testS\models
 */
class UserSettingsOperationModel extends AbstractModel
{

    /**
     * Gets table name
     *
     * @return string
     */
    public function getTableName()
    {
        return "userSettingsOperations";
    }

    /**
     * Gets fields info
     *
     * @return array
     */
    public function getFieldsInfo()
    {
        return [
            "userId"    => [
                self::FIELD_RELATION_TO_PARENT => "UserModel"
            ],
            "operation" => [
                self::FIELD_TYPE       => self::FIELD_TYPE_STRING,
                self::FIELD_VALIDATION => [
                    Validator::TYPE_REQUIRED,
                    Validator::TYPE_MAX_LENGTH => 50
                ],
            ],
        ];
    }
}