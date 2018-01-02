<?php

// @codingStandardsIgnoreLine
namespace testS\tests\unit\models\blocks\catalog\_base\AbstractCatalogInstanceLinkModel;

use testS\models\blocks\catalog\CatalogInstanceLinkModel;
use testS\tests\unit\models\_abstract\_base\AbstractDbModelTest;

/**
 * Tests for the model AbstractCatalogInstanceLinkModel
 */
class AbstractCatalogInstanceLinkModelDbTest extends AbstractDbModelTest
{

    /**
     * Gets model name
     *
     * @return CatalogInstanceLinkModel
     */
    protected function getNewModel()
    {
        return new CatalogInstanceLinkModel();
    }
}
