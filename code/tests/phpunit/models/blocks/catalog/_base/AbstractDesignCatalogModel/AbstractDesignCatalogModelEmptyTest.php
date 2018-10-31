<?php

// @codingStandardsIgnoreLine
namespace ss\tests\phpunit\models\blocks\catalog\_base\AbstractDesignCatalogModel;

use ss\models\blocks\catalog\DesignCatalogModel;
use ss\tests\phpunit\models\_abstract\_base\AbstractEmptyModelTest;

/**
 * Tests for the model AbstractDesignCatalogModel
 */
class AbstractDesignCatalogModelEmptyTest extends AbstractEmptyModelTest
{

    /**
     * Gets model name
     *
     * @return DesignCatalogModel
     */
    protected function getNewModel()
    {
        return new DesignCatalogModel();
    }

    /**
     * Data provider for CRUD. Empty values
     *
     * @return array
     */
    protected function getDataProviderEmpty()
    {
        return [
            'empty1' => [
                [],
                $this->_createExpectedData1(),
                $this->_updateData1(),
                $this->_updateExpectedData1(),
            ],
            'empty2' => [
                $this->_createData2(),
                $this->_createExpectedData2(),
                $this->_updateData2(),
                $this->_updateExpectedData2(),
            ],
            'empty3' => [
                $this->_createData3(),
                $this->_createExpectedData3(),
                $this->_updateData3(),
                $this->_updateExpectedData3(),
            ],
            'empty4' => [
                $this->_createData4(),
                $this->_createExpectedData4(),
                $this->_updateData4(),
                $this->_updateExpectedData4(),
            ]
        ];
    }

    /**
     * Data provider for CRUD. Empty values
     *
     * @return array
     */
    private function _createExpectedData1()
    {
        return [
            'shortCardContainerDesignBlockModel'      => [
                'marginTop' => 0
            ],
            'shortCardInstanceDesignBlockModel'       => [
                'marginTop' => 0
            ],
            'shortCardTitleDesignBlockModel'          => [
                'marginTop' => 0
            ],
            'shortCardTitleDesignTextModel'           => [
                'size' => 0
            ],
            'shortCardDateDesignTextModel'            => [
                'size' => 0
            ],
            'shortCardPriceDesignBlockModel'          => [
                'marginTop' => 0
            ],
            'shortCardPriceDesignTextModel'           => [
                'size' => 0
            ],
            'shortCardOldPriceDesignBlockModel'       => [
                'marginTop' => 0
            ],
            'shortCardOldPriceDesignTextModel'        => [
                'size' => 0
            ],
            'shortCardDescriptionDesignBlockModel'    => [
                'marginTop' => 0
            ],
            'shortCardDescriptionDesignTextModel'     => [
                'size' => 0
            ],
            'shortCardPaginationDesignBlockModel'     => [
                'marginTop' => 0
            ],
            'shortCardPaginationItemDesignBlockModel' => [
                'marginTop' => 0
            ],
            'shortCardPaginationItemDesignTextModel'  => [
                'size' => 0
            ],
            'fullCardContainerDesignBlockModel'       => [
                'marginTop' => 0
            ],
            'fullCardTitleDesignBlockModel'           => [
                'marginTop' => 0
            ],
            'fullCardTitleDesignTextModel'            => [
                'size' => 0
            ],
            'fullCardDateDesignTextModel'             => [
                'size' => 0
            ],
            'fullCardPriceDesignBlockModel'           => [
                'marginTop' => 0
            ],
            'fullCardPriceDesignTextModel'            => [
                'size' => 0
            ],
            'fullCardOldPriceDesignBlockModel'        => [
                'marginTop' => 0
            ],
            'fullCardOldPriceDesignTextModel'         => [
                'size' => 0
            ],
            'fullCardBinButtonDesignBlockModel'       => [
                'marginTop' => 0
            ],
            'fullCardBinButtonDesignTextModel'        => [
                'size' => 0
            ],
            'shortCardViewType'                       => 0,
            'fullCardImagesPosition'                  => 0,
            'fullCardDatePosition'                    => 0
        ];
    }

