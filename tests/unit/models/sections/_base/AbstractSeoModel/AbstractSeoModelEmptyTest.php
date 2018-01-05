<?php

namespace testS\tests\unit\models\sections\_base\AbstractSeoModel;

use testS\models\sections\SeoModel;
use testS\tests\unit\models\_abstract\_base\AbstractEmptyModelTest;

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
                    'url'  => ['required', 'url']
                ]
            ],
            'empty2' => [
                [
                    'name' => '',
                    'url'  => '',
                ],
                [
                    'name' => ['required'],
                    'url'  => ['required', 'url']
                ]
            ],
            'empty3' => [
                [
                    'url' => 'Not empty',
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
                    'url'         => 'not-empty',
                    'title'       => '',
                    'keywords'    => '',
                    'description' => '',
                ]
            ],
            'empty5' => [
                [
                    'name'        => '     Not empty        ',
                    'url'         => '     Not empty     url     ',
                    'title'       => '         ',
                    'keywords'    => '          ',
                    'description' => '          '
                ],
                [
                    'name'        => 'Not empty',
                    'url'         => 'not-empty-----url',
                    'title'       => '',
                    'keywords'    => '',
                    'description' => '',
                ],
                [
                    'name'     => ' Not empty 2 ',
                    'url'      => '',
                    'keywords' => 'keywords',
                ],
                [
                    'name'        => 'Not empty 2',
                    'url'         => 'not-empty-2',
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
                    'url'  => 'not-empty',
                ],
                [
                    'name' => '',
                    'url'  => '',
                ],
                [
                    'name' => ['required'],
                    'url'  => ['required', 'url']
                ]
            ],
            'empty7' => [
                [
                    'name' => null,
                    'url'  => null,
                ],
                [
                    'name' => ['required'],
                    'url'  => ['required', 'url']
                ]
            ],
        ];
    }
}
