<?php

// @codingStandardsIgnoreLine
namespace testS\tests\unit\models\blocks\helpers\form\_base\AbstractFormInstanceModel;

use testS\models\blocks\helpers\form\FormInstanceModel;
use testS\tests\unit\models\_abstract\_base\AbstractDbModelTest;

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
