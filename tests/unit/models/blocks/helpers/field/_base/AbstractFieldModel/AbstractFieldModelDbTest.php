<?php

// @codingStandardsIgnoreLine
namespace testS\tests\unit\models\blocks\helpers\field\_base\AbstractFieldModel;

use testS\models\blocks\helpers\field\FieldModel;
use testS\tests\unit\models\_abstract\_base\AbstractDbModelTest;

/**
 * Tests for the model AbstractFieldModel
 */
class AbstractFieldModelDbTest extends AbstractDbModelTest
{

    /**
     * Gets model name
     *
     * @return FieldModel
     */
    protected function getNewModel()
    {
        return new FieldModel();
    }
}
