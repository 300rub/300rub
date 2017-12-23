<?php

namespace testS\models\blocks\catalog\_abstract;

use testS\models\_abstract\AbstractModel;
use testS\application\components\ValueGenerator;

/**
 * Abstract model for working with table "designCatalogs"
 */
abstract class AbstractDesignCatalogModel extends AbstractModel
{

    /**
     * Short card view types
     */
    const SHORT_CART_VIEW_TYPE_LIST = 0;
    const SHORT_CART_VIEW_TYPE_GRID = 1;

    /**
     * Full card image positions
     */
    const FULL_CART_IMAGE_POSITION_LEFT = 0;
    const FULL_CART_IMAGE_POSITION_RIGHT = 1;

    /**
     * Full card date positions
     */
    const FULL_CART_DATE_POSITION_LEFT = 0;

    /**
     * Gets short card view type list
     *
     * @return array
     */
    public static function getShortCardViewTypeList()
    {
        return [
            self::SHORT_CART_VIEW_TYPE_LIST => '',
            self::SHORT_CART_VIEW_TYPE_GRID => ''
        ];
    }

    /**
     * Gets full card image position list
     *
     * @return array
     */
    public static function getFullCardImagesPositionList()
    {
        return [
            self::FULL_CART_IMAGE_POSITION_LEFT  => '',
            self::FULL_CART_IMAGE_POSITION_RIGHT => ''
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
            self::FULL_CART_DATE_POSITION_LEFT => ''
        ];
    }

    /**
     * Gets table name
     *
     * @return string
     */
    public function getTableName()
    {
        return 'designCatalogs';
    }

    /**
     * Gets fields info
     *
     * @return array
     */
    public function getFieldsInfo()
    {
        return array_merge(
            $this->_getShortCardFieldsInfo(),
            $this->_getFullCardFieldsInfo()
        );
    }

    /**
     * Gets short card fields info
     *
     * @return array
     */
    private function _getShortCardFieldsInfo()
    {
        return [
            'shortCardContainerDesignBlockId'      => [
                self::FIELD_RELATION => 'DesignBlockModel'
            ],
            'shortCardInstanceDesignBlockId'       => [
                self::FIELD_RELATION => 'DesignBlockModel'
            ],
            'shortCardTitleDesignBlockId'          => [
                self::FIELD_RELATION => 'DesignBlockModel'
            ],
            'shortCardTitleDesignTextId'           => [
                self::FIELD_RELATION => 'DesignTextModel'
            ],
            'shortCardDateDesignTextId'            => [
                self::FIELD_RELATION => 'DesignTextModel'
            ],
            'shortCardPriceDesignBlockId'          => [
                self::FIELD_RELATION => 'DesignBlockModel'
            ],
            'shortCardPriceDesignTextId'           => [
                self::FIELD_RELATION => 'DesignTextModel'
            ],
            'shortCardOldPriceDesignBlockId'       => [
                self::FIELD_RELATION => 'DesignBlockModel'
            ],
            'shortCardOldPriceDesignTextId'        => [
                self::FIELD_RELATION => 'DesignTextModel'
            ],
            'shortCardDescriptionDesignBlockId'    => [
                self::FIELD_RELATION => 'DesignBlockModel'
            ],
            'shortCardDescriptionDesignTextId'     => [
                self::FIELD_RELATION => 'DesignTextModel'
            ],
            'shortCardPaginationDesignBlockId'     => [
                self::FIELD_RELATION => 'DesignBlockModel'
            ],
            'shortCardPaginationItemDesignBlockId' => [
                self::FIELD_RELATION => 'DesignBlockModel'
            ],
            'shortCardPaginationItemDesignTextId'  => [
                self::FIELD_RELATION => 'DesignTextModel'
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
        ];
    }

    /**
     * Gets full card fields info
     *
     * @return array
     */
    private function _getFullCardFieldsInfo()
    {
        return [
            'fullCardContainerDesignBlockId' => [
                self::FIELD_RELATION => 'DesignBlockModel'
            ],
            'fullCardTitleDesignBlockId'     => [
                self::FIELD_RELATION => 'DesignBlockModel'
            ],
            'fullCardTitleDesignTextId'      => [
                self::FIELD_RELATION => 'DesignTextModel'
            ],
            'fullCardDateDesignTextId'       => [
                self::FIELD_RELATION => 'DesignTextModel'
            ],
            'fullCardPriceDesignBlockId'     => [
                self::FIELD_RELATION => 'DesignBlockModel'
            ],
            'fullCardPriceDesignTextId'      => [
                self::FIELD_RELATION => 'DesignTextModel'
            ],
            'fullCardOldPriceDesignBlockId'  => [
                self::FIELD_RELATION => 'DesignBlockModel'
            ],
            'fullCardOldPriceDesignTextId'   => [
                self::FIELD_RELATION => 'DesignTextModel'
            ],
            'fullCardBinButtonDesignBlockId' => [
                self::FIELD_RELATION => 'DesignBlockModel'
            ],
            'fullCardBinButtonDesignTextId'  => [
                self::FIELD_RELATION => 'DesignTextModel'
            ],
            'fullCardImagesPosition'         => [
                self::FIELD_TYPE  => self::FIELD_TYPE_INT,
                self::FIELD_VALUE => [
                    ValueGenerator::ARRAY_KEY => [
                        self::getFullCardImagesPositionList(),
                        self::FULL_CART_IMAGE_POSITION_LEFT
                    ]
                ],
            ],
            'fullCardDatePosition'           => [
                self::FIELD_TYPE  => self::FIELD_TYPE_INT,
                self::FIELD_VALUE => [
                    ValueGenerator::ARRAY_KEY => [
                        self::getFullCardImagesPositionList(),
                        self::FULL_CART_DATE_POSITION_LEFT
                    ]
                ],
            ],
        ];
    }
}
