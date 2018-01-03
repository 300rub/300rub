<?php

// @codingStandardsIgnoreLine
namespace testS\tests\unit\models\blocks\helpers\form\_base\AbstractDesignFormModel;

use testS\models\blocks\helpers\form\DesignFormModel;
use testS\tests\unit\models\_abstract\_base\AbstractDbModelTest;

/**
 * Tests for the model AbstractDesignFormModel
 */
class AbstractDesignFormModelDbTest extends AbstractDbModelTest
{

    /**
     * Gets model name
     *
     * @return DesignFormModel
     */
    protected function getNewModel()
    {
        return new DesignFormModel();
    }
}
