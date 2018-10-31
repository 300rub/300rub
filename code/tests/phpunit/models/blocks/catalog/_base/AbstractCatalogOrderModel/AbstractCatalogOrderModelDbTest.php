<?php

// @codingStandardsIgnoreLine
namespace ss\tests\phpunit\models\blocks\catalog\_base\AbstractCatalogOrderModel;

use ss\models\blocks\catalog\CatalogOrderModel;
use ss\tests\phpunit\models\_abstract\_base\AbstractDbModelTest;

/**
 * Tests for the model AbstractCatalogOrderModel
 */
class AbstractCatalogOrderModelDbTest extends AbstractDbModelTest
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
}
