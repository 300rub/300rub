<?php

// @codingStandardsIgnoreLine
namespace ss\tests\phpunit\models\blocks\image\_base\AbstractDesignImageSimpleModel;

use ss\models\blocks\image\DesignImageSimpleModel;
use ss\tests\phpunit\models\_abstract\_base\AbstractDbModelTest;

/**
 * Tests for the model AbstractDesignImageSimpleModel
 */
class AbstractDesignImageSimpleModelDbTest extends AbstractDbModelTest
{

    /**
     * Gets model name
     *
     * @return DesignImageSimpleModel
     */
    protected function getNewModel()
    {
        return new DesignImageSimpleModel();
    }
}
