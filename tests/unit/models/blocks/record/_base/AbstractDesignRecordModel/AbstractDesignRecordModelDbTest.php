<?php

namespace testS\tests\unit\models\blocks\record\_base\AbstractDesignRecordModel;

use testS\models\blocks\record\DesignRecordModel;
use testS\tests\unit\models\_abstract\_base\AbstractDbModelTest;

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
