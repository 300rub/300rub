<?php

namespace testS\tests\unit\models\image\_base\AbstractImageGroupModel;

use testS\models\blocks\image\ImageGroupModel;
use testS\tests\unit\models\_abstract\_base\AbstractDbModelTest;

/**
 * Tests for the model AbstractImageGroupModel
 */
class AbstractImageGroupModelDbTest extends AbstractDbModelTest
{

    /**
     * Gets model name
     *
     * @return ImageGroupModel
     */
    protected function getNewModel()
    {
        return new ImageGroupModel();
    }
}
