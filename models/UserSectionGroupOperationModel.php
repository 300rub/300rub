<?php

namespace testS\models;

use testS\components\Validator;

/**
 * Model for working with table "userSectionGroupOperations"
 *
 * @package testS\models
 */
class UserSectionGroupOperationModel extends AbstractModel
{

    /**
     * Gets table name
     *
     * @return string
     */
    public function getTableName()
    {
        return "userSectionGroupOperations";
    }

    /**
     * Gets fields info
     *
     * @return array
     */
    public function getFieldsInfo()
    {
        return [
            "userSectionGroupId"   => [
                self::FIELD_RELATION_TO_PARENT => "UserSectionGroupModel"
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