<?php

namespace ss\tests\unit\models\blocks\menu\_base\AbstractMenuModel;

use ss\models\blocks\menu\MenuModel;
use ss\tests\unit\models\_abstract\_base\AbstractDbModelTest;

/**
 * Tests for the model AbstractMenuModel
 */
class AbstractMenuModelDbTest extends AbstractDbModelTest
{

    /**
     * Gets model name
     *
     * @return MenuModel
     */
    protected function getNewModel()
    {
        return new MenuModel();
    }
}
