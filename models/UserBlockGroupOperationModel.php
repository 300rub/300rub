<?php

namespace testS\models;

use testS\components\Db;
use testS\components\Operation;
use testS\components\Validator;
use testS\components\ValueGenerator;

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
            "userId" => [
                self::FIELD_RELATION_TO_PARENT   => "UserModel",
                self::FIELD_SKIP_DUPLICATION     => true,
                self::FIELD_NOT_CHANGE_ON_UPDATE => true,
            ],
            "blockType" => [
                self::FIELD_TYPE  => self::FIELD_TYPE_INT,
                self::FIELD_VALUE => [
                    ValueGenerator::ARRAY_KEY => [BlockModel::$typeList]
                ],
                self::FIELD_NOT_CHANGE_ON_UPDATE => true,
            ],
            "operation"        => [
                self::FIELD_TYPE       => self::FIELD_TYPE_STRING,
                self::FIELD_BEFORE_SAVE => ["setOperationBeforeSave"],
                self::FIELD_NOT_CHANGE_ON_UPDATE => true,
            ],
        ];
    }

    /**
     * Seta operation before save
     *
     * @param string $value
     *
     * @return string
     */
    protected function setOperationBeforeSave($value)
    {
        return ValueGenerator::generate(
            ValueGenerator::ARRAY_KEY,
            $value,
            [Operation::getOperationsByContentType($this->get("blockType"))]
        );
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