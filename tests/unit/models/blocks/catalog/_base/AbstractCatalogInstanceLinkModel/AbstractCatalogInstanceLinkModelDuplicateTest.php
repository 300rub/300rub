<?php

// @codingStandardsIgnoreLine
namespace testS\tests\unit\models\blocks\catalog\_base\AbstractCatalogInstanceLinkModel;

use testS\models\blocks\catalog\CatalogInstanceLinkModel;
use testS\tests\unit\models\_abstract\_base\AbstractDuplicateModelTest;

/**
 * Tests for the model AbstractCatalogInstanceLinkModel
 */
// @codingStandardsIgnoreLine
class AbstractCatalogInstanceLinkModelDuplicateTest extends AbstractDuplicateModelTest
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

    /**
     * Data provider for CRUD. Duplicate
     *
     * @return array
     */
    public function testDuplicate()
    {
        $this->duplicate(
            [
                'catalogInstanceId'     => 1,
                'linkCatalogInstanceId' => 2,
            ],
            [],
            self::EXCEPTION_MODEL
        );
    }
}
