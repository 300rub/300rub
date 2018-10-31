<?php

namespace ss\tests\phpunit\models\sections\_base\AbstractGridLineModel;

use ss\models\sections\GridLineModel;
use ss\tests\phpunit\models\_abstract\_base\AbstractDbModelTest;

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
