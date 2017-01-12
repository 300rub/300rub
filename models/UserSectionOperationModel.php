<?php

namespace testS\models;

use testS\components\Validator;

/**
 * Model for working with table "userSectionOperations"
 *
 * @package testS\models
 */
class UserSectionOperationModel extends AbstractModel
{

    /**
     * Gets table name
     *
     * @return string
     */
    public function getTableName()
    {
        return "userSectionOperations";
    }

    /**
     * Gets fields info
     *
     * @return array
     */
    public function getFieldsInfo()
    {
        return [
            "userSectionsId" => [
                self::FIELD_RELATION_TO_PARENT => "UserSectionModel"
            ],
            "operation"      => [
                self::FIELD_TYPE       => self::FIELD_TYPE_STRING,
                self::FIELD_VALIDATION => [
                    Validator::TYPE_REQUIRED,
                    Validator::TYPE_MAX_LENGTH => 50
                ],
            ],
        ];
    }
}