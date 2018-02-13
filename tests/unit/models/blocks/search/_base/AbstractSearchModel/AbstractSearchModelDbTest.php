<?php

namespace ss\tests\unit\models\blocks\search\_base\AbstractSearchModel;

use ss\models\blocks\search\SearchModel;
use ss\tests\unit\models\_abstract\_base\AbstractDbModelTest;

/**
 * Tests for the model AbstractSearchModel
 */
class AbstractSearchModelDbTest extends AbstractDbModelTest
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
