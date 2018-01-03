<?php

namespace testS\tests\unit\models\image\_base\AbstractDesignImageZoomModel;

use testS\models\blocks\image\DesignImageZoomModel;
use testS\tests\unit\models\_abstract\_base\AbstractDbModelTest;

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
