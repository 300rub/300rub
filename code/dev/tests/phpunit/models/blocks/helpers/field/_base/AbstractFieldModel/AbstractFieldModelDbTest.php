<?php

// @codingStandardsIgnoreLine
namespace ss\tests\phpunit\models\blocks\helpers\field\_base\AbstractFieldModel;

use ss\models\blocks\helpers\field\FieldModel;
use ss\tests\phpunit\models\_abstract\_base\AbstractDbModelTest;

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
