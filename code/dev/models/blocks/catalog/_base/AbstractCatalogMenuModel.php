<?php

namespace ss\models\blocks\catalog\_base;

use ss\application\components\common\Validator;

use ss\application\components\valueGenerator\ValueGenerator;
use ss\models\_abstract\AbstractModel;

/**
 * Abstract model for working with table "catalogMenu"
 */
abstract class AbstractCatalogMenuModel extends AbstractModel
{

    /**
     * Gets table name
     *
     * @return string
     */
    public function getTableName()
    {
        return 'catalogMenu';
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
                    => '\\ss\\models\\blocks\\catalog\\CatalogMenuModel',
                self::FIELD_ALLOW_NULL         => true,
            ],
            'seoId'     => [
                self::FIELD_RELATION
                    => '\\ss\\models\\sections\\SeoModel'
            ],
            'catalogId' => [
                self::FIELD_RELATION_TO_PARENT
                    => '\\ss\\models\\blocks\\catalog\\CatalogModel'
            ],
            'icon'      => [
                self::FIELD_TYPE       => self::FIELD_TYPE_STRING,
                self::FIELD_VALIDATION => [
                    Validator::TYPE_MAX_LENGTH => 50,
                ],
                self::FIELD_VALUE      => [
                    ValueGenerator::CLEAR_STRIP_TAGS
                ],
            ],
            'subName'   => [
                self::FIELD_TYPE       => self::FIELD_TYPE_STRING,
                self::FIELD_VALIDATION => [
                    Validator::TYPE_MAX_LENGTH => 255,
                ],
                self::FIELD_VALUE      => [
                    ValueGenerator::CLEAR_STRIP_TAGS
                ],
            ],
        ];
    }
}
