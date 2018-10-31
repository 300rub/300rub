<?php

// @codingStandardsIgnoreLine
namespace ss\tests\phpunit\models\blocks\catalog\_base\AbstractDesignCatalogModel;

use ss\models\blocks\catalog\DesignCatalogModel;
use ss\tests\phpunit\models\_abstract\_base\AbstractDbModelTest;

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
