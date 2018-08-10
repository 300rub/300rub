<?php

namespace ss\tests\phpunit\models\sections\_base\AbstractSectionModel;

use ss\models\sections\SectionModel;
use ss\tests\phpunit\models\_abstract\_base\AbstractIncorrectModelTest;

/**
 * Tests for the model SectionModel
 */
class AbstractSectionModelIncorrectTest extends AbstractIncorrectModelTest
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
     * Data provider for CRUD. Incorrect values
     *
     * @return array
     */
    protected function getDataProviderIncorrect()
    {
        return [
            'incorrect1' => [
                [
                    'seoModel' => [
                        'name' => $this->generateStringWithLength(256),
                    ],
                ],
                [
                    'seoModel' => [
                        'name' => ['maxLength'],
                        'alias'  => ['maxLength']
                    ],
                ],
            ],
            'incorrect2' => [
                [
                    'seoModel' => [
                        'name' => 'name',
                        'alias'  => 'alias 2'
                    ],
                ],
                [
                    'seoModel'         => [
                        'name' => 'name',
                        'alias'  => 'alias-2'
                    ],
                    'designBlockModel' => [
                        'marginTop'    => 0,
                        'marginBottom' => 0,
                    ],
                    'language'         => 1,
                    'isMain'           => false
                ],
                [
                    'designBlockModel' => 'incorrect',
                    'language'         => 'incorrect',
                    'isMain'           => 'incorrect',
                ],
                [
                    'seoModel'         => [
                        'name' => 'name',
                        'alias'  => 'alias-2'
                    ],
                    'designBlockModel' => [
                        'marginTop'    => 0,
                        'marginBottom' => 0,
                    ],
                    'language'         => 1,
                    'isMain'           => false
                ],
            ],
            'incorrect3' => [
                [
                    'seoModel' => [
                        'name' => 'name',
                    ],
                    'language'         => '1111',
                    'isMain'           => 'dasdas'
                ],
                [
                    'seoModel'         => [
                        'name' => 'name',
                    ],
                    'designBlockModel' => [
                        'marginTop'    => 0,
                        'marginBottom' => 0,
                    ],
                    'language'         => 1,
                    'isMain'           => false
                ],
            ]
        ];
    }
}
