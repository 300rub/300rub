<?php

// @codingStandardsIgnoreLine
namespace testS\tests\unit\models\blocks\helpers\field\_base\AbstractFieldGroupModel;

use testS\models\blocks\helpers\field\FieldGroupModel;
use testS\tests\unit\models\_abstract\_base\AbstractDbModelTest;

/**
 * Tests for the model AbstractFieldGroupModel
 */
class AbstractFieldGroupModelDbTest extends AbstractDbModelTest
{

    /**
     * Gets model name
     *
     * @return FieldGroupModel
     */
    protected function getNewModel()
    {
        return new FieldGroupModel();
    }
}
