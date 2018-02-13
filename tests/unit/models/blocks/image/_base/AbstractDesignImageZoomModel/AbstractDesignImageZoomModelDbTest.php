<?php

// @codingStandardsIgnoreLine
namespace ss\tests\unit\models\blocks\image\_base\AbstractDesignImageZoomModel;

use ss\models\blocks\image\DesignImageZoomModel;
use ss\tests\unit\models\_abstract\_base\AbstractDbModelTest;

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
