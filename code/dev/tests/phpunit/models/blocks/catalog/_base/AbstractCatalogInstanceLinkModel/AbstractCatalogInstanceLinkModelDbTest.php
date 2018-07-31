<?php

// @codingStandardsIgnoreLine
namespace ss\tests\phpunit\models\blocks\catalog\_base\AbstractCatalogInstanceLinkModel;

use ss\models\blocks\catalog\CatalogInstanceLinkModel;
use ss\tests\phpunit\models\_abstract\_base\AbstractDbModelTest;

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