    /**
     * Data provider for CRUD. Empty values
     *
     * @return array
     */
    private function _updateData1()
    {
        return [
            'shortCardContainerDesignBlockModel'      => '',
            'shortCardInstanceDesignBlockModel'       => '',
            'shortCardTitleDesignBlockModel'          => '',
            'shortCardTitleDesignTextModel'           => '',
            'shortCardDateDesignTextModel'            => '',
            'shortCardPriceDesignBlockModel'          => '',
            'shortCardPriceDesignTextModel'           => '',
            'shortCardOldPriceDesignBlockModel'       => '',
            'shortCardOldPriceDesignTextModel'        => '',
            'shortCardDescriptionDesignBlockModel'    => '',
            'shortCardDescriptionDesignTextModel'     => '',
            'shortCardPaginationDesignBlockModel'     => '',
            'shortCardPaginationItemDesignBlockModel' => '',
            'shortCardPaginationItemDesignTextModel'  => '',
            'fullCardContainerDesignBlockModel'       => '',
            'fullCardTitleDesignBlockModel'           => '',
            'fullCardTitleDesignTextModel'            => '',
            'fullCardDateDesignTextModel'             => '',
            'fullCardPriceDesignBlockModel'           => '',
            'fullCardPriceDesignTextModel'            => '',
            'fullCardOldPriceDesignBlockModel'        => '',
            'fullCardOldPriceDesignTextModel'         => '',
            'fullCardBinButtonDesignBlockModel'       => '',
            'fullCardBinButtonDesignTextModel'        => '',
            'shortCardViewType'                       => '',
            'fullCardImagesPosition'                  => '',
            'fullCardDatePosition'                    => ''
        ];
    }

    /**
     * Data provider for CRUD. Empty values
     *
     * @return array
     */
    private function _updateExpectedData1()
    {
        return [
            'shortCardContainerDesignBlockModel'      => [
                'marginTop' => 0
            ],
            'shortCardInstanceDesignBlockModel'       => [
                'marginTop' => 0
            ],
            'shortCardTitleDesignBlockModel'          => [
                'marginTop' => 0
            ],
            'shortCardTitleDesignTextModel'           => [
                'size' => 0
            ],
            'shortCardDateDesignTextModel'            => [
                'size' => 0
            ],
            'shortCardPriceDesignBlockModel'          => [
                'marginTop' => 0
            ],
            'shortCardPriceDesignTextModel'           => [
                'size' => 0
            ],
            'shortCardOldPriceDesignBlockModel'       => [
                'marginTop' => 0
            ],
            'shortCardOldPriceDesignTextModel'        => [
                'size' => 0
            ],
            'shortCardDescriptionDesignBlockModel'    => [
                'marginTop' => 0
            ],
            'shortCardDescriptionDesignTextModel'     => [
                'size' => 0
            ],
            'shortCardPaginationDesignBlockModel'     => [
                'marginTop' => 0
            ],
            'shortCardPaginationItemDesignBlockModel' => [
                'marginTop' => 0
            ],
            'shortCardPaginationItemDesignTextModel'  => [
                'size' => 0
            ],
            'fullCardContainerDesignBlockModel'       => [
                'marginTop' => 0
            ],
            'fullCardTitleDesignBlockModel'           => [
                'marginTop' => 0
            ],
            'fullCardTitleDesignTextModel'            => [
                'size' => 0
            ],
            'fullCardDateDesignTextModel'             => [
                'size' => 0
            ],
            'fullCardPriceDesignBlockModel'           => [
                'marginTop' => 0
            ],
            'fullCardPriceDesignTextModel'            => [
                'size' => 0
            ],
            'fullCardOldPriceDesignBlockModel'        => [
                'marginTop' => 0
            ],
            'fullCardOldPriceDesignTextModel'         => [
                'size' => 0
            ],
            'fullCardBinButtonDesignBlockModel'       => [
                'marginTop' => 0
            ],
            'fullCardBinButtonDesignTextModel'        => [
                'size' => 0
            ],
            'shortCardViewType'                       => 0,
            'fullCardImagesPosition'                  => 0,
            'fullCardDatePosition'                    => 0
        ];
    }

