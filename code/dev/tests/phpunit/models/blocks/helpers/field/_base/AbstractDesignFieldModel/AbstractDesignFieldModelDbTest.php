<?php

// @codingStandardsIgnoreLine
namespace ss\tests\phpunit\models\blocks\helpers\field\_base\AbstractDesignFieldModel;

use ss\models\blocks\helpers\field\DesignFieldModel;
use ss\tests\phpunit\models\_abstract\_base\AbstractDbModelTest;

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
