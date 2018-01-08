<?php

namespace testS\tests\unit\models\blocks\helpers\form\_base\AbstractFormModel;

use testS\models\blocks\helpers\form\FormModel;
use testS\tests\unit\models\_abstract\_base\AbstractDbModelTest;

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