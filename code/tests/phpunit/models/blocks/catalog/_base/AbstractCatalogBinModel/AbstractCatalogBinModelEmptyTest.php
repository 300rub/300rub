<?php

namespace ss\tests\phpunit\models\blocks\catalog\_base\AbstractCatalogBinModel;

use ss\models\blocks\catalog\CatalogBinModel;
use ss\tests\phpunit\models\_abstract\_base\AbstractEmptyModelTest;

/**
 * Tests for the model AbstractCatalogBinModel
 */
class AbstractCatalogBinModelEmptyTest extends AbstractEmptyModelTest
{

    /**
     * Gets model name
     *
     * @return CatalogBinModel
     */
    protected function getNewModel()
    {
        return new CatalogBinModel();
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
                [
                    'count' => ['minValue']
                ]
            ],
            'empty2' => [
                [
                    'catalogId'         => '',
                    'catalogInstanceId' => '',
                    'count'             => '',
                    'status'            => '',
                ],
                [
                    'count' => ['minValue']
                ]
            ],
            'empty3' => [
                [
                    'count' => 1
                ],
                [],
                null,
                null,
                self::EXCEPTION_MODEL
            ],
            'empty4' => [
                [
                    'catalogId'         => 1,
                    'catalogInstanceId' => 1,
                    'count'             => 1,
                ],
                [
                    'catalogId'         => 1,
                    'catalogInstanceId' => 1,
                    'count'             => 1,
                    'status'            => 0,
                ]
            ],
        ];
    }
}
