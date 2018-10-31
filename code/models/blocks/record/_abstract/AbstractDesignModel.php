<?php

namespace ss\models\blocks\record\_abstract;

use ss\models\_abstract\AbstractModel;

/**
 * Abstract model for working with design
 */
abstract class AbstractDesignModel extends AbstractModel
{

    /**
     * Short card view types
     */
    const SHORT_CART_VIEW_TYPE_LIST = 0;
    const SHORT_CART_VIEW_TYPE_GRID_1 = 1;
    const SHORT_CART_VIEW_TYPE_GRID_2 = 2;
    const SHORT_CART_VIEW_TYPE_GRID_3 = 3;

    /**
     * Gets short card view type list
     *
     * @return array
     */
    public function getShortCardViewTypeList()
    {
        return [
            self::SHORT_CART_VIEW_TYPE_LIST   => '',
            self::SHORT_CART_VIEW_TYPE_GRID_1 => '',
            self::SHORT_CART_VIEW_TYPE_GRID_2 => '',
            self::SHORT_CART_VIEW_TYPE_GRID_3 => '',
        ];
    }

    /**
     * CSS type list
     *
     * @var array
     */
    protected $viewTypeCssList = [
        self::SHORT_CART_VIEW_TYPE_LIST   => 'view-list',
        self::SHORT_CART_VIEW_TYPE_GRID_1 => 'view-grid-1',
        self::SHORT_CART_VIEW_TYPE_GRID_2 => 'view-grid-2',
        self::SHORT_CART_VIEW_TYPE_GRID_3 => 'view-grid-3',
    ];

    /**
     * Gets type CSS
     *
     * @param int $type View type
     *
     * @return string
     */
    public function getViewTypeCss($type)
    {
        if (array_key_exists($type, $this->viewTypeCssList) === true) {
            return $this->viewTypeCssList[$type];
        }

        return $this->viewTypeCssList[self::SHORT_CART_VIEW_TYPE_LIST];
    }
}
