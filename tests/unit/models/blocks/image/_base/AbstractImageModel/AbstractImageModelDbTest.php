<?php

namespace testS\tests\unit\models\blocks\image\_base\AbstractImageModel;

use testS\models\blocks\image\ImageModel;
use testS\tests\unit\models\_abstract\_base\AbstractDbModelTest;

/**
 * Tests for the model AbstractImageModel
 */
class AbstractImageModelDbTest extends AbstractDbModelTest
{

    /**
     * Gets model name
     *
     * @return ImageModel
     */
    protected function getNewModel()
    {
        return new ImageModel();
    }
}