    /**
     * Data provider for CRUD. Empty values
     *
     * @return array
     */
    private function _createData2()
    {
        return [
            'shortCardContainerDesignBlockModel'      => null,
            'shortCardInstanceDesignBlockModel'       => null,
            'shortCardTitleDesignBlockModel'          => null,
            'shortCardTitleDesignTextModel'           => null,
            'shortCardDateDesignTextModel'            => null,
            'shortCardPriceDesignBlockModel'          => null,
            'shortCardPriceDesignTextModel'           => null,
            'shortCardOldPriceDesignBlockModel'       => null,
            'shortCardOldPriceDesignTextModel'        => null,
            'shortCardDescriptionDesignBlockModel'    => null,
            'shortCardDescriptionDesignTextModel'     => null,
            'shortCardPaginationDesignBlockModel'     => null,
            'shortCardPaginationItemDesignBlockModel' => null,
            'shortCardPaginationItemDesignTextModel'  => null,
            'fullCardContainerDesignBlockModel'       => null,
            'fullCardTitleDesignBlockModel'           => null,
            'fullCardTitleDesignTextModel'            => null,
            'fullCardDateDesignTextModel'             => null,
            'fullCardPriceDesignBlockModel'           => null,
            'fullCardPriceDesignTextModel'            => null,
            'fullCardOldPriceDesignBlockModel'        => null,
            'fullCardOldPriceDesignTextModel'         => null,
            'fullCardBinButtonDesignBlockModel'       => null,
            'fullCardBinButtonDesignTextModel'        => null,
            'shortCardViewType'                       => null,
            'fullCardImagesPosition'                  => null,
            'fullCardDatePosition'                    => null,
        ];
    }

    /**
     * Data provider for CRUD. Empty values
     *
     * @return array
     */
    private function _createExpectedData2()
    {
        return [
            'shortCardContainerDesignBlockModel'      => [
                'marginTop' => 0
            ],
            'shortCardInstanceDesignBlockModel'       => [
                'marginTop' => 0
            ],
            'shortCardTitleDesignBlockModel'          => [
                'marginTop' => 0
            ],
            'shortCardTitleDesignTextModel'           => [
                'size' => 0
            ],
            'shortCardDateDesignTextModel'            => [
                'size' => 0
            ],
            'shortCardPriceDesignBlockModel'          => [
                'marginTop' => 0
            ],
            'shortCardPriceDesignTextModel'           => [
                'size' => 0
            ],
            'shortCardOldPriceDesignBlockModel'       => [
                'marginTop' => 0
            ],
            'shortCardOldPriceDesignTextModel'        => [
                'size' => 0
            ],
            'shortCardDescriptionDesignBlockModel'    => [
                'marginTop' => 0
            ],
            'shortCardDescriptionDesignTextModel'     => [
                'size' => 0
            ],
            'shortCardPaginationDesignBlockModel'     => [
                'marginTop' => 0
            ],
            'shortCardPaginationItemDesignBlockModel' => [
                'marginTop' => 0
            ],
            'shortCardPaginationItemDesignTextModel'  => [
                'size' => 0
            ],
            'fullCardContainerDesignBlockModel'       => [
                'marginTop' => 0
            ],
            'fullCardTitleDesignBlockModel'           => [
                'marginTop' => 0
            ],
            'fullCardTitleDesignTextModel'            => [
                'size' => 0
            ],
            'fullCardDateDesignTextModel'             => [
                'size' => 0
            ],
            'fullCardPriceDesignBlockModel'           => [
                'marginTop' => 0
            ],
            'fullCardPriceDesignTextModel'            => [
                'size' => 0
            ],
            'fullCardOldPriceDesignBlockModel'        => [
                'marginTop' => 0
            ],
            'fullCardOldPriceDesignTextModel'         => [
                'size' => 0
            ],
            'fullCardBinButtonDesignBlockModel'       => [
                'marginTop' => 0
            ],
            'fullCardBinButtonDesignTextModel'        => [
                'size' => 0
            ],
            'shortCardViewType'                       => 0,
            'fullCardImagesPosition'                  => 0,
            'fullCardDatePosition'                    => 0
        ];
    }

