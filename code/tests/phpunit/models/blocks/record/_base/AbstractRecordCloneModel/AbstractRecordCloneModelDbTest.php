<?php

// @codingStandardsIgnoreLine
namespace ss\tests\phpunit\models\blocks\record\_base\AbstractRecordCloneModel;

use ss\models\blocks\record\RecordCloneModel;
use ss\tests\phpunit\models\_abstract\_base\AbstractDbModelTest;

/**
 * Tests for the model AbstractRecordCloneModel
 */
class AbstractRecordCloneModelDbTest extends AbstractDbModelTest
{

    /**
     * Gets model name
     *
     * @return RecordCloneModel
     */
    protected function getNewModel()
    {
        return new RecordCloneModel();
    }
}
