<?php

namespace testS\tests\unit\models;

use testS\models\SearchQueryModel;

/**
 * Tests for the model SearchQueryModel
 *
 * @package testS\tests\unit\models
 */
class SearchQueryModelTest extends AbstractModelTest
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
}