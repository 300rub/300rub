<?php

namespace ss\tests\phpunit\models\blocks\block\_base\AbstractDesignBlockModel;

use ss\models\blocks\block\DesignBlockModel;
use ss\tests\phpunit\models\_abstract\_base\AbstractDbModelTest;

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
