<?php

namespace ss\tests\phpunit\models\blocks\catalog\_base\AbstractCatalogMenuModel;

use ss\models\blocks\catalog\CatalogMenuModel;
use ss\tests\phpunit\models\_abstract\_base\AbstractDuplicateModelTest;

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
                    'alias'         => 'alias',
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
                    'alias'         => 'alias-copy',
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
