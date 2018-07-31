<?php

// @codingStandardsIgnoreLine
namespace ss\tests\phpunit\models\blocks\helpers\tab\_base\AbstractTabInstanceModel;

use ss\models\blocks\helpers\tab\TabInstanceModel;
use ss\tests\phpunit\models\_abstract\_base\AbstractDbModelTest;

/**
 * Tests for the model AbstractTabInstanceModel
 */
class AbstractTabInstanceModelDbTest extends AbstractDbModelTest
{

    /**
     * Gets model name
     *
     * @return TabInstanceModel
     */
    protected function getNewModel()
    {
        return new TabInstanceModel();
    }
}
