<?php

// @codingStandardsIgnoreLine
namespace testS\tests\unit\models\blocks\helpers\field\_base\AbstractFieldListValueModel;

use testS\models\blocks\helpers\field\FieldListValueModel;
use testS\tests\unit\models\_abstract\_base\AbstractDbModelTest;

/**
 * Tests for the model AbstractFieldListValueModel
 */
class AbstractFieldListValueModelDbTest extends AbstractDbModelTest
{

    /**
     * Gets model name
     *
     * @return FieldListValueModel
     */
    protected function getNewModel()
    {
        return new FieldListValueModel();
    }
}
