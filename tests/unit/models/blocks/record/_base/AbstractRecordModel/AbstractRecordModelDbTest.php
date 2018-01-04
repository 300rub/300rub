<?php

namespace testS\tests\unit\models\blocks\record\_base\AbstractRecordModel;

use testS\models\blocks\record\RecordModel;
use testS\tests\unit\models\_abstract\_base\AbstractDbModelTest;

/**
 * Tests for the model AbstractRecordModel
 */
class AbstractRecordModelDbTest extends AbstractDbModelTest
{

    /**
     * Gets model name
     *
     * @return RecordModel
     */
    protected function getNewModel()
    {
        return new RecordModel();
    }
}
