<?php

namespace ss\models\blocks\record\_base;

use ss\application\components\ValueGenerator;
use ss\models\_abstract\AbstractModel;

/**
 * Abstract model for working with table "designRecords"
 */
abstract class AbstractDesignRecordModel extends AbstractModel
{

    /**
     * Short card view types
     */
    const SHORT_CART_VIEW_TYPE_LIST = 0;
    const SHORT_CART_VIEW_TYPE_GRID_1 = 1;
    const SHORT_CART_VIEW_TYPE_GRID_2 = 2;
    const SHORT_CART_VIEW_TYPE_GRID_3 = 3;

    /**
     * Full card date positions
     */
    const FULL_CART_DATE_POSITION_NONE = 0;
    const FULL_CART_DATE_POSITION_LEFT = 1;
    const FULL_CART_DATE_POSITION_RIGHT = 2;

    /**
     * Gets short card view type list
     *
     * @return array
     */
    public static function getShortCardViewTypeList()
    {
        return [
            self::SHORT_CART_VIEW_TYPE_LIST   => '',
            self::SHORT_CART_VIEW_TYPE_GRID_1 => '',
            self::SHORT_CART_VIEW_TYPE_GRID_2 => '',
            self::SHORT_CART_VIEW_TYPE_GRID_3 => '',
        ];
    }

    /**
     * Gets full card date position list
     *
     * @return array
     */
    public static function getFullCardDatePositionList()
    {
        return [
            self::FULL_CART_DATE_POSITION_NONE  => '',
            self::FULL_CART_DATE_POSITION_LEFT  => '',
            self::FULL_CART_DATE_POSITION_RIGHT => '',
        ];
    }

    /**
     * Gets table name
     *
     * @return string
     */
    public function getTableName()
    {
        return 'designRecords';
    }

    /**
     * Gets fields info
     *
     * @return array
     */
    public function getFieldsInfo()
    {
        return [
            'shortCardContainerDesignBlockId'      => [
                self::FIELD_RELATION
                    => '\\ss\\models\\blocks\\block\\DesignBlockModel'
            ],
            'shortCardInstanceDesignBlockId'       => [
                self::FIELD_RELATION
                    => '\\ss\\models\\blocks\\block\\DesignBlockModel'
            ],
            'shortCardTitleDesignBlockId'          => [
                self::FIELD_RELATION
                    => '\\ss\\models\\blocks\\block\\DesignBlockModel'
            ],
            'shortCardTitleDesignTextId'           => [
                self::FIELD_RELATION
                    => '\\ss\\models\\blocks\\text\\DesignTextModel'
            ],
            'shortCardDateDesignTextId'            => [
                self::FIELD_RELATION
                    => '\\ss\\models\\blocks\\text\\DesignTextModel'
            ],
            'shortCardDescriptionDesignBlockId'    => [
                self::FIELD_RELATION
                    => '\\ss\\models\\blocks\\block\\DesignBlockModel'
            ],
            'shortCardDescriptionDesignTextId'     => [
                self::FIELD_RELATION
                    => '\\ss\\models\\blocks\\text\\DesignTextModel'
            ],
            'shortCardPaginationDesignBlockId'     => [
                self::FIELD_RELATION
                    => '\\ss\\models\\blocks\\block\\DesignBlockModel'
            ],
            'shortCardPaginationItemDesignBlockId' => [
                self::FIELD_RELATION
                    => '\\ss\\models\\blocks\\block\\DesignBlockModel'
            ],
            'shortCardPaginationItemDesignTextId'  => [
                self::FIELD_RELATION
                    => '\\ss\\models\\blocks\\text\\DesignTextModel'
            ],
            'fullCardTitleDesignBlockId'           => [
                self::FIELD_RELATION
                    => '\\ss\\models\\blocks\\block\\DesignBlockModel'
            ],
            'fullCardTitleDesignTextId'            => [
                self::FIELD_RELATION
                    => '\\ss\\models\\blocks\\text\\DesignTextModel'
            ],
            'fullCardDateDesignBlockId'             => [
                self::FIELD_RELATION
                    => '\\ss\\models\\blocks\\block\\DesignBlockModel'
            ],
            'fullCardDateDesignTextId'             => [
                self::FIELD_RELATION
                    => '\\ss\\models\\blocks\\text\\DesignTextModel'
            ],
            'fullCardTextDesignBlockId'             => [
                self::FIELD_RELATION
                => '\\ss\\models\\blocks\\block\\DesignBlockModel'
            ],
            'shortCardViewType'                    => [
                self::FIELD_TYPE  => self::FIELD_TYPE_INT,
                self::FIELD_VALUE => [
                    ValueGenerator::ARRAY_KEY => [
                        self::getShortCardViewTypeList(),
                        self::SHORT_CART_VIEW_TYPE_LIST
                    ]
                ],
            ],
            'fullCardDatePosition'          => [
                self::FIELD_TYPE  => self::FIELD_TYPE_INT,
                self::FIELD_VALUE => [
                    ValueGenerator::ARRAY_KEY => [
                        self::getFullCardDatePositionList(),
                        self::FULL_CART_DATE_POSITION_NONE
                    ]
                ],
            ],
        ];
    }
}
