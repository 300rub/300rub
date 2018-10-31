<?php

// @codingStandardsIgnoreLine
namespace ss\tests\phpunit\models\blocks\image\_base\AbstractDesignImageZoomModel;

use ss\models\blocks\image\DesignImageZoomModel;
use ss\tests\phpunit\models\_abstract\_base\AbstractDbModelTest;

/**
 * Tests for the model AbstractDesignImageZoomModel
 */
class AbstractDesignImageZoomModelDbTest extends AbstractDbModelTest
{

    /**
     * Gets model name
     *
     * @return DesignImageZoomModel
     */
    protected function getNewModel()
    {
        return new DesignImageZoomModel();
    }
}
