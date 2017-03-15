<?php

namespace testS\models;

use testS\components\Operation;
use testS\components\Validator;
use testS\components\ValueGenerator;

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
            "userId" => [
                self::FIELD_RELATION_TO_PARENT   => "UserModel",
                self::FIELD_SKIP_DUPLICATION     => true,
                self::FIELD_NOT_CHANGE_ON_UPDATE => true,
            ],
            "blockId" => [
                self::FIELD_RELATION_TO_PARENT => "BlockModel",
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
}