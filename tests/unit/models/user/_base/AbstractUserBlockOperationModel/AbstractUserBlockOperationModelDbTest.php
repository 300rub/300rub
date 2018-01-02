<?php

// @codingStandardsIgnoreLine
namespace testS\tests\unit\models\user\_base\AbstractUserBlockOperationModel;

use testS\models\user\UserBlockOperationModel;
use testS\tests\unit\models\_abstract\_base\AbstractDbModelTest;

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
