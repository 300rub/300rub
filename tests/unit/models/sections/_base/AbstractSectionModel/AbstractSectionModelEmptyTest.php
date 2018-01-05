<?php

namespace testS\tests\unit\models\sections\_base\AbstractSectionModel;

use testS\models\sections\SectionModel;
use testS\tests\unit\models\_abstract\_base\AbstractEmptyModelTest;

/**
 * Tests for the model SectionModel
 */
class AbstractSectionModelEmptyTest extends AbstractEmptyModelTest
{

    /**
     * Gets model name
     *
     * @return SectionModel
     */
    protected function getNewModel()
    {
        return new SectionModel();
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
                [
                    'seoModel' => [
                        'name' => ['required'],
                        'url'  => ['required', 'url']
                    ]
                ]
            ],
            'empty2' => [
                [
                    'seoModel'         => '',
                    'designBlockModel' => '',
                    'language'         => '',
                    'isMain'           => ''
                ],
                [
                    'seoModel' => [
                        'name' => ['required'],
                        'url'  => ['required', 'url']
                    ]
                ]
            ],
            'empty3' => [
                [
                    'seoModel' => [
                        'url' => 'url'
                    ],
                ],
                [
                    'seoModel' => [
                        'name' => ['required'],
                    ]
                ]
            ],
            'empty4' => [
                [
                    'seoModel'         => [
                        'name' => 'name'
                    ],
                    'designBlockModel' => '',
                    'language'         => '',
                    'isMain'           => ''
                ],
                [
                    'seoModel'         => [
                        'name' => 'name',
                        'url'  => 'name'
                    ],
                    'designBlockModel' => [
                        'marginTop' => 0
                    ],
                    'language'         => 1,
                    'isMain'           => false
                ]
            ],
            'empty5' => [
                [
                    'seoModel'         => [
                        'name' => 'name'
                    ],
                    'designBlockModel' => null,
                    'language'         => null,
                    'isMain'           => null
                ],
                [
                    'seoModel'         => [
                        'name' => 'name',
                        'url'  => 'name'
                    ],
                    'designBlockModel' => [
                        'marginTop' => 0
                    ],
                    'language'         => 1,
                    'isMain'           => false
                ]
            ],
        ];
    }
}
