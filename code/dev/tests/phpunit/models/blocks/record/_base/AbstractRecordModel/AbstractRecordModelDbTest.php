<?php

namespace ss\tests\phpunit\models\blocks\record\_base\AbstractRecordModel;

use ss\models\blocks\record\RecordModel;
use ss\tests\phpunit\models\_abstract\_base\AbstractDbModelTest;

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
