<?php

namespace ss\tests\phpunit\models\blocks\menu\_base\AbstractMenuInstanceModel;

use ss\models\blocks\menu\MenuInstanceModel;
use ss\tests\phpunit\models\_abstract\_base\AbstractDbModelTest;

/**
 * Tests for the model AbstractMenuInstanceModel
 */
class AbstractMenuInstanceModelDbTest extends AbstractDbModelTest
{

    /**
     * Gets model name
     *
     * @return MenuInstanceModel
     */
    protected function getNewModel()
    {
        return new MenuInstanceModel();
    }
}
