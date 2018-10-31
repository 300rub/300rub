<?php

namespace ss\tests\phpunit\models\blocks\image\_base\AbstractImageModel;

use ss\models\blocks\image\ImageModel;
use ss\tests\phpunit\models\_abstract\_base\AbstractDbModelTest;

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
