<?php

namespace ss\models\help\_base;

use ss\application\App;
use ss\application\components\Validator;
use ss\application\components\ValueGenerator;
use ss\models\_abstract\AbstractModel;

/**
 * Abstract model for working with table "category" (help DB)
 */
abstract class AbstractCategoryModel extends AbstractModel
{

    /**
     * Gets table name
     *
     * @return string
     */
    public function getTableName()
    {
        return 'category';
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
            'parentId'  => [
                self::FIELD_RELATION_TO_PARENT
                => '\\ss\\models\\help\\CategoryModel',
                self::FIELD_ALLOW_NULL         => true,
                self::FIELD_SKIP_DUPLICATION   => true,
            ],
            'language'      => [
                self::FIELD_TYPE  => self::FIELD_TYPE_INT,
                self::FIELD_VALUE => [
                    ValueGenerator::ARRAY_KEY => [
                        $language->getAliasList(),
                        $language->getActiveId()
                    ]
                ],
            ],
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
            'text'          => [
                self::FIELD_TYPE => self::FIELD_TYPE_STRING
            ],
            'alias'         => [
                self::FIELD_TYPE                => self::FIELD_TYPE_STRING,
                self::FIELD_VALIDATION          => [
                    Validator::TYPE_REQUIRED,
                    Validator::TYPE_URL,
                    Validator::TYPE_MAX_LENGTH => 50
                ],
                self::FIELD_VALUE               => [
                    ValueGenerator::CLEAR_STRIP_TAGS,
                    ValueGenerator::URL => '{name}'
                ],
                self::FIELD_CHANGE_ON_DUPLICATE => [
                    ValueGenerator::COPY_URL
                ]
            ],
            'title'       => [
                self::FIELD_TYPE             => self::FIELD_TYPE_STRING,
                self::FIELD_VALIDATION       => [
                    Validator::TYPE_MAX_LENGTH => 100
                ],
                self::FIELD_VALUE            => [
                    ValueGenerator::CLEAR_STRIP_TAGS,
                ],
                self::FIELD_SKIP_DUPLICATION => true,
            ],
            'keywords'    => [
                self::FIELD_TYPE             => self::FIELD_TYPE_STRING,
                self::FIELD_VALIDATION       => [
                    Validator::TYPE_MAX_LENGTH => 255
                ],
                self::FIELD_VALUE            => [
                    ValueGenerator::CLEAR_STRIP_TAGS,
                ],
                self::FIELD_SKIP_DUPLICATION => true,
            ],
            'description' => [
                self::FIELD_TYPE             => self::FIELD_TYPE_STRING,
                self::FIELD_VALIDATION       => [
                    Validator::TYPE_MAX_LENGTH => 255
                ],
                self::FIELD_VALUE            => [
                    ValueGenerator::CLEAR_STRIP_TAGS,
                ],
                self::FIELD_SKIP_DUPLICATION => true,
            ],
        ];
    }
}
