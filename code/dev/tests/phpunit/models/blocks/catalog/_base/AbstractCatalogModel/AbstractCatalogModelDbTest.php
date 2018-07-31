<?php

namespace ss\tests\phpunit\models\blocks\catalog\_base\AbstractCatalogModel;

use ss\models\blocks\catalog\CatalogModel;
use ss\tests\phpunit\models\_abstract\_base\AbstractDbModelTest;

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
