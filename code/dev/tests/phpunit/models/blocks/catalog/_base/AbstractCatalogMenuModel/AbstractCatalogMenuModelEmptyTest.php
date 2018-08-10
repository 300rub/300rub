<?php

namespace ss\tests\phpunit\models\blocks\catalog\_base\AbstractCatalogMenuModel;

use ss\models\blocks\catalog\CatalogMenuModel;
use ss\tests\phpunit\models\_abstract\_base\AbstractEmptyModelTest;

/**
 * Tests for the model AbstractCatalogMenuModel
 */
class AbstractCatalogMenuModelEmptyTest extends AbstractEmptyModelTest
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
     * Data provider for CRUD. Empty values
     *
     * @return array
     */
    protected function getDataProviderEmpty()
    {
        return [
            'empty1' => [
                [],
                [],
                [],
                [],
                self::EXCEPTION_MODEL
            ],
            'empty2' => [
                [
                    'parentId'  => '',
                    'seoModel'  => '',
                    'catalogId' => '',
                    'icon'      => '',
                    'subName'   => '',
                ],
                [],
                [],
                [],
                self::EXCEPTION_MODEL
            ],
            'empty3' => [
                [
                    'parentId'  => '',
                    'seoModel'  => '',
                    'catalogId' => 1,
                    'icon'      => '',
                    'subName'   => '',
                ],
                [
                    'seoModel' => [
                        'name' => ['required'],
                        'alias'  => ['required', 'alias'],
                    ],
                ],
            ],
            'empty4' => [
                [
                    'parentId'  => '',
                    'seoModel'  => [
                        'name' => 'New name'
                    ],
                    'catalogId' => 1,
                    'icon'      => '',
                    'subName'   => '',
                ],
                [
                    'parentId'  => null,
                    'seoModel'  => [
                        'name'        => 'New name',
                        'alias'         => 'new-name',
                        'title'       => '',
                        'keywords'    => '',
                        'description' => '',
                    ],
                    'catalogId' => 1,
                    'icon'      => '',
                    'subName'   => '',
                ],
            ],
            'empty5' => [
                [
                    'parentId'  => null,
                    'seoModel'  => [
                        'name'        => '',
                        'alias'         => '',
                        'title'       => '',
                        'keywords'    => '',
                        'description' => '',
                    ],
                    'catalogId' => 1,
                    'icon'      => '',
                    'subName'   => '',
                ],
                [
                    'seoModel' => [
                        'name' => ['required'],
                        'alias'  => ['required', 'alias'],
                    ],
                ],
            ]
        ];
    }
}
