<?php

// @codingStandardsIgnoreLine
namespace ss\tests\phpunit\models\blocks\catalog\_base\AbstractCatalogInstanceLinkModel;

use ss\models\blocks\catalog\CatalogInstanceLinkModel;
use ss\tests\phpunit\models\_abstract\_base\AbstractDuplicateModelTest;

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
     * @return void
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
