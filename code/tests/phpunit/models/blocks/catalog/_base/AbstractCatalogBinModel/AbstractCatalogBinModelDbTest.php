<?php

namespace ss\tests\phpunit\models\blocks\catalog\_base\AbstractCatalogBinModel;

use ss\models\blocks\catalog\CatalogBinModel;
use ss\tests\phpunit\models\_abstract\_base\AbstractDbModelTest;

/**
 * Tests for the model AbstractCatalogBinModel
 */
class AbstractCatalogBinModelDbTest extends AbstractDbModelTest
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
}
