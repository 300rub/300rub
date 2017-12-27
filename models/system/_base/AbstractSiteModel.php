<?php

namespace testS\models\system\_base;

use testS\application\App;
use testS\application\components\Validator;
use testS\application\components\ValueGenerator;
use testS\models\system\_abstract\AbstractSystemModel;

/**
 * Abstract model for working with table "sites"
 */
abstract class AbstractSiteModel extends AbstractSystemModel
{

    /**
     * Gets table name
     *
     * @return string
     */
    public function getTableName()
    {
        return 'sites';
    }

    /**
     * Gets fields info
     *
     * @return array
     */
    public function getFieldsInfo()
    {
        $language = App::getInstance()->getLanguage();

        return [
            'host'        => [
                self::FIELD_TYPE                => self::FIELD_TYPE_STRING,
                self::FIELD_VALIDATION          => [
                    Validator::TYPE_REQUIRED,
                    Validator::TYPE_MAX_LENGTH => 255
                ],
                self::FIELD_VALUE               => [
                    ValueGenerator::CLEAR_STRIP_TAGS
                ],
                self::FIELD_SKIP_DUPLICATION => true,
                self::FIELD_UNIQUE           => true
            ],
            'dbHost'        => [
                self::FIELD_TYPE                => self::FIELD_TYPE_STRING,
                self::FIELD_VALIDATION          => [
                    Validator::TYPE_REQUIRED,
                    Validator::TYPE_MAX_LENGTH => 255
                ],
                self::FIELD_VALUE               => [
                    ValueGenerator::CLEAR_STRIP_TAGS
                ],
                self::FIELD_SKIP_DUPLICATION => true
            ],
            'dbUser'        => [
                self::FIELD_TYPE                => self::FIELD_TYPE_STRING,
                self::FIELD_VALIDATION          => [
                    Validator::TYPE_REQUIRED,
                    Validator::TYPE_MAX_LENGTH => 255
                ],
                self::FIELD_VALUE               => [
                    ValueGenerator::CLEAR_STRIP_TAGS
                ],
                self::FIELD_SKIP_DUPLICATION => true
            ],
            'dbPassword'        => [
                self::FIELD_TYPE                => self::FIELD_TYPE_STRING,
                self::FIELD_VALIDATION          => [
                    Validator::TYPE_REQUIRED,
                    Validator::TYPE_MAX_LENGTH => 255
                ],
                self::FIELD_VALUE               => [
                    ValueGenerator::CLEAR_STRIP_TAGS
                ],
                self::FIELD_SKIP_DUPLICATION => true
            ],
            'dbName'        => [
                self::FIELD_TYPE                => self::FIELD_TYPE_STRING,
                self::FIELD_VALIDATION          => [
                    Validator::TYPE_REQUIRED,
                    Validator::TYPE_MAX_LENGTH => 255
                ],
                self::FIELD_VALUE               => [
                    ValueGenerator::CLEAR_STRIP_TAGS
                ],
                self::FIELD_SKIP_DUPLICATION => true
            ],
            'language'    => [
                self::FIELD_TYPE                 => self::FIELD_TYPE_INT,
                self::FIELD_VALUE                => [
                    ValueGenerator::ARRAY_KEY => [
                        $language->getAliasList(),
                        $language->getActiveId()
                    ]
                ],
                self::FIELD_NOT_CHANGE_ON_UPDATE => true,
            ],
            'email'        => [
                self::FIELD_TYPE                 => self::FIELD_TYPE_STRING,
                self::FIELD_VALIDATION           => [
                    Validator::TYPE_EMAIL
                ],
                self::FIELD_SKIP_DUPLICATION     => true,
                self::FIELD_UNIQUE               => true
            ],
        ];
    }
}
