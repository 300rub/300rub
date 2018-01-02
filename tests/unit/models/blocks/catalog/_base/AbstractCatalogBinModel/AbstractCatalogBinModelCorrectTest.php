<?php

namespace testS\tests\unit\models\blocks\catalog\_base\AbstractCatalogBinModel;

use testS\models\blocks\catalog\CatalogBinModel;
use testS\tests\unit\models\_abstract\_base\AbstractCorrectModelTest;

/**
 * Tests for the model AbstractCatalogBinModel
 */
class AbstractCatalogBinModelCorrectTest extends AbstractCorrectModelTest
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
     * Data provider for CRUD. Correct values
     *
     * @return array
     */
    protected function getDataProviderCorrect()
    {
        return [
            'correct1' => [
                [
                    'catalogId'         => 1,
                    'catalogInstanceId' => 1,
                    'count'             => 1,
                    'status'            => 0,
                ],
                [
                    'catalogId'         => 1,
                    'catalogInstanceId' => 1,
                    'count'             => 1,
                    'status'            => 0,
                ],
                [
                    'count'             => 20,
                    'status'            => 1,
                ],
                [
                    'catalogId'         => 1,
                    'catalogInstanceId' => 1,
                    'count'             => 20,
                    'status'            => 1,
                ],
            ]
        ];
    }
}
