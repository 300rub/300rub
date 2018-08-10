<?php

// @codingStandardsIgnoreLine
namespace ss\tests\phpunit\models\blocks\catalog\_base\AbstractCatalogInstanceModel;

use ss\models\blocks\catalog\CatalogInstanceModel;
use ss\tests\phpunit\models\_abstract\_base\AbstractEmptyModelTest;

/**
 * Tests for the model AbstractCatalogInstanceModel
 */
class AbstractCatalogInstanceModelEmptyTest extends AbstractEmptyModelTest
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
                null,
                null,
                self::EXCEPTION_MODEL
            ],
            'empty2' => [
                [
                    'seoModel'        => '',
                    'tabGroupModel'   => '',
                    'imageGroupModel' => '',
                    'catalogMenuId'   => '',
                    'fieldGroupModel' => '',
                    'price'           => '',
                    'oldPrice'        => '',
                    'date'            => '',
                ],
                [],
                null,
                null,
                self::EXCEPTION_MODEL
            ],
            'empty3' => [
                [
                    'tabGroupModel'   => [
                        'tabId' => 1,
                    ],
                    'catalogMenuId'   => 1,
                    'fieldGroupModel' => [
                        'fieldId' => 1,
                    ],
                ],
                [],
                null,
                null,
                self::EXCEPTION_MODEL
            ],
            'empty4' => [
                [
                    'tabGroupModel'   => [
                        'tabId' => 1,
                    ],
                    'seoModel'        => [
                        'name' => 'name',
                    ],
                    'catalogMenuId'   => 1,
                    'fieldGroupModel' => [
                        'fieldId' => 1,
                    ],
                    'imageGroupModel' => [
                        'imageId' => 1,
                        'seoModel' => [
                            'name'  => 'name'
                        ],
                    ]
                ],
                [
                    'seoModel'        => [
                        'name'        => 'name',
                        'alias'         => 'name',
                        'title'       => '',
                        'keywords'    => '',
                        'description' => '',
                    ],
                    'tabGroupModel'   => [
                        'tabId' => 1,
                    ],
                    'imageGroupModel' => [
                        'imageId' => 1,
                        'seoModel' => [
                            'name'  => 'name'
                        ],
                        'sort'    => 0,
                    ],
                    'catalogMenuId'   => 1,
                    'fieldGroupModel' => [
                        'fieldId' => 1,
                    ],
                    'price'           => 0.0,
                    'oldPrice'        => 0.0,
                ],
            ]
        ];
    }
}
