<?php

// @codingStandardsIgnoreLine
namespace ss\tests\phpunit\models\user\_base\AbstractUserSettingsOperationModel;

use ss\application\components\Operation;
use ss\models\user\UserSettingsOperationModel;
use ss\tests\phpunit\models\_abstract\_base\AbstractCorrectModelTest;

/**
 * Tests for the model UserSettingsOperationModel
 */
// @codingStandardsIgnoreLine
class AbstractUserSettingsOperationModelCorrectTest extends AbstractCorrectModelTest
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
     * Data provider for CRUD. Correct values
     *
     * @return array
     */
    protected function getDataProviderCorrect()
    {
        return [
            'correct1' => [
                [
                    'userId'    => 1,
                    'operation' => Operation::SETTINGS_USER_UPDATE,
                ],
                [
                    'userId'    => 1,
                    'operation' => Operation::SETTINGS_USER_UPDATE,
                ],
            ],
            'correct2' => [
                [
                    'userId'    => 2,
                    'operation' => Operation::SETTINGS_ICON,
                ],
                [
                    'userId'    => 2,
                    'operation' => Operation::SETTINGS_ICON,
                ],
            ],
        ];
    }
}
