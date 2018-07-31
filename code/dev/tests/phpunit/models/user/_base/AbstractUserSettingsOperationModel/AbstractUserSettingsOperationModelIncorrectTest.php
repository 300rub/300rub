<?php

// @codingStandardsIgnoreLine
namespace ss\tests\phpunit\models\user\_base\AbstractUserSettingsOperationModel;

use ss\application\components\Operation;
use ss\models\user\UserSettingsOperationModel;
use ss\tests\phpunit\models\_abstract\_base\AbstractIncorrectModelTest;

/**
 * Tests for the model UserSettingsOperationModel
 */
// @codingStandardsIgnoreLine
class AbstractUserSettingsOperationModelIncorrectTest extends AbstractIncorrectModelTest
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
     * Data provider for CRUD. Incorrect values
     *
     * @return array
     */
    protected function getDataProviderIncorrect()
    {
        return [
            'incorrect1' => [
                [
                    'userId'    => '  1  ',
                    'operation' => Operation::SETTINGS_USER_UPDATE,
                ],
                [
                    'userId'    => 1,
                    'operation' => Operation::SETTINGS_USER_UPDATE,
                ],
                [
                    'userId'    => 2,
                    'operation' => Operation::SETTINGS_ICON,
                ],
                [
                    'userId'    => 1,
                    'operation' => Operation::SETTINGS_USER_UPDATE,
                ],
            ],
            'incorrect2' => [
                [
                    'userId'    => 1,
                    'operation' => 'incorrect',
                ],
                [],
                null,
                null,
                self::EXCEPTION_CONTENT
            ],
        ];
    }
}
