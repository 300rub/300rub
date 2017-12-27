<?php

namespace testS\models\blocks\menu\_base;

use testS\application\components\Validator;
use testS\application\components\ValueGenerator;
use testS\models\blocks\menu\_abstract\AbstractMenuModel;

/**
 * Abstract model for working with table "menuInstances"
 */
abstract class AbstractMenuInstanceModel extends AbstractMenuModel
{

    /**
     * Gets table name
     *
     * @return string
     */
    public function getTableName()
    {
        return 'menuInstances';
    }

    /**
     * Gets fields info
     *
     * @return array
     */
    public function getFieldsInfo()
    {
        return [
            'menuId'    => [
                self::FIELD_RELATION_TO_PARENT
                    => '\\testS\\models\\blocks\\menu\\MenuModel',
                self::FIELD_SKIP_DUPLICATION     => true,
                self::FIELD_NOT_CHANGE_ON_UPDATE => true
            ],
            'parentId'  => [
                self::FIELD_RELATION_TO_PARENT
                    => '\\testS\\models\\blocks\\menu\\MenuInstanceModel',
                self::FIELD_ALLOW_NULL         => true,
                self::FIELD_SKIP_DUPLICATION   => true,
            ],
            'sectionId' => [
                self::FIELD_RELATION_TO_PARENT
                    => '\\testS\\\models\\\sections\\SectionModel'
            ],
            'icon'      => [
                self::FIELD_TYPE       => self::FIELD_TYPE_STRING,
                self::FIELD_VALIDATION => [
                    Validator::TYPE_MAX_LENGTH => 50
                ],
                self::FIELD_VALUE      => [
                    ValueGenerator::CLEAR_STRIP_TAGS
                ],
            ],
            'subName'   => [
                self::FIELD_TYPE       => self::FIELD_TYPE_STRING,
                self::FIELD_VALIDATION => [
                    Validator::TYPE_MAX_LENGTH => 255
                ],
                self::FIELD_VALUE      => [
                    ValueGenerator::CLEAR_STRIP_TAGS
                ],
            ],
            'sort'      => [
                self::FIELD_TYPE => self::FIELD_TYPE_INT
            ],
        ];
    }
}
