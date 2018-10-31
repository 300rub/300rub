<?php

// @codingStandardsIgnoreLine
namespace ss\tests\phpunit\models\blocks\helpers\tab\_base\AbstractTabGroupModel;

use ss\models\blocks\helpers\tab\TabGroupModel;
use ss\tests\phpunit\models\_abstract\_base\AbstractDbModelTest;

/**
 * Tests for the model AbstractTabGroupModel
 */
class AbstractTabGroupModelDbTest extends AbstractDbModelTest
{

    /**
     * Gets model name
     *
     * @return TabGroupModel
     */
    protected function getNewModel()
    {
        return new TabGroupModel();
    }
}
