<?php

namespace ss\models\blocks\catalog\_base;

use ss\application\components\common\Validator;

use ss\application\components\valueGenerator\ValueGenerator;
use ss\models\_abstract\AbstractModel;

/**
 * Abstract model for working with table "catalogs"
 */
abstract class AbstractCatalogModel extends AbstractModel
{

    /**
     * Short date types
     */
    const DATE_TYPE_COMMON = 0;
    const DATE_TYPE_1 = 1;

    /**
     * Gets date type list
     *
     * @return array
     */
    public static function getDateTypeList()
    {
        return [
            self::DATE_TYPE_COMMON => '',
            self::DATE_TYPE_1      => ''
        ];
    }

    /**
     * Gets table name
     *
     * @return string
     */
    public function getTableName()
    {
        return 'catalogs';
    }

    /**
     * Gets fields info
     *
     * @return array
     */
    public function getFieldsInfo()
    {
        return [
            'imageId'            => [
                self::FIELD_RELATION
                    => '\\ss\\models\\blocks\\image\\ImageModel'
            ],
            'tabId'              => [
                self::FIELD_RELATION
                    => '\\ss\\models\\blocks\\helpers\\tab\\TabModel'
            ],
            'fieldId'            => [
                self::FIELD_RELATION
                    => '\\ss\\models\\blocks\\helpers\\field\\FieldModel'
            ],
            'descriptionTextId'  => [
                self::FIELD_RELATION
                    => '\\ss\\models\\blocks\\text\\TextModel'
            ],
            'designCatalogId'    => [
                self::FIELD_RELATION
                    => '\\ss\\models\\blocks\\catalog\\DesignCatalogModel'
            ],
            'hasImages'          => [
                self::FIELD_TYPE => self::FIELD_TYPE_BOOL
            ],
            'useAutoload'        => [
                self::FIELD_TYPE => self::FIELD_TYPE_BOOL
            ],
            'pageNavigationSize' => [
                self::FIELD_TYPE => self::FIELD_TYPE_INT,
            ],
            'shortCardDateType'  => [
                self::FIELD_TYPE  => self::FIELD_TYPE_INT,
                self::FIELD_VALUE => [
                    ValueGenerator::ARRAY_KEY => [
                        self::getDateTypeList(),
                        self::DATE_TYPE_COMMON
                    ]
                ],
            ],
            'fullCardDateType'   => [
                self::FIELD_TYPE  => self::FIELD_TYPE_INT,
                self::FIELD_VALUE => [
                    ValueGenerator::ARRAY_KEY => [
                        self::getDateTypeList(),
                        self::DATE_TYPE_COMMON
                    ]
                ],
            ],
            'hasRelations'       => [
                self::FIELD_TYPE => self::FIELD_TYPE_BOOL
            ],
            'relationsLabel'     => [
                self::FIELD_TYPE       => self::FIELD_TYPE_STRING,
                self::FIELD_VALIDATION => [
                    Validator::TYPE_MAX_LENGTH => 255,
                ],
                self::FIELD_VALUE      => [
                    ValueGenerator::CLEAR_STRIP_TAGS
                ],
            ],
            'hasBin'             => [
                self::FIELD_TYPE => self::FIELD_TYPE_BOOL
            ],
        ];
    }
}
