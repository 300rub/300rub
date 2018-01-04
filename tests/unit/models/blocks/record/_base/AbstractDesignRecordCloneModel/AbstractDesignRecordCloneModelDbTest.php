<?php

// @codingStandardsIgnoreLine
namespace testS\tests\unit\models\blocks\record\_base\AbstractDesignRecordCloneModel;

use testS\models\blocks\record\DesignRecordCloneModel;
use testS\tests\unit\models\_abstract\_base\AbstractDbModelTest;

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
