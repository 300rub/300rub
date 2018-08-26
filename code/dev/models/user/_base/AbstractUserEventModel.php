<?php

namespace ss\models\user\_base;

use ss\application\components\common\Validator;
use ss\application\components\valueGenerator\ValueGenerator;
use ss\models\_abstract\AbstractModel;

/**
 * Abstract model for working with table "userEvents"
 */
abstract class AbstractUserEventModel extends AbstractModel
{

    /**
     * Categories
     */
    const CATEGORY_SECTION = 1;

    /**
     * Types
     */
    const TYPE_ADD = 1;
    const TYPE_EDIT = 2;
    const TYPE_DELETE = 3;

    /**
     * Category list
     *
     * @var array
     */
    public static $categoryList = [
        self::CATEGORY_SECTION => '',
    ];

    /**
     * Type list
     *
     * @var array
     */
    public static $typeList = [
        self::TYPE_ADD    => '',
        self::TYPE_EDIT   => '',
        self::TYPE_DELETE => '',
    ];

    /**
     * Gets table name
     *
     * @return string
     */
    public function getTableName()
    {
        return 'userEvents';
    }

    /**
     * Gets fields info
     *
     * @return array
     */
    public function getFieldsInfo()
    {
        return [
            'userId'       => [
                self::FIELD_RELATION_TO_PARENT
                    => '\\ss\\models\\user\\UserModel',
                self::FIELD_NOT_CHANGE_ON_UPDATE => true
            ],
            'category' => [
                self::FIELD_TYPE                 => self::FIELD_TYPE_INT,
                self::FIELD_VALUE                => [
                    ValueGenerator::ARRAY_KEY => [self::$categoryList]
                ],
            ],
            'type' => [
                self::FIELD_TYPE                 => self::FIELD_TYPE_INT,
                self::FIELD_VALUE                => [
                    ValueGenerator::ARRAY_KEY => [self::$typeList]
                ],
            ],
            'event'           => [
                self::FIELD_TYPE => self::FIELD_TYPE_STRING,
                self::FIELD_VALIDATION          => [
                    Validator::TYPE_REQUIRED,
                    Validator::TYPE_MAX_LENGTH => 255
                ],
                self::FIELD_VALUE               => [
                    ValueGenerator::CLEAR_STRIP_TAGS
                ],
            ],
            'date' => [
                self::FIELD_TYPE              => self::FIELD_TYPE_DATETIME,
                self::FIELD_CURRENT_DATE_TIME => true
            ],
        ];
    }
}
