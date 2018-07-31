<?php

// @codingStandardsIgnoreLine
namespace ss\tests\phpunit\models\blocks\record\_base\AbstractDesignRecordCloneModel;

use ss\models\blocks\record\DesignRecordCloneModel;
use ss\tests\phpunit\models\_abstract\_base\AbstractDbModelTest;

/**
 * Tests for the model AbstractDesignRecordCloneModel
 */
class AbstractDesignRecordCloneModelDbTest extends AbstractDbModelTest
{

    /**
     * Gets model name
     *
     * @return DesignRecordCloneModel
     */
    protected function getNewModel()
    {
        return new DesignRecordCloneModel();
    }
}