    /**
     * Data provider for CRUD. Empty values
     *
     * @return array
     */
    private function _updateData2()
    {
        return [
            'shortCardContainerDesignBlockModel'      => ' ',
            'shortCardInstanceDesignBlockModel'       => ' ',
            'shortCardTitleDesignBlockModel'          => ' ',
            'shortCardTitleDesignTextModel'           => ' ',
            'shortCardDateDesignTextModel'            => ' ',
            'shortCardPriceDesignBlockModel'          => ' ',
            'shortCardPriceDesignTextModel'           => ' ',
            'shortCardOldPriceDesignBlockModel'       => ' ',
            'shortCardOldPriceDesignTextModel'        => ' ',
            'shortCardDescriptionDesignBlockModel'    => ' ',
            'shortCardDescriptionDesignTextModel'     => ' ',
            'shortCardPaginationDesignBlockModel'     => ' ',
            'shortCardPaginationItemDesignBlockModel' => ' ',
            'shortCardPaginationItemDesignTextModel'  => ' ',
            'fullCardContainerDesignBlockModel'       => ' ',
            'fullCardTitleDesignBlockModel'           => ' ',
            'fullCardTitleDesignTextModel'            => ' ',
            'fullCardDateDesignTextModel'             => ' ',
            'fullCardPriceDesignBlockModel'           => ' ',
            'fullCardPriceDesignTextModel'            => ' ',
            'fullCardOldPriceDesignBlockModel'        => ' ',
            'fullCardOldPriceDesignTextModel'         => ' ',
            'fullCardBinButtonDesignBlockModel'       => ' ',
            'fullCardBinButtonDesignTextModel'        => ' ',
            'shortCardViewType'                       => ' ',
            'fullCardImagesPosition'                  => ' ',
            'fullCardDatePosition'                    => ' '
        ];
    }

    /**
     * Data provider for CRUD. Empty values
     *
     * @return array
     */
    private function _updateExpectedData2()
    {
        return [
            'shortCardContainerDesignBlockModel'      => [
                'marginTop' => 0
            ],
            'shortCardInstanceDesignBlockModel'       => [
                'marginTop' => 0
            ],
            'shortCardTitleDesignBlockModel'          => [
                'marginTop' => 0
            ],
            'shortCardTitleDesignTextModel'           => [
                'size' => 0
            ],
            'shortCardDateDesignTextModel'            => [
                'size' => 0
            ],
            'shortCardPriceDesignBlockModel'          => [
                'marginTop' => 0
            ],
            'shortCardPriceDesignTextModel'           => [
                'size' => 0
            ],
            'shortCardOldPriceDesignBlockModel'       => [
                'marginTop' => 0
            ],
            'shortCardOldPriceDesignTextModel'        => [
                'size' => 0
            ],
            'shortCardDescriptionDesignBlockModel'    => [
                'marginTop' => 0
            ],
            'shortCardDescriptionDesignTextModel'     => [
                'size' => 0
            ],
            'shortCardPaginationDesignBlockModel'     => [
                'marginTop' => 0
            ],
            'shortCardPaginationItemDesignBlockModel' => [
                'marginTop' => 0
            ],
            'shortCardPaginationItemDesignTextModel'  => [
                'size' => 0
            ],
            'fullCardContainerDesignBlockModel'       => [
                'marginTop' => 0
            ],
            'fullCardTitleDesignBlockModel'           => [
                'marginTop' => 0
            ],
            'fullCardTitleDesignTextModel'            => [
                'size' => 0
            ],
            'fullCardDateDesignTextModel'             => [
                'size' => 0
            ],
            'fullCardPriceDesignBlockModel'           => [
                'marginTop' => 0
            ],
            'fullCardPriceDesignTextModel'            => [
                'size' => 0
            ],
            'fullCardOldPriceDesignBlockModel'        => [
                'marginTop' => 0
            ],
            'fullCardOldPriceDesignTextModel'         => [
                'size' => 0
            ],
            'fullCardBinButtonDesignBlockModel'       => [
                'marginTop' => 0
            ],
            'fullCardBinButtonDesignTextModel'        => [
                'size' => 0
            ],
            'shortCardViewType'                       => 0,
            'fullCardImagesPosition'                  => 0,
            'fullCardDatePosition'                    => 0
        ];
    }

