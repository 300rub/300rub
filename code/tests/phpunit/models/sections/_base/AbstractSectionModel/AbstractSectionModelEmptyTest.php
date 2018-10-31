<?php

namespace ss\tests\phpunit\models\sections\_base\AbstractSectionModel;

use ss\models\sections\SectionModel;
use ss\tests\phpunit\models\_abstract\_base\AbstractEmptyModelTest;

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
                        'alias'  => ['required', 'alias']
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
                        'alias'  => ['required', 'alias']
                    ]
                ]
            ],
            'empty3' => [
                [
                    'seoModel' => [
                        'alias' => 'alias'
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
                        'alias'  => 'name'
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
                        'alias'  => 'name'
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
