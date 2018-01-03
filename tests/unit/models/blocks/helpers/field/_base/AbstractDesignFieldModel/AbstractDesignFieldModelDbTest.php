<?php

// @codingStandardsIgnoreLine
namespace testS\tests\unit\models\blocks\helpers\field\_base\AbstractDesignFieldModel;

use testS\models\blocks\helpers\field\DesignFieldModel;
use testS\tests\unit\models\_abstract\_base\AbstractDbModelTest;

/**
 * Tests for the model AbstractDesignFieldModel
 */
class AbstractDesignFieldModelDbTest extends AbstractDbModelTest
{

    /**
     * Gets model name
     *
     * @return DesignFieldModel
     */
    protected function getNewModel()
    {
        return new DesignFieldModel();
    }
}
