<?php

// @codingStandardsIgnoreLine
namespace ss\tests\phpunit\models\blocks\catalog\_base\AbstractCatalogInstanceModel;

use ss\models\blocks\catalog\CatalogInstanceModel;
use ss\tests\phpunit\models\_abstract\_base\AbstractCorrectModelTest;

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
            'correct1' => array_merge(
                $this->_getCreateDataProvider(),
                $this->_getUpdateDataProvider()
            )
        ];
    }

    /**
     * Data provider for CRUD. Correct values
     *
     * @return array
     */
    private function _getCreateDataProvider()
    {
        return [
            [
                'seoModel'        => [
                    'name'        => 'name 1',
                    'alias'         => 'alias-1',
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
                    'alias'         => 'alias-1',
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
            ]
        ];
    }

    /**
     * Data provider for CRUD. Correct values
     *
     * @return array
     */
    private function _getUpdateDataProvider()
    {
        return [
            [
                'seoModel'        => [
                    'name'        => 'name 2',
                    'alias'         => 'alias-2',
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
                    'alias'         => 'alias-2',
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
        ];
    }
}
