<?php

namespace ss\tests\unit\models\sections\_base\AbstractSeoModel;

use ss\models\sections\SeoModel;
use ss\tests\unit\models\_abstract\_base\AbstractCorrectModelTest;

/**
 * Tests for the model SeoModel
 */
class AbstractSeoModelCorrectTest extends AbstractCorrectModelTest
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
     * Data provider for CRUD. Correct values
     *
     * @return array
     */
    protected function getDataProviderCorrect()
    {
        return [
            'correct1' => [
                [
                    'name'        => 'Name 1',
                    'url'         => 'url-1',
                    'title'       => '',
                    'keywords'    => '',
                    'description' => ''
                ],
                [
                    'name'        => 'Name 1',
                    'url'         => 'url-1',
                    'title'       => '',
                    'keywords'    => '',
                    'description' => ''
                ],
                [
                    'name'        => 'Name 2',
                    'url'         => 'url-2',
                    'title'       => 'title',
                    'keywords'    => 'keywords',
                    'description' => 'description'
                ],
                [
                    'name'        => 'Name 2',
                    'url'         => 'url-2',
                    'title'       => 'title',
                    'keywords'    => 'keywords',
                    'description' => 'description'
                ],
            ],
            'correct2' => [
                [
                    'name' => 'Name 1',
                ],
                [
                    'name'        => 'Name 1',
                    'url'         => 'name-1',
                    'title'       => '',
                    'keywords'    => '',
                    'description' => ''
                ],
                [
                    'name'     => 'Name 2',
                    'keywords' => 'keywords',
                ],
                [
                    'name'        => 'Name 2',
                    'url'         => 'name-1',
                    'title'       => '',
                    'keywords'    => 'keywords',
                    'description' => ''
                ],
            ],
            'correct3' => [
                [
                    'name'        => 'Name',
                    'url'         => 'url',
                    'title'       => 'title',
                    'keywords'    => 'keywords',
                    'description' => 'description'
                ],
                [
                    'name'        => 'Name',
                    'url'         => 'url',
                    'title'       => 'title',
                    'keywords'    => 'keywords',
                    'description' => 'description'
                ],
                [
                    'name'        => 'Name 2',
                    'url'         => 'url-2',
                    'title'       => '',
                    'keywords'    => '',
                    'description' => ''
                ],
                [
                    'name'        => 'Name 2',
                    'url'         => 'url-2',
                    'title'       => '',
                    'keywords'    => '',
                    'description' => ''
                ],
            ]
        ];
    }
}
