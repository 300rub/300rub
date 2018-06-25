<?php

// @codingStandardsIgnoreLine
namespace ss\tests\unit\models\blocks\catalog\_base\AbstractDesignCatalogModel;

use ss\models\blocks\catalog\DesignCatalogModel;
use ss\tests\unit\models\_abstract\_base\AbstractDbModelTest;

/**
 * Tests for the model AbstractDesignCatalogModel
 */
class AbstractDesignCatalogModelDbTest extends AbstractDbModelTest
{

    /**
     * Gets model name
     *
     * @return DesignCatalogModel
     */
    protected function getNewModel()
    {
        return new DesignCatalogModel();
    }
}
