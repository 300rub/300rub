<?php

// @codingStandardsIgnoreLine
namespace ss\tests\unit\models\blocks\catalog\_base\AbstractCatalogInstanceModel;

use ss\models\blocks\catalog\CatalogInstanceModel;
use ss\tests\unit\models\_abstract\_base\AbstractCorrectModelTest;

/**
 * Tests for the model AbstractCatalogInstanceModel
 */
class AbstractCatalogInstanceModelCorrectTest extends AbstractCorrectModelTest
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
     * Data provider for CRUD. Correct values
     *
     * @return array
     */
    protected function getDataProviderCorrect()
    {
        return [
            'correct1' => [
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
                        'seoModel' => [
                            'name'    => 'name'
                        ],
                        'sort'    => 10,
                    ],
                    'catalogMenuId'   => 1,
                    'fieldGroupModel' => [
                        'fieldId' => 1,
                    ],
                    'price'           => 10.34,
                    'oldPrice'        => 20.54,
                ],
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
                        'seoModel' => [
                            'name'    => 'name'
                        ],
                        'sort'    => 10,
                    ],
                    'catalogMenuId'   => 1,
                    'fieldGroupModel' => [
                        'fieldId' => 1,
                    ],
                    'price'           => 10.34,
                    'oldPrice'        => 20.54,
                ],
                [
                    'seoModel'        => [
                        'name'        => 'name 2',
                        'url'         => 'url-2',
                        'title'       => 'title 2',
                        'keywords'    => 'keywords 2',
                        'description' => 'description 2',
                    ],
                    'tabGroupModel'   => [
                        'tabId' => 2,
                    ],
                    'imageGroupModel' => [
                        'imageId' => 2,
                        'seoModel' => [
                            'name'    => 'name 2'
                        ],
                        'sort'    => 20,
                    ],
                    'catalogMenuId'   => 1,
                    'fieldGroupModel' => [
                        'fieldId' => 2,
                    ],
                    'price'           => 40.34,
                    'oldPrice'        => 50.54,
                ],
                [
                    'seoModel'        => [
                        'name'        => 'name 2',
                        'url'         => 'url-2',
                        'title'       => 'title 2',
                        'keywords'    => 'keywords 2',
                        'description' => 'description 2',
                    ],
                    'tabGroupModel'   => [
                        'tabId' => 1,
                    ],
                    'imageGroupModel' => [
                        'imageId' => 1,
                        'seoModel' => [
                            'name'    => 'name 2'
                        ],
                        'sort'    => 20,
                    ],
                    'catalogMenuId'   => 1,
                    'fieldGroupModel' => [
                        'fieldId' => 1,
                    ],
                    'price'           => 40.34,
                    'oldPrice'        => 50.54,
                ],
            ]
        ];
    }
}
