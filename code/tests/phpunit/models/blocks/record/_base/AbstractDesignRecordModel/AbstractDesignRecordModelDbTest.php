<?php

namespace ss\tests\phpunit\models\blocks\record\_base\AbstractDesignRecordModel;

use ss\models\blocks\record\DesignRecordModel;
use ss\tests\phpunit\models\_abstract\_base\AbstractDbModelTest;

/**
 * Tests for the model AbstractDesignRecordModel
 */
class AbstractDesignRecordModelDbTest extends AbstractDbModelTest
{

    /**
     * Gets model name
     *
     * @return DesignRecordModel
     */
    protected function getNewModel()
    {
        return new DesignRecordModel();
    }
}
