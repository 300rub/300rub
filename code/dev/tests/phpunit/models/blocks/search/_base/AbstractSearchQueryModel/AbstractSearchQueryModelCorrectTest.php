<?php

namespace ss\tests\phpunit\models\blocks\search\_base\AbstractSearchQueryModel;

use ss\models\blocks\search\SearchQueryModel;
use ss\tests\phpunit\models\_abstract\_base\AbstractCorrectModelTest;

/**
 * Tests for the model AbstractSearchQueryModel
 */
class AbstractSearchQueryModelCorrectTest extends AbstractCorrectModelTest
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
     * Data provider for CRUD. Correct values
     *
     * @return array
     */
    protected function getDataProviderCorrect()
    {
        return [
            'correct1' => [
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
                ]
            ]
        ];
    }
}
