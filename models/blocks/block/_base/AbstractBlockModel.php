<?php

namespace testS\models\blocks\block\_base;

use testS\application\App;
use testS\application\components\Validator;
use testS\application\components\ValueGenerator;
use testS\models\blocks\block\_abstract\AbstractBlockModel as Model;

/**
 * Abstract model for working with table "blocks"
 */
abstract class AbstractBlockModel extends Model
{

    /**
     * Content types
     */
    const TYPE_TEXT = 1;
    const TYPE_IMAGE = 2;
    const TYPE_RECORD = 3;
    const TYPE_RECORD_CLONE = 4;

    /**
     * Type list
     *
     * @var array
     */
    public static $typeList = [
        self::TYPE_TEXT
            => '\\models\\blocks\\text\\TextModel',
        self::TYPE_IMAGE
            => '\\models\\blocks\\image\\ImageModel',
        self::TYPE_RECORD
            => '\\models\\blocks\\record\\RecordModel',
        self::TYPE_RECORD_CLONE
            => '\\models\\blocks\\record\\RecordCloneModel',
    ];

    /**
     * Gets table name
     *
     * @return string
     */
    public function getTableName()
    {
        return 'blocks';
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
            'name'        => [
                self::FIELD_TYPE                => self::FIELD_TYPE_STRING,
                self::FIELD_VALIDATION          => [
                    Validator::TYPE_REQUIRED,
                    Validator::TYPE_MAX_LENGTH => 255
                ],
                self::FIELD_VALUE               => [
                    ValueGenerator::CLEAR_STRIP_TAGS
                ],
                self::FIELD_CHANGE_ON_DUPLICATE => [
                    ValueGenerator::COPY_NAME
                ],
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
            'contentType' => [
                self::FIELD_TYPE                 => self::FIELD_TYPE_INT,
                self::FIELD_VALUE                => [
                    ValueGenerator::ARRAY_KEY => [self::$typeList]
                ],
                self::FIELD_NOT_CHANGE_ON_UPDATE => true,
            ],
            'contentId'   => [
                self::FIELD_TYPE                 => self::FIELD_TYPE_INT,
                self::FIELD_BEFORE_SAVE          => [
                    'setContentIdBeforeSave'
                ],
                self::FIELD_BEFORE_DUPLICATE     => [
                    'setContentIdBeforeDuplicate'
                ],
                self::FIELD_NOT_CHANGE_ON_UPDATE => true,
            ],
        ];
    }
}