    /**
     * Data provider for CRUD. Empty values
     *
     * @return array
     */
    private function _createData3()
    {
        return [
            'shortCardContainerDesignBlockId'      => '',
            'shortCardInstanceDesignBlockId'       => '',
            'shortCardTitleDesignBlockId'          => '',
            'shortCardTitleDesignTextId'           => '',
            'shortCardDateDesignTextId'            => '',
            'shortCardPriceDesignBlockId'          => '',
            'shortCardPriceDesignTextId'           => '',
            'shortCardOldPriceDesignBlockId'       => '',
            'shortCardOldPriceDesignTextId'        => '',
            'shortCardDescriptionDesignBlockId'    => '',
            'shortCardDescriptionDesignTextId'     => '',
            'shortCardPaginationDesignBlockId'     => '',
            'shortCardPaginationItemDesignBlockId' => '',
            'shortCardPaginationItemDesignTextId'  => '',
            'fullCardContainerDesignBlockId'       => '',
            'fullCardTitleDesignBlockId'           => '',
            'fullCardTitleDesignTextId'            => '',
            'fullCardDateDesignTextId'             => '',
            'fullCardPriceDesignBlockId'           => '',
            'fullCardPriceDesignTextId'            => '',
            'fullCardOldPriceDesignBlockId'        => '',
            'fullCardOldPriceDesignTextId'         => '',
            'fullCardBinButtonDesignBlockId'       => '',
            'fullCardBinButtonDesignTextId'        => '',
            'shortCardViewType'                    => '',
            'fullCardImagesPosition'               => '',
            'fullCardDatePosition'                 => ''
        ];
    }

    /**
     * Data provider for CRUD. Empty values
     *
     * @return array
     */
    private function _createExpectedData3()
    {
        return [
            'shortCardContainerDesignBlockModel'      => [
                'marginTop' => 0
            ],
            'shortCardInstanceDesignBlockModel'       => [
                'marginTop' => 0
            ],
            'shortCardTitleDesignBlockModel'          => [
                'marginTop' => 0
            ],
            'shortCardTitleDesignTextModel'           => [
                'size' => 0
            ],
            'shortCardDateDesignTextModel'            => [
                'size' => 0
            ],
            'shortCardPriceDesignBlockModel'          => [
                'marginTop' => 0
            ],
            'shortCardPriceDesignTextModel'           => [
                'size' => 0
            ],
            'shortCardOldPriceDesignBlockModel'       => [
                'marginTop' => 0
            ],
            'shortCardOldPriceDesignTextModel'        => [
                'size' => 0
            ],
            'shortCardDescriptionDesignBlockModel'    => [
                'marginTop' => 0
            ],
            'shortCardDescriptionDesignTextModel'     => [
                'size' => 0
            ],
            'shortCardPaginationDesignBlockModel'     => [
                'marginTop' => 0
            ],
            'shortCardPaginationItemDesignBlockModel' => [
                'marginTop' => 0
            ],
            'shortCardPaginationItemDesignTextModel'  => [
                'size' => 0
            ],
            'fullCardContainerDesignBlockModel'       => [
                'marginTop' => 0
            ],
            'fullCardTitleDesignBlockModel'           => [
                'marginTop' => 0
            ],
            'fullCardTitleDesignTextModel'            => [
                'size' => 0
            ],
            'fullCardDateDesignTextModel'             => [
                'size' => 0
            ],
            'fullCardPriceDesignBlockModel'           => [
                'marginTop' => 0
            ],
            'fullCardPriceDesignTextModel'            => [
                'size' => 0
            ],
            'fullCardOldPriceDesignBlockModel'        => [
                'marginTop' => 0
            ],
            'fullCardOldPriceDesignTextModel'         => [
                'size' => 0
            ],
            'fullCardBinButtonDesignBlockModel'       => [
                'marginTop' => 0
            ],
            'fullCardBinButtonDesignTextModel'        => [
                'size' => 0
            ],
            'shortCardViewType'                       => 0,
            'fullCardImagesPosition'                  => 0,
            'fullCardDatePosition'                    => 0
        ];
    }

