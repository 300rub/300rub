<?php

// @codingStandardsIgnoreLine
namespace testS\tests\unit\models\user\_base\AbstractUserBlockGroupOperationModel;

use testS\models\user\UserBlockGroupOperationModel;
use testS\tests\unit\models\_abstract\_base\AbstractDbModelTest;

/**
 * Tests for the model UserBlockGroupOperationModel
 */
// @codingStandardsIgnoreLine
class AbstractUserBlockGroupOperationModelDbTest extends AbstractDbModelTest
{

    /**
     * Gets model name
     *
     * @return UserBlockGroupOperationModel
     */
    protected function getNewModel()
    {
        return new UserBlockGroupOperationModel();
    }
}
