<?php

namespace testS\tests\unit\models\sections\_base\AbstractGridLineModel;

use testS\models\sections\GridLineModel;
use testS\tests\unit\models\_abstract\_base\AbstractDbModelTest;

/**
 * Tests for the model GridLineModel
 */
class AbstractGridLineModelDbTest extends AbstractDbModelTest
{

    /**
     * Gets model name
     *
     * @return GridLineModel
     */
    protected function getNewModel()
    {
        return new GridLineModel();
    }
}
