<?php

// @codingStandardsIgnoreLine
namespace ss\tests\phpunit\models\blocks\helpers\tab\_base\AbstractDesignTabModel;

use ss\models\blocks\helpers\tab\DesignTabModel;
use ss\tests\phpunit\models\_abstract\_base\AbstractDbModelTest;

/**
 * Tests for the model AbstractDesignTabModel
 */
class AbstractDesignTabModelDbTest extends AbstractDbModelTest
{

    /**
     * Gets model name
     *
     * @return DesignTabModel
     */
    protected function getNewModel()
    {
        return new DesignTabModel();
    }
}