    /**
     * Data provider for CRUD. Empty values
     *
     * @return array
     */
    private function _updateData3()
    {
        return [
            'shortCardContainerDesignBlockId'      => null,
            'shortCardInstanceDesignBlockId'       => null,
            'shortCardTitleDesignBlockId'          => null,
            'shortCardTitleDesignTextId'           => null,
            'shortCardDateDesignTextId'            => null,
            'shortCardPriceDesignBlockId'          => null,
            'shortCardPriceDesignTextId'           => null,
            'shortCardOldPriceDesignBlockId'       => null,
            'shortCardOldPriceDesignTextId'        => null,
            'shortCardDescriptionDesignBlockId'    => null,
            'shortCardDescriptionDesignTextId'     => null,
            'shortCardPaginationDesignBlockId'     => null,
            'shortCardPaginationItemDesignBlockId' => null,
            'shortCardPaginationItemDesignTextId'  => null,
            'fullCardContainerDesignBlockId'       => null,
            'fullCardTitleDesignBlockId'           => null,
            'fullCardTitleDesignTextId'            => null,
            'fullCardDateDesignTextId'             => null,
            'fullCardPriceDesignBlockId'           => null,
            'fullCardPriceDesignTextId'            => null,
            'fullCardOldPriceDesignBlockId'        => null,
            'fullCardOldPriceDesignTextId'         => null,
            'fullCardBinButtonDesignBlockId'       => null,
            'fullCardBinButtonDesignTextId'        => null,
            'shortCardViewType'                    => null,
            'fullCardImagesPosition'               => null,
            'fullCardDatePosition'                 => null,
        ];
    }

    /**
     * Data provider for CRUD. Empty values
     *
     * @return array
     */
    private function _updateExpectedData3()
    {
        return [
            'shortCardContainerDesignBlockModel'      => [
                'marginTop' => 0
            ],
            'shortCardInstanceDesignBlockModel'       => [
                'marginTop' => 0
            ],
            'shortCardTitleDesignBlockModel'          => [
                'marginTop' => 0
            ],
            'shortCardTitleDesignTextModel'           => [
                'size' => 0
            ],
            'shortCardDateDesignTextModel'            => [
                'size' => 0
            ],
            'shortCardPriceDesignBlockModel'          => [
                'marginTop' => 0
            ],
            'shortCardPriceDesignTextModel'           => [
                'size' => 0
            ],
            'shortCardOldPriceDesignBlockModel'       => [
                'marginTop' => 0
            ],
            'shortCardOldPriceDesignTextModel'        => [
                'size' => 0
            ],
            'shortCardDescriptionDesignBlockModel'    => [
                'marginTop' => 0
            ],
            'shortCardDescriptionDesignTextModel'     => [
                'size' => 0
            ],
            'shortCardPaginationDesignBlockModel'     => [
                'marginTop' => 0
            ],
            'shortCardPaginationItemDesignBlockModel' => [
                'marginTop' => 0
            ],
            'shortCardPaginationItemDesignTextModel'  => [
                'size' => 0
            ],
            'fullCardContainerDesignBlockModel'       => [
                'marginTop' => 0
            ],
            'fullCardTitleDesignBlockModel'           => [
                'marginTop' => 0
            ],
            'fullCardTitleDesignTextModel'            => [
                'size' => 0
            ],
            'fullCardDateDesignTextModel'             => [
                'size' => 0
            ],
            'fullCardPriceDesignBlockModel'           => [
                'marginTop' => 0
            ],
            'fullCardPriceDesignTextModel'            => [
                'size' => 0
            ],
            'fullCardOldPriceDesignBlockModel'        => [
                'marginTop' => 0
            ],
            'fullCardOldPriceDesignTextModel'         => [
                'size' => 0
            ],
            'fullCardBinButtonDesignBlockModel'       => [
                'marginTop' => 0
            ],
            'fullCardBinButtonDesignTextModel'        => [
                'size' => 0
            ],
            'shortCardViewType'                       => 0,
            'fullCardImagesPosition'                  => 0,
            'fullCardDatePosition'                    => 0
        ];
    }

