<?php

namespace testS\tests\unit\models\blocks\search\_base\AbstractSearchQueryModel;

use testS\models\blocks\search\SearchQueryModel;
use testS\tests\unit\models\_abstract\_base\AbstractDuplicateModelTest;

/**
 * Tests for the model AbstractSearchQueryModel
 */
class AbstractSearchQueryModelDuplicateTest extends AbstractDuplicateModelTest
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
     * Data provider for CRUD. Duplicate
     *
     * @return void
     */
    public function testDuplicate()
    {
        $this->duplicate(
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
                'text' => ['required'],
                'ip'   => ['ip'],
                'ua'   => ['required'],
                'uri'  => ['required'],
                'ref'  => ['required'],
            ]
        );
    }
}
