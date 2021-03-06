<?php

namespace ss\tests\phpunit\models\blocks\search\_base\AbstractSearchQueryModel;

use ss\models\blocks\search\SearchQueryModel;
use ss\tests\phpunit\models\_abstract\_base\AbstractEmptyModelTest;

/**
 * Tests for the model AbstractSearchQueryModel
 */
class AbstractSearchQueryModelEmptyTest extends AbstractEmptyModelTest
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
                    'text' => ['required'],
                    'ip'   => ['ip'],
                    'ua'   => ['required'],
                    'uri'  => ['required'],
                    'ref'  => ['required'],
                ],
            ],
            'empty2' => [
                [
                    'searchId' => '',
                    'text'     => '',
                    'date'     => '',
                    'ip'       => '',
                    'ua'       => '',
                    'uri'      => '',
                    'ref'      => '',
                ],
                [
                    'text' => ['required'],
                    'ip'   => ['ip'],
                    'ua'   => ['required'],
                    'uri'  => ['required'],
                    'ref'  => ['required'],
                ],
            ],
            'empty3' => [
                [
                    'searchId' => '',
                    'text'     => 'text',
                    'date'     => 'now',
                    'ip'       => '127.0.0.1',
                    'ua'       => 'FF',
                    'uri'      => '/bla/bla',
                    'ref'      => '/ref/ref',
                ],
                [],
                null,
                null,
                self::EXCEPTION_MODEL
            ]
        ];
    }
}