    /**
     * Data provider for CRUD. Empty values
     *
     * @return array
     */
    private function _createData4()
    {
        return [
            'shortCardContainerDesignBlockModel'      => [
                'marginTop' => ' '
            ],
            'shortCardInstanceDesignBlockModel'       => [
                'marginTop' => ' '
            ],
            'shortCardTitleDesignBlockModel'          => [
                'marginTop' => ' '
            ],
            'shortCardTitleDesignTextModel'           => [
                'size' => ' '
            ],
            'shortCardDateDesignTextModel'            => [
                'size' => ' '
            ],
            'shortCardPriceDesignBlockModel'          => [
                'marginTop' => ' '
            ],
            'shortCardPriceDesignTextModel'           => [
                'size' => ' '
            ],
            'shortCardOldPriceDesignBlockModel'       => [
                'marginTop' => ' '
            ],
            'shortCardOldPriceDesignTextModel'        => [
                'size' => ' '
            ],
            'shortCardDescriptionDesignBlockModel'    => [
                'marginTop' => ' '
            ],
            'shortCardDescriptionDesignTextModel'     => [
                'size' => ' '
            ],
            'shortCardPaginationDesignBlockModel'     => [
                'marginTop' => ' '
            ],
            'shortCardPaginationItemDesignBlockModel' => [
                'marginTop' => ' '
            ],
            'shortCardPaginationItemDesignTextModel'  => [
                'size' => ' '
            ],
            'fullCardContainerDesignBlockModel'       => [
                'marginTop' => ' '
            ],
            'fullCardTitleDesignBlockModel'           => [
                'marginTop' => ' '
            ],
            'fullCardTitleDesignTextModel'            => [
                'size' => ' '
            ],
            'fullCardDateDesignTextModel'             => [
                'size' => ' '
            ],
            'fullCardPriceDesignBlockModel'           => [
                'marginTop' => ' '
            ],
            'fullCardPriceDesignTextModel'            => [
                'size' => ' '
            ],
            'fullCardOldPriceDesignBlockModel'        => [
                'marginTop' => ' '
            ],
            'fullCardOldPriceDesignTextModel'         => [
                'size' => ' '
            ],
            'fullCardBinButtonDesignBlockModel'       => [
                'marginTop' => ' '
            ],
            'fullCardBinButtonDesignTextModel'        => [
                'size' => ' '
            ],
        ];
    }

