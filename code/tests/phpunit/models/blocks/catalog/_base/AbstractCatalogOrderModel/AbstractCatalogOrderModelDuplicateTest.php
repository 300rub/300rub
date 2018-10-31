<?php

// @codingStandardsIgnoreLine
namespace ss\tests\phpunit\models\blocks\catalog\_base\AbstractCatalogOrderModel;

use ss\models\blocks\catalog\CatalogOrderModel;
use ss\tests\phpunit\models\_abstract\_base\AbstractDuplicateModelTest;

/**
 * Tests for the model AbstractCatalogOrderModel
 */
class AbstractCatalogOrderModelDuplicateTest extends AbstractDuplicateModelTest
{

    /**
     * Gets model name
     *
     * @return CatalogOrderModel
     */
    protected function getNewModel()
    {
        return new CatalogOrderModel();
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
                'catalogBinId' => 1,
                'formId'       => 1,
                'email'        => 'email@email.com',
            ],
            [
                'email' => ['email']
            ]
        );
    }
}
