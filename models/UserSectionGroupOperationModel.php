<?php

namespace testS\models;

use testS\components\Db;
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
            "userId" => [
                self::FIELD_RELATION_TO_PARENT => "UserModel"
            ],
            "operation"          => [
                self::FIELD_TYPE       => self::FIELD_TYPE_STRING,
                self::FIELD_VALIDATION => [
                    Validator::TYPE_REQUIRED,
                    Validator::TYPE_MAX_LENGTH => 50
                ],
            ],
        ];
    }

    /**
     * Adds userId condition to SQL request
     *
     * @param int $userId
     *
     * @return UserSectionGroupOperationModel
     */
    public function byUserId($userId)
    {
        $this->getDb()->addWhere(sprintf("%s.userId = :userId", Db::DEFAULT_ALIAS));
        $this->getDb()->addParameter("userId", $userId);

        return $this;
    }
}