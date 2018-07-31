<?php

namespace ss\tests\phpunit\models\blocks\helpers\form\_base\AbstractFormModel;

use ss\models\blocks\helpers\form\FormModel;
use ss\tests\phpunit\models\_abstract\_base\AbstractDbModelTest;

/**
 * Tests for the model AbstractFormModel
 */
class AbstractFormModelDbTest extends AbstractDbModelTest
{

    /**
     * Gets model name
     *
     * @return FormModel
     */
    protected function getNewModel()
    {
        return new FormModel();
    }
}
