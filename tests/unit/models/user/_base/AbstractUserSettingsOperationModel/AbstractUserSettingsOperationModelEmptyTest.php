<?php

// @codingStandardsIgnoreLine
namespace testS\tests\unit\models\user\_base\AbstractUserSettingsOperationModel;

use testS\application\components\Operation;
use testS\models\user\UserSettingsOperationModel;
use testS\tests\unit\models\_abstract\_base\AbstractEmptyModelTest;

/**
 * Tests for the model UserSettingsOperationModel
 */
// @codingStandardsIgnoreLine
class AbstractUserSettingsOperationModelEmptyTest extends AbstractEmptyModelTest
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
     * Data provider for CRUD. Empty values
     *
     * @return array
     */
    protected function getDataProviderEmpty()
    {
        return [
            'empty1' => [
                [],
                [],
                null,
                null,
                self::EXCEPTION_CONTENT
            ],
            'empty2' => [
                [
                    'userId'    => '',
                    'operation' => '',
                ],
                [],
                null,
                null,
                self::EXCEPTION_CONTENT
            ],
            'empty3' => [
                [
                    'userId'    => null,
                    'operation' => null,
                ],
                [],
                null,
                null,
                self::EXCEPTION_CONTENT
            ],
            'empty4' => [
                [
                    'userId' => 1,
                ],
                [],
                null,
                null,
                self::EXCEPTION_CONTENT
            ],
            'empty5' => [
                [
                    'operation' => Operation::SETTINGS_ICON,
                ],
                [],
                null,
                null,
                self::EXCEPTION_MODEL
            ],
            'empty6' => [
                [
                    'userId'    => 0,
                    'operation' => Operation::SETTINGS_ICON,
                ],
                [],
                null,
                null,
                self::EXCEPTION_MODEL
            ],
        ];
    }
}
