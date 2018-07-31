<?php

// @codingStandardsIgnoreLine
namespace ss\tests\phpunit\models\blocks\helpers\field\_base\AbstractFieldGroupModel;

use ss\models\blocks\helpers\field\FieldGroupModel;
use ss\tests\phpunit\models\_abstract\_base\AbstractDbModelTest;

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
