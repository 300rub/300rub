<?php

// @codingStandardsIgnoreLine
namespace ss\tests\phpunit\models\blocks\image\_base\AbstractDesignImageSliderModel;

use ss\models\blocks\image\DesignImageSliderModel;
use ss\tests\phpunit\models\_abstract\_base\AbstractDbModelTest;

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
