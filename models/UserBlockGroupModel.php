<?php

namespace testS\models;

use testS\components\exceptions\ModelException;
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
                self::FIELD_TYPE => self::FIELD_TYPE_INT,
                self::FIELD_BEFORE_SAVE => "checkUserId"
            ],
            "blockType"   => [
                self::FIELD_TYPE => self::FIELD_TYPE_INT,
                self::FIELD_VALUE => [
                    ValueGenerator::TYPE_ARRAY_KEY => [BlockModel::$typeList]
                ],
            ],
        ];
    }

    /**
     * Checks user ID
     *
     * @param int $value
     *
     * @throws ModelException
     */
    protected function checkUserId($value)
    {
        if ($value === 0) {
            throw new ModelException("Unable to save UserBlockGroupModel because userId is null");
        }

        $className = "\\testS\\models\\UserModel";
        $model = new $className;
        if (!$model instanceof AbstractModel
            || !$model->byId($value)->find() instanceof UserModel
        ) {
            throw new ModelException(
                "Unable to find model: UserBlockGroupModel with ID = {id}",
                [
                    "id" => $value
                ]
            );
        }
    }
}