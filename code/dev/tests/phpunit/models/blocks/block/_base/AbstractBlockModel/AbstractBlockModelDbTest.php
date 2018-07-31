<?php

namespace ss\tests\phpunit\models\blocks\block\_base\AbstractBlockModel;

use ss\models\blocks\block\BlockModel;
use ss\tests\phpunit\models\_abstract\_base\AbstractDbModelTest;

/**
 * Tests for the model BlockModel
 */
class AbstractBlockModelDbTest extends AbstractDbModelTest
{

    /**
     * Gets model name
     *
     * @return BlockModel
     */
    protected function getNewModel()
    {
        return new BlockModel();
    }
}
