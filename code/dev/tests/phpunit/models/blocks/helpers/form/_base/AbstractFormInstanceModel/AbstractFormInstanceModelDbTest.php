<?php

// @codingStandardsIgnoreLine
namespace ss\tests\phpunit\models\blocks\helpers\form\_base\AbstractFormInstanceModel;

use ss\models\blocks\helpers\form\FormInstanceModel;
use ss\tests\phpunit\models\_abstract\_base\AbstractDbModelTest;

/**
 * Tests for the model AbstractFormInstanceModel
 */
class AbstractFormInstanceModelDbTest extends AbstractDbModelTest
{

    /**
     * Gets model name
     *
     * @return FormInstanceModel
     */
    protected function getNewModel()
    {
        return new FormInstanceModel();
    }
}
