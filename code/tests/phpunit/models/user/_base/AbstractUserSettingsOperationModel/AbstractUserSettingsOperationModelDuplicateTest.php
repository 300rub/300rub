<?php

// @codingStandardsIgnoreLine
namespace ss\tests\phpunit\models\user\_base\AbstractUserSettingsOperationModel;

use ss\application\components\user\Operation;
use ss\models\user\UserSettingsOperationModel;
use ss\tests\phpunit\models\_abstract\_base\AbstractDuplicateModelTest;

/**
 * Tests for the model UserSettingsOperationModel
 */
// @codingStandardsIgnoreLine
class AbstractUserSettingsOperationModelDuplicateTest extends AbstractDuplicateModelTest
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

    /**
     * Data provider for CRUD. Duplicate
     *
     * @return void
     */
    public function testDuplicate()
    {
        $this->duplicate(
            [
                'userId'    => 1,
                'operation' => Operation::SETTINGS_USER_UPDATE,
            ],
            [],
            self::EXCEPTION_MODEL
        );
    }
}
