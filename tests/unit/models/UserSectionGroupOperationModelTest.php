<?php

namespace testS\tests\unit\models;

use testS\components\Operation;
use testS\models\UserSectionGroupOperationModel;

/**
 * Tests for the model UserSectionGroupOperationModel
 *
 * @package testS\tests\unit\models
 */
class UserSectionGroupOperationModelTest extends AbstractModelTest
{

    /**
     * Gets model name
     *
     * @return UserSectionGroupOperationModel
     */
    protected function getNewModel()
    {
        return new UserSectionGroupOperationModel();
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
                    "operation" => Operation::SECTION_ADD,
                ],
                [],
                null,
                null,
                self::EXCEPTION_MODEL
            ],
            "empty6" => [
                [
                    "userId"    => 0,
                    "operation" => Operation::SECTION_ADD,
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
                    "operation" => Operation::SECTION_ADD,
                ],
                [
                    "userId"    => 1,
                    "operation" => Operation::SECTION_ADD,
                ],
            ],
            "correct2" => [
                [
                    "userId"    => 2,
                    "operation" => Operation::SECTION_UPDATE,
                ],
                [
                    "userId"    => 2,
                    "operation" => Operation::SECTION_UPDATE,
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
                    "operation" => Operation::SECTION_ADD,
                ],
                [
                    "userId"    => 1,
                    "operation" => Operation::SECTION_ADD,
                ],
                [
                    "userId"    => 2,
                    "operation" => Operation::SECTION_UPDATE,
                ],
                [
                    "userId"    => 1,
                    "operation" => Operation::SECTION_ADD,
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
                "operation" => Operation::SECTION_ADD,
            ],
            [],
            self::EXCEPTION_MODEL
        );
    }
}