<?php

namespace testS\tests\unit\models\blocks\catalog\_base\AbstractCatalogBinModel;

use testS\models\blocks\catalog\CatalogBinModel;
use testS\tests\unit\models\_abstract\_base\AbstractDuplicateModelTest;

/**
 * Tests for the model AbstractCatalogBinModel
 */
class AbstractCatalogBinModelDuplicateTest extends AbstractDuplicateModelTest
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
     * Data provider for CRUD. Duplicate
     *
     * @return void
     */
    public function testDuplicate()
    {
        $this->duplicate(
            [
                'catalogId'         => 1,
                'catalogInstanceId' => 1,
                'count'             => 1,
                'status'            => 0,
            ],
            [
                'count' => ['minValue']
            ]
        );
    }
}
