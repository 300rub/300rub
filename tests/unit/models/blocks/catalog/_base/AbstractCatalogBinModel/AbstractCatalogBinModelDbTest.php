<?php

namespace testS\tests\unit\models\blocks\catalog\_base\AbstractCatalogBinModel;

use testS\models\blocks\catalog\CatalogBinModel;
use testS\tests\unit\models\_abstract\_base\AbstractDbModelTest;

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
