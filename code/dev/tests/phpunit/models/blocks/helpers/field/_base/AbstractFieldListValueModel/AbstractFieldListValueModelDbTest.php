<?php

// @codingStandardsIgnoreLine
namespace ss\tests\phpunit\models\blocks\helpers\field\_base\AbstractFieldListValueModel;

use ss\models\blocks\helpers\field\FieldListValueModel;
use ss\tests\phpunit\models\_abstract\_base\AbstractDbModelTest;

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
