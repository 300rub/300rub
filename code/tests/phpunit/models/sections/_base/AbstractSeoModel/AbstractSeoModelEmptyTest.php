<?php

namespace ss\tests\phpunit\models\sections\_base\AbstractSeoModel;

use ss\models\sections\SeoModel;
use ss\tests\phpunit\models\_abstract\_base\AbstractEmptyModelTest;

/**
 * Tests for the model SeoModel
 */
class AbstractSeoModelEmptyTest extends AbstractEmptyModelTest
{

    /**
     * Gets model name
     *
     * @return SeoModel
     */
    protected function getNewModel()
    {
        return new SeoModel();
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
                    'name' => ['required'],
                    'alias'  => ['required', 'alias']
                ]
            ],
            'empty2' => [
                [
                    'name' => '',
                    'alias'  => '',
                ],
                [
                    'name' => ['required'],
                    'alias'  => ['required', 'alias']
                ]
            ],
            'empty3' => [
                [
                    'alias' => 'Not empty',
                ],
                [
                    'name' => ['required']
                ]
            ],
            'empty4' => [
                [
                    'name' => 'Not empty'
                ],
                [
                    'name'        => 'Not empty',
                    'alias'         => 'not-empty',
                    'title'       => '',
                    'keywords'    => '',
                    'description' => '',
                ]
            ],
            'empty5' => [
                [
                    'name'        => '     Not empty        ',
                    'alias'         => '     Not empty     alias     ',
                    'title'       => '         ',
                    'keywords'    => '          ',
                    'description' => '          '
                ],
                [
                    'name'        => 'Not empty',
                    'alias'         => 'not-empty-----alias',
                    'title'       => '',
                    'keywords'    => '',
                    'description' => '',
                ],
                [
                    'name'     => ' Not empty 2 ',
                    'alias'      => '',
                    'keywords' => 'keywords',
                ],
                [
                    'name'        => 'Not empty 2',
                    'alias'         => 'not-empty-2',
                    'title'       => '',
                    'keywords'    => 'keywords',
                    'description' => ''
                ],
            ],
            'empty6' => [
                [
                    'name' => 'Not empty',
                ],
                [
                    'name' => 'Not empty',
                    'alias'  => 'not-empty',
                ],
                [
                    'name' => '',
                    'alias'  => '',
                ],
                [
                    'name' => ['required'],
                    'alias'  => ['required', 'alias']
                ]
            ],
            'empty7' => [
                [
                    'name' => null,
                    'alias'  => null,
                ],
                [
                    'name' => ['required'],
                    'alias'  => ['required', 'alias']
                ]
            ],
        ];
    }
}
