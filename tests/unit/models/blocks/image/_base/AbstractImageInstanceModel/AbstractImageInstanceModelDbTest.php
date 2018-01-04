<?php

namespace testS\tests\unit\models\blocks\image\_base\AbstractImageInstanceModel;

use testS\models\blocks\image\ImageInstanceModel;
use testS\tests\unit\models\_abstract\_base\AbstractDbModelTest;

/**
 * Tests for the model AbstractImageInstanceModel
 */
class AbstractImageInstanceModelDbTest extends AbstractDbModelTest
{

    /**
     * Gets model name
     *
     * @return ImageInstanceModel
     */
    protected function getNewModel()
    {
        return new ImageInstanceModel();
    }
}
