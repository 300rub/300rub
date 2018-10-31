<?php

namespace ss\tests\phpunit\models\sections\_base\AbstractSeoModel;

use ss\models\sections\SeoModel;
use ss\tests\phpunit\models\_abstract\_base\AbstractIncorrectModelTest;

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
                    'alias'         => 2,
                    'title'       => 3,
                    'keywords'    => 4,
                    'description' => 5
                ],
                [
                    'name'        => '1',
                    'alias'         => '2',
                    'title'       => '3',
                    'keywords'    => '4',
                    'description' => '5'
                ],
                [
                    'name'        => 1.5,
                    'alias'         => 2.5,
                    'title'       => 3.5,
                    'keywords'    => 4.5,
                    'description' => 5.5
                ],
                [
                    'name'        => '1.5',
                    'alias'         => '25',
                    'title'       => '3.5',
                    'keywords'    => '4.5',
                    'description' => '5.5'
                ],
            ],
            'incorrect2' => [
                [
                    'name'        => true,
                    'alias'         => true,
                    'title'       => true,
                    'keywords'    => true,
                    'description' => true
                ],
                [
                    'name'        => '1',
                    'alias'         => '1',
                    'title'       => '1',
                    'keywords'    => '1',
                    'description' => '1'
                ],
                [
                    'name'        => false,
                    'alias'         => false,
                    'title'       => false,
                    'keywords'    => false,
                    'description' => false
                ],
                [
                    'name' => ['required'],
                    'alias'  => ['required', 'alias']
                ]
            ],
            'incorrect3' => [
                [
                    'name'        => [],
                    'alias'         => [],
                    'title'       => [],
                    'keywords'    => [],
                    'description' => []
                ],
                [
                    'name' => ['required'],
                    'alias'  => ['required', 'alias']
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
                    'alias'         => ['name' => 'name', 'value'],
                    'title'       => ['name' => 'name', 'value'],
                    'keywords'    => ['name' => 'name', 'value'],
                    'description' => ['name' => 'name', 'value'],
                ],
                [
                    'name' => ['required'],
                    'alias'  => ['required', 'alias']
                ]
            ],
            'incorrect5' => [
                [
                    'name'        => new \stdClass(),
                    'alias'         => new \stdClass(),
                    'title'       => new \stdClass(),
                    'keywords'    => new \stdClass(),
                    'description' => new \stdClass(),
                ],
                [
                    'name' => ['required'],
                    'alias'  => ['required', 'alias']
                ]
            ],
            'incorrect6' => [
                [
                    'name'        => $this->generateStringWithLength(256),
                    'alias'         => $this->generateStringWithLength(256),
                    'title'       => $this->generateStringWithLength(256),
                    'keywords'    => $this->generateStringWithLength(256),
                    'description' => $this->generateStringWithLength(256),
                ],
                [
                    'name'        => ['maxLength'],
                    'alias'         => ['maxLength'],
                    'title'       => ['maxLength'],
                    'keywords'    => ['maxLength'],
                    'description' => ['maxLength'],
                ]
            ],
            'incorrect7' => [
                [
                    'name'        => $this->getStringWithTags('Name'),
                    'alias'         => $this->getStringWithTags('alias 1'),
                    'title'       => $this->getStringWithTags(' Title '),
                    'keywords'
                        => $this->getStringWithTags(' keywords, keywords '),
                    'description' => $this->getStringWithTags(' description '),
                ],
                [
                    'name'        => 'Name',
                    'alias'         => 'alias-1',
                    'title'       => 'Title',
                    'keywords'    => 'keywords, keywords',
                    'description' => 'description',
                ]
            ],
        ];
    }
}
