<?php

namespace ss\tests\phpunit\models\blocks\menu\_base\AbstractDesignMenuModel;

use ss\models\blocks\menu\DesignMenuModel;
use ss\tests\phpunit\models\_abstract\_base\AbstractDbModelTest;

/**
 * Tests for the model AbstractDesignMenuModel
 */
class AbstractDesignMenuModelDbTest extends AbstractDbModelTest
{

    /**
     * Gets model name
     *
     * @return DesignMenuModel
     */
    protected function getNewModel()
    {
        return new DesignMenuModel();
    }
}