    /**
     * Data provider for CRUD. Empty values
     *
     * @return array
     */
    private function _createExpectedData4()
    {
        return [
            'shortCardContainerDesignBlockModel'      => [
                'marginTop' => 0
            ],
            'shortCardInstanceDesignBlockModel'       => [
                'marginTop' => 0
            ],
            'shortCardTitleDesignBlockModel'          => [
                'marginTop' => 0
            ],
            'shortCardTitleDesignTextModel'           => [
                'size' => 0
            ],
            'shortCardDateDesignTextModel'            => [
                'size' => 0
            ],
            'shortCardPriceDesignBlockModel'          => [
                'marginTop' => 0
            ],
            'shortCardPriceDesignTextModel'           => [
                'size' => 0
            ],
            'shortCardOldPriceDesignBlockModel'       => [
                'marginTop' => 0
            ],
            'shortCardOldPriceDesignTextModel'        => [
                'size' => 0
            ],
            'shortCardDescriptionDesignBlockModel'    => [
                'marginTop' => 0
            ],
            'shortCardDescriptionDesignTextModel'     => [
                'size' => 0
            ],
            'shortCardPaginationDesignBlockModel'     => [
                'marginTop' => 0
            ],
            'shortCardPaginationItemDesignBlockModel' => [
                'marginTop' => 0
            ],
            'shortCardPaginationItemDesignTextModel'  => [
                'size' => 0
            ],
            'fullCardContainerDesignBlockModel'       => [
                'marginTop' => 0
            ],
            'fullCardTitleDesignBlockModel'           => [
                'marginTop' => 0
            ],
            'fullCardTitleDesignTextModel'            => [
                'size' => 0
            ],
            'fullCardDateDesignTextModel'             => [
                'size' => 0
            ],
            'fullCardPriceDesignBlockModel'           => [
                'marginTop' => 0
            ],
            'fullCardPriceDesignTextModel'            => [
                'size' => 0
            ],
            'fullCardOldPriceDesignBlockModel'        => [
                'marginTop' => 0
            ],
            'fullCardOldPriceDesignTextModel'         => [
                'size' => 0
            ],
            'fullCardBinButtonDesignBlockModel'       => [
                'marginTop' => 0
            ],
            'fullCardBinButtonDesignTextModel'        => [
                'size' => 0
            ],
            'shortCardViewType'                       => 0,
            'fullCardImagesPosition'                  => 0,
            'fullCardDatePosition'                    => 0
        ];
    }

    /**
     * Data provider for CRUD. Empty values
     *
     * @return array
     */
    private function _updateData4()
    {
        return [
            'shortCardContainerDesignBlockModel'      => [],
            'shortCardInstanceDesignBlockModel'       => [],
            'shortCardTitleDesignBlockModel'          => [],
            'shortCardTitleDesignTextModel'           => [],
            'shortCardDateDesignTextModel'            => [],
            'shortCardPriceDesignBlockModel'          => [],
            'shortCardPriceDesignTextModel'           => [],
            'shortCardOldPriceDesignBlockModel'       => [],
            'shortCardOldPriceDesignTextModel'        => [],
            'shortCardDescriptionDesignBlockModel'    => [],
            'shortCardDescriptionDesignTextModel'     => [],
            'shortCardPaginationDesignBlockModel'     => [],
            'shortCardPaginationItemDesignBlockModel' => [],
            'shortCardPaginationItemDesignTextModel'  => [],
            'fullCardContainerDesignBlockModel'       => [],
            'fullCardTitleDesignBlockModel'           => [],
            'fullCardTitleDesignTextModel'            => [],
            'fullCardDateDesignTextModel'             => [],
            'fullCardPriceDesignBlockModel'           => [],
            'fullCardPriceDesignTextModel'            => [],
            'fullCardOldPriceDesignBlockModel'        => [],
            'fullCardOldPriceDesignTextModel'         => [],
            'fullCardBinButtonDesignBlockModel'       => [],
            'fullCardBinButtonDesignTextModel'        => [],
        ];
    }

    /**
     * Data provider for CRUD. Empty values
     *
     * @return array
     */
    private function _updateExpectedData4()
    {
        return [
            'shortCardContainerDesignBlockModel'      => [
                'marginTop' => 0
            ],
            'fullCardBinButtonDesignBlockModel'       => [
                'marginTop' => 0
            ],
            'fullCardBinButtonDesignTextModel'        => [
                'size' => 0
            ],
            'shortCardViewType'                       => 0,
            'fullCardImagesPosition'                  => 0,
            'fullCardDatePosition'                    => 0
        ];
    }
}
