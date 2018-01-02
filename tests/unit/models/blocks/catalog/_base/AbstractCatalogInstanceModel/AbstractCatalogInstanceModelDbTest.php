<?php

// @codingStandardsIgnoreLine
namespace testS\tests\unit\models\blocks\catalog\_base\AbstractCatalogInstanceModel;

use testS\models\blocks\catalog\CatalogInstanceModel;
use testS\tests\unit\models\_abstract\_base\AbstractDbModelTest;

/**
 * Tests for the model AbstractCatalogInstanceModel
 */
class AbstractCatalogInstanceModelDbTest extends AbstractDbModelTest
{

    /**
     * Gets model name
     *
     * @return CatalogInstanceModel
     */
    protected function getNewModel()
    {
        return new CatalogInstanceModel();
    }
}
