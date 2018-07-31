<?php

// @codingStandardsIgnoreLine
namespace ss\tests\phpunit\models\blocks\helpers\form\_base\AbstractDesignFormModel;

use ss\models\blocks\helpers\form\DesignFormModel;
use ss\tests\phpunit\models\_abstract\_base\AbstractDbModelTest;

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
