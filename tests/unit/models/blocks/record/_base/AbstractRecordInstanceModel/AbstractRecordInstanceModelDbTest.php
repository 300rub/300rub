<?php

// @codingStandardsIgnoreLine
namespace testS\tests\unit\models\blocks\record\_base\AbstractRecordInstanceModel;

use testS\models\blocks\record\RecordInstanceModel;
use testS\tests\unit\models\_abstract\_base\AbstractDbModelTest;

/**
 * Tests for the model AbstractRecordInstanceModel
 */
class AbstractRecordInstanceModelDbTest extends AbstractDbModelTest
{

    /**
     * Gets model name
     *
     * @return RecordInstanceModel
     */
    protected function getNewModel()
    {
        return new RecordInstanceModel();
    }
}
