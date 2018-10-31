<?php

// @codingStandardsIgnoreLine
namespace ss\tests\phpunit\models\user\_base\AbstractUserSettingsOperationModel;

use ss\models\user\UserSettingsOperationModel;
use ss\tests\phpunit\models\_abstract\_base\AbstractDbModelTest;

/**
 * Tests for the model UserSettingsOperationModel
 */
// @codingStandardsIgnoreLine
class AbstractUserSettingsOperationModelDbTest extends AbstractDbModelTest
{

    /**
     * Gets model name
     *
     * @return UserSettingsOperationModel
     */
    protected function getNewModel()
    {
        return new UserSettingsOperationModel();
    }
}
