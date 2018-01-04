<?php

namespace testS\tests\unit\models\blocks\menu\_base\AbstractMenuInstanceModel;

use testS\models\blocks\menu\MenuInstanceModel;
use testS\tests\unit\models\_abstract\_base\AbstractDbModelTest;

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
