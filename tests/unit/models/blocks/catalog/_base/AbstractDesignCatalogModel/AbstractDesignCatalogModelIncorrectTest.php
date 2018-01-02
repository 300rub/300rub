<?php

// @codingStandardsIgnoreLine
namespace testS\tests\unit\models\blocks\catalog\_base\AbstractDesignCatalogModel;

use testS\models\blocks\catalog\DesignCatalogModel;
use testS\tests\unit\models\_abstract\_base\AbstractIncorrectModelTest;

/**
 * Tests for the model AbstractDesignCatalogModel
 */
class AbstractDesignCatalogModelIncorrectTest extends AbstractIncorrectModelTest
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
     * Data provider for CRUD. Incorrect values
     *
     * @return array
     */
    protected function getDataProviderIncorrect()
    {
        return [
            'incorrect1' => [
                $this->_createData1(),
                $this->_createExpectedData1(),
                [
                    'shortCardViewType'      => 999,
                    'fullCardImagesPosition' => 999,
                    'fullCardDatePosition'   => 999
                ],
                [
                    'shortCardViewType'      => 0,
                    'fullCardImagesPosition' => 0,
                    'fullCardDatePosition'   => 0
                ],
            ],
            'incorrect2' => [
                [
                    'shortCardViewType'      => ' 1 ',
                    'fullCardImagesPosition' => '1asdads',
                    'fullCardDatePosition'   => 'asda1'
                ],
                [
                    'shortCardViewType'      => 1,
                    'fullCardImagesPosition' => 1,
                    'fullCardDatePosition'   => 0
                ],
                [
                    'shortCardContainerDesignBlockModel' => [
                        'marginTop' => ' 500 '
                    ],
                    'shortCardViewType'                  => true,
                    'fullCardImagesPosition'             => false,
                    'fullCardDatePosition'               => [1]
                ],
                [
                    'shortCardContainerDesignBlockModel' => [
                        'marginTop' => 500
                    ],
                    'shortCardViewType'                  => 1,
                    'fullCardImagesPosition'             => 0,
                    'fullCardDatePosition'               => 0
                ],
            ],
        ];
    }

    /**
     * Data provider for CRUD. Incorrect values
     *
     * @return array
     */
    private function _createData1()
    {
        return [
            'shortCardContainerDesignBlockModel'      => 'incorrect',
            'shortCardInstanceDesignBlockModel'       => 'incorrect',
            'shortCardTitleDesignBlockModel'          => 'incorrect',
            'shortCardTitleDesignTextModel'           => 'incorrect',
            'shortCardDateDesignTextModel'            => 'incorrect',
            'shortCardPriceDesignBlockModel'          => 'incorrect',
            'shortCardPriceDesignTextModel'           => 'incorrect',
            'shortCardOldPriceDesignBlockModel'       => 'incorrect',
            'shortCardOldPriceDesignTextModel'        => 'incorrect',
            'shortCardDescriptionDesignBlockModel'    => 'incorrect',
            'shortCardDescriptionDesignTextModel'     => 'incorrect',
            'shortCardPaginationDesignBlockModel'     => 'incorrect',
            'shortCardPaginationItemDesignBlockModel' => 'incorrect',
            'shortCardPaginationItemDesignTextModel'  => 'incorrect',
            'fullCardContainerDesignBlockModel'       => 'incorrect',
            'fullCardTitleDesignBlockModel'           => 'incorrect',
            'fullCardTitleDesignTextModel'            => 'incorrect',
            'fullCardDateDesignTextModel'             => 'incorrect',
            'fullCardPriceDesignBlockModel'           => 'incorrect',
            'fullCardPriceDesignTextModel'            => 'incorrect',
            'fullCardOldPriceDesignBlockModel'        => 'incorrect',
            'fullCardOldPriceDesignTextModel'         => 'incorrect',
            'fullCardBinButtonDesignBlockModel'       => 'incorrect',
            'fullCardBinButtonDesignTextModel'        => 'incorrect',
            'shortCardViewType'                       => 'incorrect',
            'fullCardImagesPosition'                  => 'incorrect',
            'fullCardDatePosition'                    => 'incorrect',
        ];
    }

    /**
     * Data provider for CRUD. Incorrect values
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
}
