<?php

namespace testS\tests\unit\models\blocks\block\_base\AbstractDesignBlockModel;

use testS\models\blocks\block\DesignBlockModel;
use testS\tests\unit\models\_abstract\_base\AbstractDbModelTest;

/**
 * Tests for the model DesignBlockModel
 */
class AbstractDesignBlockModelDbTest extends AbstractDbModelTest
{

    /**
     * Gets model name
     *
     * @return DesignBlockModel
     */
    protected function getNewModel()
    {
        return new DesignBlockModel();
    }
}
