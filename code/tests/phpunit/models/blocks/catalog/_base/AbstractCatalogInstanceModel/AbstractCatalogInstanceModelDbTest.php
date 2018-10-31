<?php

// @codingStandardsIgnoreLine
namespace ss\tests\phpunit\models\blocks\catalog\_base\AbstractCatalogInstanceModel;

use ss\models\blocks\catalog\CatalogInstanceModel;
use ss\tests\phpunit\models\_abstract\_base\AbstractDbModelTest;

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
