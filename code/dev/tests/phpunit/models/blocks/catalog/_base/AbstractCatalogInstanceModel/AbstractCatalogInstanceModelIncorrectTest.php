<?php

// @codingStandardsIgnoreLine
namespace ss\tests\phpunit\models\blocks\catalog\_base\AbstractCatalogInstanceModel;

use ss\models\blocks\catalog\CatalogInstanceModel;
use ss\tests\phpunit\models\_abstract\_base\AbstractIncorrectModelTest;

/**
 * Tests for the model AbstractCatalogInstanceModel
 */
// @codingStandardsIgnoreLine
class AbstractCatalogInstanceModelIncorrectTest extends AbstractIncorrectModelTest
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
     * Data provider for CRUD. Incorrect values
     *
     * @return array
     */
    protected function getDataProviderIncorrect()
    {
        return [
            'incorrect1' => [
                [
                    'seoModel'        => 'incorrect',
                    'tabGroupModel'   => 'incorrect',
                    'imageGroupModel' => 'incorrect',
                    'catalogMenuId'   => 'incorrect',
                    'fieldGroupModel' => 'incorrect',
                    'price'           => 'incorrect',
                    'oldPrice'        => 'incorrect',
                    'date'            => 'incorrect',
                ],
                [],
                null,
                null,
                self::EXCEPTION_MODEL
            ],
            'incorrect2' => [
                [
                    'seoModel'        => [
                        'name'        => '<br> name 1',
                    ],
                    'tabGroupModel'   => [
                        'tabId' => ' 1 as',
                    ],
                    'imageGroupModel' => [
                        'imageId' => ' 1 ',
                        'seoModel' => [
                            'name'  => 123
                        ],
                        'sort'    => 'aaaa',
                    ],
                    'catalogMenuId'   => '1 asd',
                    'fieldGroupModel' => [
                        'fieldId' => ' 1 ',
                    ],
                    'price'           => 'asd',
                    'oldPrice'        => ' 20.54 asd',
                ],
                [
                    'seoModel'        => [
                        'name'        => 'name 1',
                        'url'         => 'name-1',
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
                            'name'  => '123'
                        ],
                        'sort'    => 0,
                    ],
                    'catalogMenuId'   => 1,
                    'fieldGroupModel' => [
                        'fieldId' => 1,
                    ],
                    'price'           => 0.0,
                    'oldPrice'        => 20.54,
                ],
            ]
        ];
    }
}
