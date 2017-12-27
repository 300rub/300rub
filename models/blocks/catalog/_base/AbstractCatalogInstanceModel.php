<?php

namespace testS\models\blocks\catalog\_base;

use testS\models\_abstract\AbstractModel;

/**
 * Abstract model for working with table "catalogInstances"
 */
abstract class AbstractCatalogInstanceModel extends AbstractModel
{

    /**
     * Short date types
     */
    const DATE_TYPE_COMMON = 0;

    /**
     * Gets date type list
     *
     * @return array
     */
    public static function getDateTypeList()
    {
        return [
            self::DATE_TYPE_COMMON => ''
        ];
    }

    /**
     * Gets table name
     *
     * @return string
     */
    public function getTableName()
    {
        return 'catalogInstances';
    }

    /**
     * Gets fields info
     *
     * @return array
     */
    public function getFieldsInfo()
    {
        return [
            'seoId'         => [
                self::FIELD_RELATION
                    => '\\testS\\models\\sections\\SeoModel',
                self::FIELD_SKIP_DUPLICATION => true,
            ],
            'tabGroupId'    => [
                self::FIELD_RELATION
                    => '\\testS\\models\\blocks\\helpers\\tab\\TabGroupModel',
                self::FIELD_SKIP_DUPLICATION => true,
            ],
            'imageGroupId'  => [
                self::FIELD_RELATION
                    => '\\testS\\models\\blocks\\image\\ImageGroupModel',
                self::FIELD_SKIP_DUPLICATION => true,
            ],
            'catalogMenuId' => [
                self::FIELD_RELATION_TO_PARENT
                    => '\\testS\\models\\blocks\\catalog\\CatalogMenuModel',
                self::FIELD_SKIP_DUPLICATION   => true,
            ],
            'fieldGroupId'  => [
                self::FIELD_RELATION
                    => '\\testS\\models\\blocks\\' .
                    'helpers\\field\\FieldGroupModel',
                self::FIELD_SKIP_DUPLICATION => true,
            ],
            'price'         => [
                self::FIELD_TYPE             => self::FIELD_TYPE_FLOAT,
                self::FIELD_SKIP_DUPLICATION => true,
            ],
            'oldPrice'      => [
                self::FIELD_TYPE             => self::FIELD_TYPE_FLOAT,
                self::FIELD_SKIP_DUPLICATION => true,
            ],
            'date'          => [
                self::FIELD_TYPE             => self::FIELD_TYPE_DATETIME,
                self::FIELD_SKIP_DUPLICATION => true,
            ],
        ];
    }
}
