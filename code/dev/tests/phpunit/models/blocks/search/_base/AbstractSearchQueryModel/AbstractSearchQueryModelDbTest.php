<?php

namespace ss\tests\phpunit\models\blocks\search\_base\AbstractSearchQueryModel;

use ss\models\blocks\search\SearchQueryModel;
use ss\tests\phpunit\models\_abstract\_base\AbstractDbModelTest;

/**
 * Tests for the model AbstractSearchQueryModel
 */
class AbstractSearchQueryModelDbTest extends AbstractDbModelTest
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
