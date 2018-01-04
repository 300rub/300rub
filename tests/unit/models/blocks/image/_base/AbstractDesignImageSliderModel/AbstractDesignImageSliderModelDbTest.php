<?php

// @codingStandardsIgnoreLine
namespace testS\tests\unit\models\blocks\image\_base\AbstractDesignImageSliderModel;

use testS\models\blocks\image\DesignImageSliderModel;
use testS\tests\unit\models\_abstract\_base\AbstractDbModelTest;

/**
 * Tests for the model AbstractDesignImageSliderModel
 */
class AbstractDesignImageSliderModelDbTest extends AbstractDbModelTest
{

    /**
     * Gets model name
     *
     * @return DesignImageSliderModel
     */
    protected function getNewModel()
    {
        return new DesignImageSliderModel();
    }
}
