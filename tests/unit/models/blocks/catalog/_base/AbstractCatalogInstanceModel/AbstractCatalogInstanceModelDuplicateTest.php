<?php

// @codingStandardsIgnoreLine
namespace ss\tests\unit\models\blocks\catalog\_base\AbstractCatalogInstanceModel;

use ss\models\blocks\catalog\CatalogInstanceModel;
use ss\tests\unit\models\_abstract\_base\AbstractDuplicateModelTest;

/**
 * Tests for the model AbstractCatalogInstanceModel
 */
// @codingStandardsIgnoreLine
class AbstractCatalogInstanceModelDuplicateTest extends AbstractDuplicateModelTest
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

    /**
     * Data provider for CRUD. Duplicate
     *
     * @return void
     */
    public function testDuplicate()
    {
        $this->duplicate(
            [
                'seoModel'        => [
                    'name'        => 'name 1',
                    'url'         => 'url-1',
                    'title'       => 'title 1',
                    'keywords'    => 'keywords 1',
                    'description' => 'description 1',
                ],
                'tabGroupModel'   => [
                    'tabId' => 1,
                ],
                'imageGroupModel' => [
                    'imageId' => 1,
                    'name'    => 'name',
                    'sort'    => 10,
                ],
                'catalogMenuId'   => 1,
                'fieldGroupModel' => [
                    'fieldId' => 1,
                ],
                'price'           => 10.34,
                'oldPrice'        => 20.54,
            ],
            [],
            self::EXCEPTION_MODEL
        );
    }
}
