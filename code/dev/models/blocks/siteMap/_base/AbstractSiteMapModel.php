<?php

namespace ss\models\blocks\siteMap\_base;

use ss\application\components\valueGenerator\ValueGenerator;
use ss\models\_abstract\AbstractModel;

/**
 * Abstract model for working with table "siteMaps"
 */
abstract class AbstractSiteMapModel extends AbstractModel
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
                    => '\\ss\\models\\blocks\\block\\DesignBlockModel'
            ],
            'itemDesignBlockId'      => [
                self::FIELD_RELATION
                    => '\\ss\\models\\blocks\\block\\DesignBlockModel'
            ],
            'itemDesignTextId'       => [
                self::FIELD_RELATION
                    => '\\ss\\models\\blocks\\text\\DesignTextModel'
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
