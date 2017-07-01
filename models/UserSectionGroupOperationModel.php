<?php

namespace testS\models;

use testS\components\Db;
use testS\components\Operation;
use testS\components\Validator;
use testS\components\ValueGenerator;

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
                self::FIELD_RELATION_TO_PARENT => "UserModel",
                self::FIELD_SKIP_DUPLICATION     => true,
                self::FIELD_NOT_CHANGE_ON_UPDATE => true,
            ],
            "operation"          => [
                self::FIELD_TYPE       => self::FIELD_TYPE_STRING,
                self::FIELD_VALUE                => [
                    ValueGenerator::ARRAY_KEY => [Operation::getSectionOperations()]
                ],
                self::FIELD_NOT_CHANGE_ON_UPDATE => true,
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