<?php

namespace ss\tests\phpunit\models\sections\_base\AbstractSectionModel;

use ss\models\sections\SectionModel;
use ss\tests\phpunit\models\_abstract\_base\AbstractCorrectModelTest;

/**
 * Tests for the model SectionModel
 */
class AbstractSectionModelCorrectTest extends AbstractCorrectModelTest
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
     * Data provider for CRUD. Correct values
     *
     * @return array
     */
    protected function getDataProviderCorrect()
    {
        return [
            'correct1' => [
                [
                    'seoModel'         => [
                        'name'        => 'name',
                        'alias'         => 'alias',
                        'title'       => 'title',
                        'keywords'    => 'keywords',
                        'description' => 'description'
                    ],
                    'designBlockModel' => [
                        'marginTop'    => 10,
                        'marginBottom' => 20,
                    ],
                    'language'         => 1,
                    'isMain'           => false
                ],
                [
                    'seoModel'         => [
                        'name'        => 'name',
                        'alias'         => 'alias',
                        'title'       => 'title',
                        'keywords'    => 'keywords',
                        'description' => 'description'
                    ],
                    'designBlockModel' => [
                        'marginTop'    => 10,
                        'marginBottom' => 20,
                    ],
                    'language'         => 1,
                    'isMain'           => false
                ],
                [
                    'seoModel'         => [
                        'name'        => 'name 2',
                        'alias'         => 'alias-2',
                        'title'       => 'title 2',
                        'keywords'    => 'keywords 2',
                        'description' => 'description 2'
                    ],
                    'designBlockModel' => [
                        'marginTop'    => 30,
                        'marginBottom' => 40,
                    ],
                    'language'         => 2,
                    'isMain'           => false
                ],
                [
                    'seoModel'         => [
                        'name'        => 'name 2',
                        'alias'         => 'alias-2',
                        'title'       => 'title 2',
                        'keywords'    => 'keywords 2',
                        'description' => 'description 2'
                    ],
                    'designBlockModel' => [
                        'marginTop'    => 30,
                        'marginBottom' => 40,
                    ],
                    'language'         => 2,
                    'isMain'           => false
                ]
            ]
        ];
    }
}
