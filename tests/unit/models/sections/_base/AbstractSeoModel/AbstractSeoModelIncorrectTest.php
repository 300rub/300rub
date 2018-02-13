<?php

namespace ss\tests\unit\models\sections\_base\AbstractSeoModel;

use ss\models\sections\SeoModel;
use ss\tests\unit\models\_abstract\_base\AbstractIncorrectModelTest;

/**
 * Tests for the model SeoModel
 */
class AbstractSeoModelIncorrectTest extends AbstractIncorrectModelTest
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
     * Data provider for CRUD. Incorrect values
     *
     * @return array
     */
    protected function getDataProviderIncorrect()
    {
        return array_merge(
            $this->_getDataProviderIncorrect1(),
            $this->_getDataProviderIncorrect2()
        );
    }

    /**
     * Data provider for CRUD. Incorrect values
     *
     * @return array
     */
    private function _getDataProviderIncorrect1()
    {
        return [
            'incorrect1' => [
                [
                    'name'        => 1,
                    'url'         => 2,
                    'title'       => 3,
                    'keywords'    => 4,
                    'description' => 5
                ],
                [
                    'name'        => '1',
                    'url'         => '2',
                    'title'       => '3',
                    'keywords'    => '4',
                    'description' => '5'
                ],
                [
                    'name'        => 1.5,
                    'url'         => 2.5,
                    'title'       => 3.5,
                    'keywords'    => 4.5,
                    'description' => 5.5
                ],
                [
                    'name'        => '1.5',
                    'url'         => '25',
                    'title'       => '3.5',
                    'keywords'    => '4.5',
                    'description' => '5.5'
                ],
            ],
            'incorrect2' => [
                [
                    'name'        => true,
                    'url'         => true,
                    'title'       => true,
                    'keywords'    => true,
                    'description' => true
                ],
                [
                    'name'        => '1',
                    'url'         => '1',
                    'title'       => '1',
                    'keywords'    => '1',
                    'description' => '1'
                ],
                [
                    'name'        => false,
                    'url'         => false,
                    'title'       => false,
                    'keywords'    => false,
                    'description' => false
                ],
                [
                    'name' => ['required'],
                    'url'  => ['required', 'url']
                ]
            ],
            'incorrect3' => [
                [
                    'name'        => [],
                    'url'         => [],
                    'title'       => [],
                    'keywords'    => [],
                    'description' => []
                ],
                [
                    'name' => ['required'],
                    'url'  => ['required', 'url']
                ]
            ],
        ];
    }

    /**
     * Data provider for CRUD. Incorrect values
     *
     * @return array
     */
    private function _getDataProviderIncorrect2()
    {
        return [
            'incorrect4' => [
                [
                    'name'        => ['name' => 'name', 'value'],
                    'url'         => ['name' => 'name', 'value'],
                    'title'       => ['name' => 'name', 'value'],
                    'keywords'    => ['name' => 'name', 'value'],
                    'description' => ['name' => 'name', 'value'],
                ],
                [
                    'name' => ['required'],
                    'url'  => ['required', 'url']
                ]
            ],
            'incorrect5' => [
                [
                    'name'        => new \stdClass(),
                    'url'         => new \stdClass(),
                    'title'       => new \stdClass(),
                    'keywords'    => new \stdClass(),
                    'description' => new \stdClass(),
                ],
                [
                    'name' => ['required'],
                    'url'  => ['required', 'url']
                ]
            ],
            'incorrect6' => [
                [
                    'name'        => $this->generateStringWithLength(256),
                    'url'         => $this->generateStringWithLength(256),
                    'title'       => $this->generateStringWithLength(256),
                    'keywords'    => $this->generateStringWithLength(256),
                    'description' => $this->generateStringWithLength(256),
                ],
                [
                    'name'        => ['maxLength'],
                    'url'         => ['maxLength'],
                    'title'       => ['maxLength'],
                    'keywords'    => ['maxLength'],
                    'description' => ['maxLength'],
                ]
            ],
            'incorrect7' => [
                [
                    'name'        => $this->getStringWithTags('Name'),
                    'url'         => $this->getStringWithTags('url 1'),
                    'title'       => $this->getStringWithTags(' Title '),
                    'keywords'
                        => $this->getStringWithTags(' keywords, keywords '),
                    'description' => $this->getStringWithTags(' description '),
                ],
                [
                    'name'        => 'Name',
                    'url'         => 'url-1',
                    'title'       => 'Title',
                    'keywords'    => 'keywords, keywords',
                    'description' => 'description',
                ]
            ],
        ];
    }
}
