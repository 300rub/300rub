<?php

namespace ss\tests\unit\models\blocks\catalog\_base\AbstractCatalogModel;

use ss\models\blocks\catalog\CatalogModel;
use ss\tests\unit\models\_abstract\_base\AbstractIncorrectModelTest;

/**
 * Tests for the model AbstractCatalogModel
 */
class AbstractCatalogModelIncorrectTest extends AbstractIncorrectModelTest
{

    /**
     * Gets model name
     *
     * @return CatalogModel
     */
    protected function getNewModel()
    {
        return new CatalogModel();
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
                [
                    'hasImages'          => 'incorrect',
                    'useAutoload'        => 'incorrect',
                    'pageNavigationSize' => 'incorrect',
                    'shortCardDateType'  => 'incorrect',
                    'fullCardDateType'   => 'incorrect',
                    'hasRelations'       => 'incorrect',
                    'relationsLabel'     => ['incorrect'],
                    'hasBin'             => 'incorrect',
                ],
                [
                    'hasImages'          => false,
                    'useAutoload'        => false,
                    'pageNavigationSize' => 0,
                    'shortCardDateType'  => 0,
                    'fullCardDateType'   => 0,
                    'hasRelations'       => false,
                    'relationsLabel'     => '',
                    'hasBin'             => false,
                ],
                [
                    'hasImages'          => 999,
                    'useAutoload'        => 999,
                    'pageNavigationSize' => true,
                    'shortCardDateType'  => 999,
                    'fullCardDateType'   => 999,
                    'hasRelations'       => 999,
                    'relationsLabel'     => 999,
                    'hasBin'             => 999,
                ],
                [
                    'hasImages'          => true,
                    'useAutoload'        => true,
                    'pageNavigationSize' => 1,
                    'shortCardDateType'  => 0,
                    'fullCardDateType'   => 0,
                    'hasRelations'       => true,
                    'relationsLabel'     => '999',
                    'hasBin'             => true,
                ],
                null,
                null,
                [
                    'designCatalogModel_fullCardContainerDesignBlockModel',
                    'designCatalogModel_fullCardTitleDesignBlockModel',
                    'designCatalogModel_fullCardTitleDesignTextModel',
                    'designCatalogModel_fullCardDateDesignTextModel',
                    'designCatalogModel_fullCardPriceDesignBlockModel',
                    'designCatalogModel_fullCardPriceDesignTextModel',
                    'designCatalogModel_fullCardOldPriceDesignBlockModel',
                    'designCatalogModel_fullCardOldPriceDesignTextModel',
                    'designCatalogModel_fullCardBinButtonDesignBlockModel',
                    'designCatalogModel_fullCardBinButtonDesignTextModel',
                ]
            ],
            'incorrect2' => [
                [
                    'relationsLabel' => '<b> test <',
                ],
                [
                    'relationsLabel' => 'test',
                ],
                [
                    'relationsLabel' => $this->generateStringWithLength(256)
                ],
                [
                    'relationsLabel' => ['maxLength'],
                ],
                null,
                null,
                [
                    'designCatalogModel_fullCardContainerDesignBlockModel',
                    'designCatalogModel_fullCardTitleDesignBlockModel',
                    'designCatalogModel_fullCardTitleDesignTextModel',
                    'designCatalogModel_fullCardDateDesignTextModel',
                    'designCatalogModel_fullCardPriceDesignBlockModel',
                    'designCatalogModel_fullCardPriceDesignTextModel',
                    'designCatalogModel_fullCardOldPriceDesignBlockModel',
                    'designCatalogModel_fullCardOldPriceDesignTextModel',
                    'designCatalogModel_fullCardBinButtonDesignBlockModel',
                    'designCatalogModel_fullCardBinButtonDesignTextModel',
                ]
            ]
        ];
    }
}
