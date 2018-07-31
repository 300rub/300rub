<?php

// @codingStandardsIgnoreLine
namespace ss\tests\phpunit\models\blocks\helpers\field\_base\AbstractFieldInstanceModel;

use ss\models\blocks\helpers\field\FieldInstanceModel;
use ss\tests\phpunit\models\_abstract\_base\AbstractDbModelTest;

/**
 * Tests for the model AbstractFieldInstanceModel
 */
class AbstractFieldInstanceModelDbTest extends AbstractDbModelTest
{

    /**
     * Gets model name
     *
     * @return FieldInstanceModel
     */
    protected function getNewModel()
    {
        return new FieldInstanceModel();
    }
}
