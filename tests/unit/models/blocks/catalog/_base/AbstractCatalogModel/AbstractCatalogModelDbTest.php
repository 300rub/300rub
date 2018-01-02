<?php

namespace testS\tests\unit\models\blocks\catalog\_base\AbstractCatalogModel;

use testS\models\blocks\catalog\CatalogModel;
use testS\tests\unit\models\_abstract\_base\AbstractDbModelTest;

/**
 * Tests for the model AbstractCatalogModel
 */
class AbstractCatalogModelDbTest extends AbstractDbModelTest
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
}
