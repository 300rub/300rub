<?php

namespace ss\models\system\_base;

use ss\application\components\common\Validator;
use ss\application\components\valueGenerator\ValueGenerator;
use ss\models\_abstract\AbstractModel;

/**
 * Abstract model for working with table "migrations"
 */
abstract class AbstractMigrationModel extends AbstractModel
{

    /**
     * Gets table name
     *
     * @return string
     */
    public function getTableName()
    {
        return 'migrations';
    }

    /**
     * Gets fields info
     *
     * @return array
     */
    public function getFieldsInfo()
    {
        return [
            'version'   => [
                self::FIELD_TYPE                => self::FIELD_TYPE_STRING,
                self::FIELD_VALIDATION          => [
                    Validator::TYPE_REQUIRED,
                    Validator::TYPE_MAX_LENGTH => 100
                ],
                self::FIELD_VALUE               => [
                    ValueGenerator::CLEAR_STRIP_TAGS
                ],
            ],
            'up' => [
                self::FIELD_TYPE => self::FIELD_TYPE_STRING,
            ],
            'down' => [
                self::FIELD_TYPE => self::FIELD_TYPE_STRING,
            ]
        ];
    }
}
