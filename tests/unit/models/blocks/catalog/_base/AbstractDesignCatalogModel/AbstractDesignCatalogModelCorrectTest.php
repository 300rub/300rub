<?php

// @codingStandardsIgnoreLine
namespace testS\tests\unit\models\blocks\catalog\_base\AbstractDesignCatalogModel;

use testS\models\blocks\catalog\DesignCatalogModel;
use testS\tests\unit\models\_abstract\_base\AbstractCorrectModelTest;

/**
 * Tests for the model AbstractDesignCatalogModel
 */
class AbstractDesignCatalogModelCorrectTest extends AbstractCorrectModelTest
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
     * Data provider for CRUD. Correct values
     *
     * @return array
     */
    protected function getDataProviderCorrect()
    {
        return [
            'correct1' => [
                array_merge(
                    $this->_createData1(),
                    $this->_createData2()
                ),
                array_merge(
                    $this->_createExpectData1(),
                    $this->_createExpectData2()
                ),
                array_merge(
                    $this->_updateData1(),
                    $this->_updateData2()
                ),
                array_merge(
                    $this->_updateExpectData1(),
                    $this->_updateExpectData2()
                ),
            ],
        ];
    }

    /**
     * Data provider for CRUD. Correct values
     *
     * @return array
     */
    private function _createData1()
    {
        return [
            'shortCardContainerDesignBlockModel'      => [
                'marginTop'                => 10,
                'borderBottomWidth'        => 7,
                'borderColorHover'         => 'rgb(0,255,0)',
                'backgroundColorFromHover' => 'rgba(255,0,255,0.5)',
            ],
            'shortCardInstanceDesignBlockModel'       => [
                'marginTop'                => 10,
                'borderBottomWidth'        => 7,
                'borderColorHover'         => 'rgb(0,255,0)',
                'backgroundColorFromHover' => 'rgba(255,0,255,0.5)',
            ],
            'shortCardTitleDesignBlockModel'          => [
                'marginTop'                => 10,
                'borderBottomWidth'        => 7,
                'borderColorHover'         => 'rgb(0,255,0)',
                'backgroundColorFromHover' => 'rgba(255,0,255,0.5)',
            ],
            'shortCardTitleDesignTextModel'           => [
                'size' => 10
            ],
            'shortCardDateDesignTextModel'            => [
                'size' => 10
            ],
            'shortCardPriceDesignBlockModel'          => [
                'marginTop'                => 10,
                'borderBottomWidth'        => 7,
                'borderColorHover'         => 'rgb(0,255,0)',
                'backgroundColorFromHover' => 'rgba(255,0,255,0.5)',
            ],
            'shortCardPriceDesignTextModel'           => [
                'size' => 10
            ],
            'shortCardOldPriceDesignBlockModel'       => [
                'marginTop'                => 10,
                'borderBottomWidth'        => 7,
                'borderColorHover'         => 'rgb(0,255,0)',
                'backgroundColorFromHover' => 'rgba(255,0,255,0.5)',
            ],
            'shortCardOldPriceDesignTextModel'        => [
                'size' => 10
            ],
            'shortCardDescriptionDesignBlockModel'    => [
                'marginTop'                => 10,
                'borderBottomWidth'        => 7,
                'borderColorHover'         => 'rgb(0,255,0)',
                'backgroundColorFromHover' => 'rgba(255,0,255,0.5)',
            ],
            'shortCardDescriptionDesignTextModel'     => [
                'size' => 10
            ],
            'shortCardPaginationDesignBlockModel'     => [
                'marginTop'                => 10,
                'borderBottomWidth'        => 7,
                'borderColorHover'         => 'rgb(0,255,0)',
                'backgroundColorFromHover' => 'rgba(255,0,255,0.5)',
            ],
            'shortCardPaginationItemDesignBlockModel' => [
                'marginTop'                => 10,
                'borderBottomWidth'        => 7,
                'borderColorHover'         => 'rgb(0,255,0)',
                'backgroundColorFromHover' => 'rgba(255,0,255,0.5)',
            ],
            'shortCardPaginationItemDesignTextModel'  => [
                'size' => 10
            ],
        ];
    }

    /**
     * Data provider for CRUD. Correct values
     *
     * @return array
     */
    private function _createData2()
    {
        return [
            'fullCardContainerDesignBlockModel'       => [
                'marginTop'                => 10,
                'borderBottomWidth'        => 7,
                'borderColorHover'         => 'rgb(0,255,0)',
                'backgroundColorFromHover' => 'rgba(255,0,255,0.5)',
            ],
            'fullCardTitleDesignBlockModel'           => [
                'marginTop'                => 10,
                'borderBottomWidth'        => 7,
                'borderColorHover'         => 'rgb(0,255,0)',
                'backgroundColorFromHover' => 'rgba(255,0,255,0.5)',
            ],
            'fullCardTitleDesignTextModel'            => [
                'size' => 10
            ],
            'fullCardDateDesignTextModel'             => [
                'size' => 10
            ],
            'fullCardPriceDesignBlockModel'           => [
                'marginTop'                => 10,
                'borderBottomWidth'        => 7,
                'borderColorHover'         => 'rgb(0,255,0)',
                'backgroundColorFromHover' => 'rgba(255,0,255,0.5)',
            ],
            'fullCardPriceDesignTextModel'            => [
                'size' => 10
            ],
            'fullCardOldPriceDesignBlockModel'        => [
                'marginTop'                => 10,
                'borderBottomWidth'        => 7,
                'borderColorHover'         => 'rgb(0,255,0)',
                'backgroundColorFromHover' => 'rgba(255,0,255,0.5)',
            ],
            'fullCardOldPriceDesignTextModel'         => [
                'size' => 10
            ],
            'fullCardBinButtonDesignBlockModel'       => [
                'marginTop'                => 10,
                'borderBottomWidth'        => 7,
                'borderColorHover'         => 'rgb(0,255,0)',
                'backgroundColorFromHover' => 'rgba(255,0,255,0.5)',
            ],
            'fullCardBinButtonDesignTextModel'        => [
                'size' => 10
            ],
            'shortCardViewType'                       => 1,
            'fullCardImagesPosition'                  => 1,
            'fullCardDatePosition'                    => 1
        ];
    }

    /**
     * Data provider for CRUD. Correct values
     *
     * @return array
     */
    private function _createExpectData1()
    {
        return [
            'shortCardContainerDesignBlockModel'      => [
                'marginTop'                => 10,
                'borderBottomWidth'        => 7,
                'borderColorHover'         => 'rgb(0,255,0)',
                'backgroundColorFromHover' => 'rgba(255,0,255,0.5)',
            ],
            'shortCardInstanceDesignBlockModel'       => [
                'marginTop'                => 10,
                'borderBottomWidth'        => 7,
                'borderColorHover'         => 'rgb(0,255,0)',
                'backgroundColorFromHover' => 'rgba(255,0,255,0.5)',
            ],
            'shortCardTitleDesignBlockModel'          => [
                'marginTop'                => 10,
                'borderBottomWidth'        => 7,
                'borderColorHover'         => 'rgb(0,255,0)',
                'backgroundColorFromHover' => 'rgba(255,0,255,0.5)',
            ],
            'shortCardTitleDesignTextModel'           => [
                'size' => 10
            ],
            'shortCardDateDesignTextModel'            => [
                'size' => 10
            ],
            'shortCardPriceDesignBlockModel'          => [
                'marginTop'                => 10,
                'borderBottomWidth'        => 7,
                'borderColorHover'         => 'rgb(0,255,0)',
                'backgroundColorFromHover' => 'rgba(255,0,255,0.5)',
            ],
            'shortCardPriceDesignTextModel'           => [
                'size' => 10
            ],
            'shortCardOldPriceDesignBlockModel'       => [
                'marginTop'                => 10,
                'borderBottomWidth'        => 7,
                'borderColorHover'         => 'rgb(0,255,0)',
                'backgroundColorFromHover' => 'rgba(255,0,255,0.5)',
            ],
            'shortCardOldPriceDesignTextModel'        => [
                'size' => 10
            ],
            'shortCardDescriptionDesignBlockModel'    => [
                'marginTop'                => 10,
                'borderBottomWidth'        => 7,
                'borderColorHover'         => 'rgb(0,255,0)',
                'backgroundColorFromHover' => 'rgba(255,0,255,0.5)',
            ],
            'shortCardDescriptionDesignTextModel'     => [
                'size' => 10
            ],
            'shortCardPaginationDesignBlockModel'     => [
                'marginTop'                => 10,
                'borderBottomWidth'        => 7,
                'borderColorHover'         => 'rgb(0,255,0)',
                'backgroundColorFromHover' => 'rgba(255,0,255,0.5)',
            ],
            'shortCardPaginationItemDesignBlockModel' => [
                'marginTop'                => 10,
                'borderBottomWidth'        => 7,
                'borderColorHover'         => 'rgb(0,255,0)',
                'backgroundColorFromHover' => 'rgba(255,0,255,0.5)',
            ],
            'shortCardPaginationItemDesignTextModel'  => [
                'size' => 10
            ],
        ];
    }

    /**
     * Data provider for CRUD. Correct values
     *
     * @return array
     */
    private function _createExpectData2()
    {
        return [
            'fullCardContainerDesignBlockModel'       => [
                'marginTop'                => 10,
                'borderBottomWidth'        => 7,
                'borderColorHover'         => 'rgb(0,255,0)',
                'backgroundColorFromHover' => 'rgba(255,0,255,0.5)',
            ],
            'fullCardTitleDesignBlockModel'           => [
                'marginTop'                => 10,
                'borderBottomWidth'        => 7,
                'borderColorHover'         => 'rgb(0,255,0)',
                'backgroundColorFromHover' => 'rgba(255,0,255,0.5)',
            ],
            'fullCardTitleDesignTextModel'            => [
                'size' => 10
            ],
            'fullCardDateDesignTextModel'             => [
                'size' => 10
            ],
            'fullCardPriceDesignBlockModel'           => [
                'marginTop'                => 10,
                'borderBottomWidth'        => 7,
                'borderColorHover'         => 'rgb(0,255,0)',
                'backgroundColorFromHover' => 'rgba(255,0,255,0.5)',
            ],
            'fullCardPriceDesignTextModel'            => [
                'size' => 10
            ],
            'fullCardOldPriceDesignBlockModel'        => [
                'marginTop'                => 10,
                'borderBottomWidth'        => 7,
                'borderColorHover'         => 'rgb(0,255,0)',
                'backgroundColorFromHover' => 'rgba(255,0,255,0.5)',
            ],
            'fullCardOldPriceDesignTextModel'         => [
                'size' => 10
            ],
            'fullCardBinButtonDesignBlockModel'       => [
                'marginTop'                => 10,
                'borderBottomWidth'        => 7,
                'borderColorHover'         => 'rgb(0,255,0)',
                'backgroundColorFromHover' => 'rgba(255,0,255,0.5)',
            ],
            'fullCardBinButtonDesignTextModel'        => [
                'size' => 10
            ],
            'shortCardViewType'                       => 1,
            'fullCardImagesPosition'                  => 1,
            'fullCardDatePosition'                    => 1
        ];
    }

    /**
     * Data provider for CRUD. Correct values
     *
     * @return array
     */
    private function _updateData1()
    {
        return [
            'shortCardContainerDesignBlockModel'      => [
                'marginTop'                => 5,
                'borderBottomWidth'        => 4,
                'borderColorHover'         => 'rgb(255,0,0)',
                'backgroundColorFromHover' => 'rgba(0,0,255,0.7)',
            ],
            'shortCardInstanceDesignBlockModel'       => [
                'marginTop'                => 5,
                'borderBottomWidth'        => 4,
                'borderColorHover'         => 'rgb(255,0,0)',
                'backgroundColorFromHover' => 'rgba(0,0,255,0.7)',
            ],
            'shortCardTitleDesignBlockModel'          => [
                'marginTop'                => 5,
                'borderBottomWidth'        => 4,
                'borderColorHover'         => 'rgb(255,0,0)',
                'backgroundColorFromHover' => 'rgba(0,0,255,0.7)',
            ],
            'shortCardTitleDesignTextModel'           => [
                'size' => 20
            ],
            'shortCardDateDesignTextModel'            => [
                'size' => 20
            ],
            'shortCardPriceDesignBlockModel'          => [
                'marginTop'                => 5,
                'borderBottomWidth'        => 4,
                'borderColorHover'         => 'rgb(255,0,0)',
                'backgroundColorFromHover' => 'rgba(0,0,255,0.7)',
            ],
            'shortCardPriceDesignTextModel'           => [
                'size' => 20
            ],
            'shortCardOldPriceDesignBlockModel'       => [
                'marginTop'                => 5,
                'borderBottomWidth'        => 4,
                'borderColorHover'         => 'rgb(255,0,0)',
                'backgroundColorFromHover' => 'rgba(0,0,255,0.7)',
            ],
            'shortCardOldPriceDesignTextModel'        => [
                'size' => 20
            ],
            'shortCardDescriptionDesignBlockModel'    => [
                'marginTop'                => 5,
                'borderBottomWidth'        => 4,
                'borderColorHover'         => 'rgb(255,0,0)',
                'backgroundColorFromHover' => 'rgba(0,0,255,0.7)',
            ],
            'shortCardDescriptionDesignTextModel'     => [
                'size' => 20
            ],
            'shortCardPaginationDesignBlockModel'     => [
                'marginTop'                => 5,
                'borderBottomWidth'        => 4,
                'borderColorHover'         => 'rgb(255,0,0)',
                'backgroundColorFromHover' => 'rgba(0,0,255,0.7)',
            ],
            'shortCardPaginationItemDesignBlockModel' => [
                'marginTop'                => 5,
                'borderBottomWidth'        => 4,
                'borderColorHover'         => 'rgb(255,0,0)',
                'backgroundColorFromHover' => 'rgba(0,0,255,0.7)',
            ],
            'shortCardPaginationItemDesignTextModel'  => [
                'size' => 20
            ],
        ];
    }

    /**
     * Data provider for CRUD. Correct values
     *
     * @return array
     */
    private function _updateData2()
    {
        return [
            'fullCardContainerDesignBlockModel'       => [
                'marginTop'                => 5,
                'borderBottomWidth'        => 4,
                'borderColorHover'         => 'rgb(255,0,0)',
                'backgroundColorFromHover' => 'rgba(0,0,255,0.7)',
            ],
            'fullCardTitleDesignBlockModel'           => [
                'marginTop'                => 5,
                'borderBottomWidth'        => 4,
                'borderColorHover'         => 'rgb(255,0,0)',
                'backgroundColorFromHover' => 'rgba(0,0,255,0.7)',
            ],
            'fullCardTitleDesignTextModel'            => [
                'size' => 20
            ],
            'fullCardDateDesignTextModel'             => [
                'size' => 20
            ],
            'fullCardPriceDesignBlockModel'           => [
                'marginTop'                => 5,
                'borderBottomWidth'        => 4,
                'borderColorHover'         => 'rgb(255,0,0)',
                'backgroundColorFromHover' => 'rgba(0,0,255,0.7)',
            ],
            'fullCardPriceDesignTextModel'            => [
                'size' => 20
            ],
            'fullCardOldPriceDesignBlockModel'        => [
                'marginTop'                => 5,
                'borderBottomWidth'        => 4,
                'borderColorHover'         => 'rgb(255,0,0)',
                'backgroundColorFromHover' => 'rgba(0,0,255,0.7)',
            ],
            'fullCardOldPriceDesignTextModel'         => [
                'size' => 20
            ],
            'fullCardBinButtonDesignBlockModel'       => [
                'marginTop'                => 5,
                'borderBottomWidth'        => 4,
                'borderColorHover'         => 'rgb(255,0,0)',
                'backgroundColorFromHover' => 'rgba(0,0,255,0.7)',
            ],
            'fullCardBinButtonDesignTextModel'        => [
                'size' => 20
            ],
            'shortCardViewType'                       => 0,
            'fullCardImagesPosition'                  => 0,
            'fullCardDatePosition'                    => 0
        ];
    }

    /**
     * Data provider for CRUD. Correct values
     *
     * @return array
     */
    private function _updateExpectData1()
    {
        return [
            'shortCardContainerDesignBlockModel'      => [
                'marginTop'                => 5,
                'borderBottomWidth'        => 4,
                'borderColorHover'         => 'rgb(255,0,0)',
                'backgroundColorFromHover' => 'rgba(0,0,255,0.7)',
            ],
            'shortCardInstanceDesignBlockModel'       => [
                'marginTop'                => 5,
                'borderBottomWidth'        => 4,
                'borderColorHover'         => 'rgb(255,0,0)',
                'backgroundColorFromHover' => 'rgba(0,0,255,0.7)',
            ],
            'shortCardTitleDesignBlockModel'          => [
                'marginTop'                => 5,
                'borderBottomWidth'        => 4,
                'borderColorHover'         => 'rgb(255,0,0)',
                'backgroundColorFromHover' => 'rgba(0,0,255,0.7)',
            ],
            'shortCardTitleDesignTextModel'           => [
                'size' => 20
            ],
            'shortCardDateDesignTextModel'            => [
                'size' => 20
            ],
            'shortCardPriceDesignBlockModel'          => [
                'marginTop'                => 5,
                'borderBottomWidth'        => 4,
                'borderColorHover'         => 'rgb(255,0,0)',
                'backgroundColorFromHover' => 'rgba(0,0,255,0.7)',
            ],
            'shortCardPriceDesignTextModel'           => [
                'size' => 20
            ],
            'shortCardOldPriceDesignBlockModel'       => [
                'marginTop'                => 5,
                'borderBottomWidth'        => 4,
                'borderColorHover'         => 'rgb(255,0,0)',
                'backgroundColorFromHover' => 'rgba(0,0,255,0.7)',
            ],
            'shortCardOldPriceDesignTextModel'        => [
                'size' => 20
            ],
            'shortCardDescriptionDesignBlockModel'    => [
                'marginTop'                => 5,
                'borderBottomWidth'        => 4,
                'borderColorHover'         => 'rgb(255,0,0)',
                'backgroundColorFromHover' => 'rgba(0,0,255,0.7)',
            ],
            'shortCardDescriptionDesignTextModel'     => [
                'size' => 20
            ],
            'shortCardPaginationDesignBlockModel'     => [
                'marginTop'                => 5,
                'borderBottomWidth'        => 4,
                'borderColorHover'         => 'rgb(255,0,0)',
                'backgroundColorFromHover' => 'rgba(0,0,255,0.7)',
            ],
            'shortCardPaginationItemDesignBlockModel' => [
                'marginTop'                => 5,
                'borderBottomWidth'        => 4,
                'borderColorHover'         => 'rgb(255,0,0)',
                'backgroundColorFromHover' => 'rgba(0,0,255,0.7)',
            ],
            'shortCardPaginationItemDesignTextModel'  => [
                'size' => 20
            ],
        ];
    }

    /**
     * Data provider for CRUD. Correct values
     *
     * @return array
     */
    private function _updateExpectData2()
    {
        return [
            'fullCardContainerDesignBlockModel'       => [
                'marginTop'                => 5,
                'borderBottomWidth'        => 4,
                'borderColorHover'         => 'rgb(255,0,0)',
                'backgroundColorFromHover' => 'rgba(0,0,255,0.7)',
            ],
            'fullCardTitleDesignBlockModel'           => [
                'marginTop'                => 5,
                'borderBottomWidth'        => 4,
                'borderColorHover'         => 'rgb(255,0,0)',
                'backgroundColorFromHover' => 'rgba(0,0,255,0.7)',
            ],
            'fullCardTitleDesignTextModel'            => [
                'size' => 20
            ],
            'fullCardDateDesignTextModel'             => [
                'size' => 20
            ],
            'fullCardPriceDesignBlockModel'           => [
                'marginTop'                => 5,
                'borderBottomWidth'        => 4,
                'borderColorHover'         => 'rgb(255,0,0)',
                'backgroundColorFromHover' => 'rgba(0,0,255,0.7)',
            ],
            'fullCardPriceDesignTextModel'            => [
                'size' => 20
            ],
            'fullCardOldPriceDesignBlockModel'        => [
                'marginTop'                => 5,
                'borderBottomWidth'        => 4,
                'borderColorHover'         => 'rgb(255,0,0)',
                'backgroundColorFromHover' => 'rgba(0,0,255,0.7)',
            ],
            'fullCardOldPriceDesignTextModel'         => [
                'size' => 20
            ],
            'fullCardBinButtonDesignBlockModel'       => [
                'marginTop'                => 5,
                'borderBottomWidth'        => 4,
                'borderColorHover'         => 'rgb(255,0,0)',
                'backgroundColorFromHover' => 'rgba(0,0,255,0.7)',
            ],
            'fullCardBinButtonDesignTextModel'        => [
                'size' => 20
            ],
            'shortCardViewType'                       => 0,
            'fullCardImagesPosition'                  => 0,
            'fullCardDatePosition'                    => 0
        ];
    }
}
