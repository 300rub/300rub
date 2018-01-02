<?php

// @codingStandardsIgnoreLine
namespace testS\tests\unit\models\blocks\catalog\_base\AbstractDesignCatalogModel;

use testS\models\blocks\catalog\DesignCatalogModel;
use testS\tests\unit\models\_abstract\_base\AbstractDbModelTest;

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
