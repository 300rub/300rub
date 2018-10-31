<?php

namespace ss\tests\phpunit\models\blocks\search\_base\AbstractSearchQueryModel;

use ss\models\blocks\search\SearchQueryModel;
use ss\tests\phpunit\models\_abstract\_base\AbstractIncorrectModelTest;

/**
 * Tests for the model AbstractSearchQueryModel
 */
class AbstractSearchQueryModelIncorrectTest extends AbstractIncorrectModelTest
{

    /**
     * Gets model name
     *
     * @return SearchQueryModel
     */
    protected function getNewModel()
    {
        return new SearchQueryModel();
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
                    'searchId' => 1,
                    'text'     => 'text',
                    'date'     => 'now',
                    'ip'       => '127.0.0.1',
                    'ua'       => 'FF',
                    'uri'      => '/bla/bla',
                    'ref'      => '/ref/ref',
                ],
                [
                    'searchId' => 1,
                    'text'     => 'text',
                    'ip'       => '127.0.0.1',
                    'ua'       => 'FF',
                    'uri'      => '/bla/bla',
                    'ref'      => '/ref/ref',
                ],
                [
                    'searchId' => 2,
                    'text'     => 'text 2',
                    'ip'       => '127.0.0.2',
                    'ua'       => 'FF 2',
                    'uri'      => '/bla/bla2',
                    'ref'      => '/ref/ref2',
                ],
                [
                    'searchId' => 1,
                    'text'     => 'text',
                    'ip'       => '127.0.0.1',
                    'ua'       => 'FF',
                    'uri'      => '/bla/bla',
                    'ref'      => '/ref/ref',
                ],
            ],
            'incorrect2' => [
                [
                    'searchId' => 'incorrect',
                    'text'     => 'incorrect',
                    'date'     => 'incorrect',
                    'ip'       => 'incorrect',
                    'ua'       => 'incorrect',
                    'uri'      => 'incorrect',
                    'ref'      => 'incorrect',
                ],
                [
                    'ip' => ['ip'],
                ]
            ],
            'incorrect3' => [
                [
                    'searchId' => ' 1 ',
                    'text'     => '<b>incorrect</b>',
                    'date'     => 123,
                    'ip'       => '   127.0.0.1  ',
                    'ua'       => 111,
                    'uri'      => 222,
                    'ref'      => 333,
                ],
                [
                    'searchId' => 1,
                    'text'     => 'incorrect',
                    'ip'       => '127.0.0.1',
                    'ua'       => '111',
                    'uri'      => '222',
                    'ref'      => '333',
                ],
            ],
            'incorrect4' => [
                [
                    'searchId' => 1,
                    'text'     => $this->generateStringWithLength(256),
                    'date'     => 'now',
                    'ip'       => '127.0.0.1',
                    'ua'       => $this->generateStringWithLength(256),
                    'uri'      => $this->generateStringWithLength(256),
                    'ref'      => $this->generateStringWithLength(256),
                ],
                [
                    'text' => ['maxLength'],
                    'ua'   => ['maxLength'],
                    'uri'  => ['maxLength'],
                    'ref'  => ['maxLength'],
                ]
            ]
        ];
    }
}
