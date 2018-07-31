<?php

// @codingStandardsIgnoreLine
namespace ss\tests\phpunit\models\blocks\record\_base\AbstractRecordInstanceModel;

use ss\models\blocks\record\RecordInstanceModel;
use ss\tests\phpunit\models\_abstract\_base\AbstractDbModelTest;

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
