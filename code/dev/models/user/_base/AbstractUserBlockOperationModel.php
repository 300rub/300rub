<?php

namespace ss\models\user\_base;

use ss\application\App;

use ss\models\_abstract\AbstractModel;
use ss\models\blocks\block\BlockModel;

/**
 * Abstract model for working with table "userBlockOperations"
 */
abstract class AbstractUserBlockOperationModel extends AbstractModel
{

    /**
     * Gets table name
     *
     * @return string
     */
    public function getTableName()
    {
        return 'userBlockOperations';
    }

    /**
     * Gets fields info
     *
     * @return array
     */
    public function getFieldsInfo()
    {
        return [
            'userId' => [
                self::FIELD_RELATION_TO_PARENT
                    => '\\ss\\models\\user\\UserModel',
                self::FIELD_SKIP_DUPLICATION     => true,
                self::FIELD_NOT_CHANGE_ON_UPDATE => true,
            ],
            'blockId' => [
                self::FIELD_RELATION_TO_PARENT
                    => '\\ss\\models\\blocks\\block\\BlockModel',
                self::FIELD_SKIP_DUPLICATION     => true,
                self::FIELD_NOT_CHANGE_ON_UPDATE => true,
            ],
            'blockType' => [
                self::FIELD_TYPE  => self::FIELD_TYPE_INT,
                self::FIELD_VALUE => [
                    ValueGenerator::ARRAY_KEY => [BlockModel::$typeList]
                ],
                self::FIELD_NOT_CHANGE_ON_UPDATE => true,
            ],
            'operation'        => [
                self::FIELD_TYPE       => self::FIELD_TYPE_STRING,
                self::FIELD_BEFORE_SAVE => ['setOperationBeforeSave'],
                self::FIELD_NOT_CHANGE_ON_UPDATE => true,
            ],
        ];
    }

    /**
     * Sets operation before save
     *
     * @param string $value Operation value
     *
     * @return string
     */
    protected function setOperationBeforeSave($value)
    {
        return ValueGenerator::factory(
            ValueGenerator::ARRAY_KEY,
            $value,
            [
                App::getInstance()
                    ->getOperation()
                    ->getOperationsByContentType(
                        $this->get('blockType'),
                        false
                    )
            ]
        )->generate();
    }
}
