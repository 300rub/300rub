<?php

namespace testS\models\blocks\siteMap\_base;

use testS\application\components\ValueGenerator;
use testS\models\blocks\siteMap\_abstract\AbstractSiteMapModel as Model;

/**
 * Abstract model for working with table "siteMaps"
 */
abstract class AbstractSiteMapModel extends Model
{

    /**
     * Styles
     */
    const STYLE_COMMON = 0;
    const STYLE_ONE = 1;

    /**
     * Gets a list of types
     *
     * @return array
     */
    public static function getStyleList()
    {
        return [
            self::STYLE_COMMON => '',
            self::STYLE_ONE    => '',
        ];
    }

    /**
     * Gets table name
     *
     * @return string
     */
    public function getTableName()
    {
        return 'siteMaps';
    }

    /**
     * Gets fields info
     *
     * @return array
     */
    public function getFieldsInfo()
    {
        return [
            'containerDesignBlockId' => [
                self::FIELD_RELATION
                    => '\\testS\\models\\blocks\\block\\DesignBlockModel'
            ],
            'itemDesignBlockId'      => [
                self::FIELD_RELATION
                    => '\\testS\\models\\blocks\\block\\DesignBlockModel'
            ],
            'itemDesignTextId'       => [
                self::FIELD_RELATION
                    => '\\testS\\models\\blocks\\text\\DesignTextModel'
            ],
            'style'                  => [
                self::FIELD_TYPE  => self::FIELD_TYPE_INT,
                self::FIELD_VALUE => [
                    ValueGenerator::ARRAY_KEY => [
                        self::getStyleList(),
                        self::STYLE_COMMON
                    ]
                ],
            ],
        ];
    }
}
