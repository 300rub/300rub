<?php

// @codingStandardsIgnoreLine
namespace testS\tests\unit\models\blocks\image\_base\AbstractDesignImageSimpleModel;

use testS\models\blocks\image\DesignImageSimpleModel;
use testS\tests\unit\models\_abstract\_base\AbstractDbModelTest;

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
