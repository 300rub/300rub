<?php

namespace ss\tests\phpunit\models\blocks\image\_base\AbstractImageInstanceModel;

use ss\models\blocks\image\ImageInstanceModel;
use ss\tests\phpunit\models\_abstract\_base\AbstractDbModelTest;

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
