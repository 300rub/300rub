<?php

namespace ss\models\user\_base;

use ss\application\App;

use ss\models\_abstract\AbstractModel;

/**
 * Abstract model for working with table "userSectionGroupOperations"
 */
abstract class AbstractUserSectionGroupOperationModel extends AbstractModel
{

    /**
     * Gets table name
     *
     * @return string
     */
    public function getTableName()
    {
        return 'userSectionGroupOperations';
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
            'operation'          => [
                self::FIELD_TYPE       => self::FIELD_TYPE_STRING,
                self::FIELD_VALUE                => [
                    ValueGenerator::ARRAY_KEY => [
                        App::getInstance()
                            ->getOperation()
                            ->getSectionOperations(true)
                    ]
                ],
                self::FIELD_NOT_CHANGE_ON_UPDATE => true,
            ],

        ];
    }
}
