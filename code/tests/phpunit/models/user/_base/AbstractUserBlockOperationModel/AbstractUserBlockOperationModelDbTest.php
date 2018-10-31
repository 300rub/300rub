<?php

// @codingStandardsIgnoreLine
namespace ss\tests\phpunit\models\user\_base\AbstractUserBlockOperationModel;

use ss\models\user\UserBlockOperationModel;
use ss\tests\phpunit\models\_abstract\_base\AbstractDbModelTest;

/**
 * Tests for the model UserBlockOperationModel
 */
// @codingStandardsIgnoreLine
class AbstractUserBlockOperationModelDbTest extends AbstractDbModelTest
{

    /**
     * Gets model name
     *
     * @return UserBlockOperationModel
     */
    protected function getNewModel()
    {
        return new UserBlockOperationModel();
    }
}
