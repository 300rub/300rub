<?php

namespace ss\tests\unit\models\blocks\menu\_base\AbstractMenuInstanceModel;

use ss\models\blocks\menu\MenuInstanceModel;
use ss\tests\unit\models\_abstract\_base\AbstractDbModelTest;

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
