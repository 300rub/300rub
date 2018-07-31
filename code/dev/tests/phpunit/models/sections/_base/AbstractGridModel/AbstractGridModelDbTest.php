<?php

namespace ss\tests\phpunit\models\sections\_base\AbstractGridModel;

use ss\models\sections\GridModel;
use ss\tests\phpunit\models\_abstract\_base\AbstractDbModelTest;

/**
 * Tests for the model GridModel
 */
class AbstractGridModelDbTest extends AbstractDbModelTest
{

    /**
     * Gets model name
     *
     * @return GridModel
     */
    protected function getNewModel()
    {
        return new GridModel();
    }
}
