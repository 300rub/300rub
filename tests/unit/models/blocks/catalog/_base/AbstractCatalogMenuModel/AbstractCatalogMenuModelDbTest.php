<?php

namespace testS\tests\unit\models\blocks\catalog\_base\AbstractCatalogMenuModel;

use testS\models\blocks\catalog\CatalogMenuModel;
use testS\tests\unit\models\_abstract\_base\AbstractDbModelTest;

/**
 * Tests for the model AbstractCatalogMenuModel
 */
class AbstractCatalogMenuModelDbTest extends AbstractDbModelTest
{

    /**
     * Gets model name
     *
     * @return CatalogMenuModel
     */
    protected function getNewModel()
    {
        return new CatalogMenuModel();
    }
}
