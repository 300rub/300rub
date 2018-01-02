<?php

namespace testS\tests\unit\models\blocks\catalog\_base\AbstractCatalogBinModel;

use testS\models\blocks\catalog\CatalogBinModel;
use testS\tests\unit\models\_abstract\_base\AbstractIncorrectModelTest;

/**
 * Tests for the model AbstractCatalogBinModel
 */
class AbstractCatalogBinModelIncorrectTest extends AbstractIncorrectModelTest
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
     * Data provider for CRUD. Incorrect values
     *
     * @return array
     */
    protected function getDataProviderIncorrect()
    {
        return [
            'incorrect1' => [
                [
                    'catalogId'         => 'incorrect1',
                    'catalogInstanceId' => 'incorrect1',
                    'count'             => 'incorrect1',
                    'status'            => 'incorrect1',
                ],
                [
                    'count' => ['minValue']
                ]
            ],
            'incorrect2' => [
                [
                    'catalogId'         => ' 1 a ',
                    'catalogInstanceId' => ' 1 a ',
                    'count'             => ' 21 a',
                    'status'            => ' 1 a',
                ],
                [
                    'catalogId'         => 1,
                    'catalogInstanceId' => 1,
                    'count'             => 21,
                    'status'            => 1,
                ],
                [
                    'catalogId'         => 3,
                    'catalogInstanceId' => 3,
                    'count'             => true,
                    'status'            => 999,
                ],
                [
                    'catalogId'         => 1,
                    'catalogInstanceId' => 1,
                    'count'             => 1,
                    'status'            => 0,
                ],
            ],
            'incorrect3' => [
                [
                    'catalogId'         => 1,
                    'catalogInstanceId' => 1,
                    'count'             => -1,
                    'status'            => 1,
                ],
                [
                    'count' => ['minValue']
                ]
            ],
        ];
    }
}
