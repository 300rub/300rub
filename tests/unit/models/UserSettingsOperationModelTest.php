<?php

namespace testS\tests\unit\models;

use testS\components\Operation;
use testS\models\UserSettingsOperationModel;

/**
 * Tests for the model UserSettingsOperationModel
 *
 * @package testS\tests\unit\models
 */
class UserSettingsOperationModelTest extends AbstractModelTest
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
    protected function getDataProviderCRUDEmpty()
    {
        return [
            "empty1" => [
                [],
                [],
                null,
                null,
                self::EXCEPTION_CONTENT
            ],
            "empty2" => [
                [
                    "userId"    => "",
                    "operation" => "",
                ],
                [],
                null,
                null,
                self::EXCEPTION_CONTENT
            ],
            "empty3" => [
                [
                    "userId"    => null,
                    "operation" => null,
                ],
                [],
                null,
                null,
                self::EXCEPTION_CONTENT
            ],
            "empty4" => [
                [
                    "userId" => 1,
                ],
                [],
                null,
                null,
                self::EXCEPTION_CONTENT
            ],
            "empty5" => [
                [
                    "operation" => Operation::SETTING_ICON,
                ],
                [],
                null,
                null,
                self::EXCEPTION_MODEL
            ],
            "empty6" => [
                [
                    "userId"    => 0,
                    "operation" => Operation::SETTING_ICON,
                ],
                [],
                null,
                null,
                self::EXCEPTION_MODEL
            ],
        ];
    }

    /**
     * Data provider for CRUD. Correct values
     *
     * @return array
     */
    protected function getDataProviderCRUDCorrect()
    {
        return [
            "correct1" => [
                [
                    "userId"    => 1,
                    "operation" => Operation::SETTING_USERS,
                ],
                [
                    "userId"    => 1,
                    "operation" => Operation::SETTING_USERS,
                ],
            ],
            "correct2" => [
                [
                    "userId"    => 2,
                    "operation" => Operation::SETTING_ICON,
                ],
                [
                    "userId"    => 2,
                    "operation" => Operation::SETTING_ICON,
                ],
            ],
        ];
    }

    /**
     * Data provider for CRUD. Incorrect values
     *
     * @return array
     */
    protected function getDataProviderCRUDIncorrect()
    {
        return [
            "incorrect1" => [
                [
                    "userId"    => "  1  ",
                    "operation" => Operation::SETTING_USERS,
                ],
                [
                    "userId"    => 1,
                    "operation" => Operation::SETTING_USERS,
                ],
                [
                    "userId"    => 2,
                    "operation" => Operation::SETTING_ICON,
                ],
                [
                    "userId"    => 1,
                    "operation" => Operation::SETTING_USERS,
                ],
            ],
            "incorrect2" => [
                [
                    "userId"    => 1,
                    "operation" => "incorrect",
                ],
                [],
                null,
                null,
                self::EXCEPTION_CONTENT
            ],
        ];
    }

    /**
     * Test Duplicate
     */
    public function testDuplicate()
    {
        $this->duplicate(
            [
                "userId"    => 1,
                "operation" => Operation::SETTING_USERS,
            ],
            [],
            self::EXCEPTION_MODEL
        );
    }
}