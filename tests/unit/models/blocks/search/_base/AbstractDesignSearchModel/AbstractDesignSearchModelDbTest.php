<?php

namespace testS\tests\unit\models\blocks\search\_base\AbstractDesignSearchModel;

use testS\models\blocks\search\DesignSearchModel;
use testS\tests\unit\models\_abstract\_base\AbstractDbModelTest;

/**
 * Tests for the model AbstractDesignSearchModel
 */
class AbstractDesignSearchModelDbTest extends AbstractDbModelTest
{

    /**
     * Gets model name
     *
     * @return DesignSearchModel
     */
    protected function getNewModel()
    {
        return new DesignSearchModel();
    }
}
