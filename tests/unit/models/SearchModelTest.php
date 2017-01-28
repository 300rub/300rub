<?php

namespace testS\tests\unit\models;

use testS\models\SearchModel;

/**
 * Tests for the model SearchModel
 *
 * @package testS\tests\unit\models
 */
class SearchModelTest extends AbstractModelTest
{

    /**
     * Gets model name
     *
     * @return SearchModel
     */
    protected function getNewModel()
    {
        return new SearchModel();
    }
}