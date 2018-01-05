<?php

namespace testS\tests\unit\models\sections\_base\AbstractGridModel;

use testS\models\sections\GridModel;
use testS\tests\unit\models\_abstract\_base\AbstractDbModelTest;

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
