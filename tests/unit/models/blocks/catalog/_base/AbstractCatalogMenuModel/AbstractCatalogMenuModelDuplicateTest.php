<?php

namespace ss\tests\unit\models\blocks\catalog\_base\AbstractCatalogMenuModel;

use ss\models\blocks\catalog\CatalogMenuModel;
use ss\tests\unit\models\_abstract\_base\AbstractDuplicateModelTest;

/**
 * Tests for the model AbstractCatalogMenuModel
 */
class AbstractCatalogMenuModelDuplicateTest extends AbstractDuplicateModelTest
{

    /**
     * Gets model name
     *
     * @return CatalogMenuModel
     */
    protected function getNewModel()
    {
        return new CatalogMenuModel();
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
                'parentId'  => null,
                'seoModel'  => [
                    'name'        => 'Name',
                    'url'         => 'url',
                    'title'       => 'title',
                    'keywords'    => 'keywords',
                    'description' => 'description',
                ],
                'catalogId' => 1,
                'icon'      => 'icon',
                'subName'   => 'subName',
            ],
            [
                'parentId'  => null,
                'seoModel'  => [
                    'name'        => 'Name (Copy)',
                    'url'         => 'url-copy',
                    'title'       => '',
                    'keywords'    => '',
                    'description' => '',
                ],
                'catalogId' => 1,
                'icon'      => 'icon',
                'subName'   => 'subName',
            ]
        );
    }
}
