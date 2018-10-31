<?php

namespace ss\tests\phpunit\models\blocks\catalog\_base\AbstractCatalogMenuModel;

use ss\models\blocks\catalog\CatalogMenuModel;
use ss\tests\phpunit\models\_abstract\_base\AbstractDbModelTest;

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
