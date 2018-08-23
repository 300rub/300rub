<?php

namespace ss\models\help\_base;

use ss\application\components\Validator;

use ss\models\help\_abstract\AbstractModel;

/**
 * Abstract model for working with table "categories" (help DB)
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
        return 'categories';
    }

    /**
     * Gets fields info
     *
     * @return array
     */
    public function getFieldsInfo()
    {
        return [
            'parentId'  => [
                self::FIELD_RELATION_TO_PARENT
                => '\\ss\\models\\help\\CategoryModel',
                self::FIELD_ALLOW_NULL         => true,
                self::FIELD_SKIP_DUPLICATION   => true,
            ],
            'alias'         => [
                self::FIELD_TYPE                => self::FIELD_TYPE_STRING,
                self::FIELD_VALIDATION          => [
                    Validator::TYPE_REQUIRED,
                    Validator::TYPE_ALIAS,
                    Validator::TYPE_MAX_LENGTH => 50
                ],
                self::FIELD_VALUE               => [
                    ValueGenerator::CLEAR_STRIP_TAGS,
                ],
            ],
        ];
    }
}
