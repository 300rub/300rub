<?php

namespace testS\models\user\_base;

use testS\application\App;
use testS\application\components\ValueGenerator;
use testS\models\user\_abstract\AbstractUserModel;

/**
 * Abstract model for working with table "userSectionGroupOperations"
 */
abstract class AbstractUserSectionGroupOperationModel extends AbstractUserModel
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
                self::FIELD_RELATION_TO_PARENT => 'UserModel',
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
