<?php

namespace ss\tests\phpunit\models\blocks\catalog\_base\AbstractCatalogMenuModel;

use ss\models\blocks\catalog\CatalogMenuModel;
use ss\tests\phpunit\models\_abstract\_base\AbstractCorrectModelTest;

/**
 * Tests for the model AbstractCatalogMenuModel
 */
class AbstractCatalogMenuModelCorrectTest extends AbstractCorrectModelTest
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
     * Data provider for CRUD. Correct values
     *
     * @return array
     */
    protected function getDataProviderCorrect()
    {
        return [
            'correct1' => [
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
                    'parentId'  => 1,
                    'seoModel'  => [
                        'name'        => 'Name 2',
                        'alias'         => 'alias-2',
                        'title'       => 'title 2',
                        'keywords'    => 'keywords 2',
                        'description' => 'description 2',
                    ],
                    'catalogId' => 1,
                    'icon'      => 'icon-2',
                    'subName'   => 'subName 2',
                ],
                [
                    'parentId'  => 1,
                    'seoModel'  => [
                        'name'        => 'Name 2',
                        'alias'         => 'alias-2',
                        'title'       => 'title 2',
                        'keywords'    => 'keywords 2',
                        'description' => 'description 2',
                    ],
                    'catalogId' => 1,
                    'icon'      => 'icon-2',
                    'subName'   => 'subName 2',
                ],
            ]
        ];
    }
}
