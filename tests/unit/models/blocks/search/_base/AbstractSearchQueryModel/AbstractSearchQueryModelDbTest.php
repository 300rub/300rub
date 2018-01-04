<?php

namespace testS\tests\unit\models\blocks\search\_base\AbstractSearchQueryModel;

use testS\models\blocks\search\SearchQueryModel;
use testS\tests\unit\models\_abstract\_base\AbstractDbModelTest;

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
