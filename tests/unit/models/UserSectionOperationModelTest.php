<?php

namespace testS\tests\unit\models;

use testS\components\Operation;
use testS\models\UserSectionOperationModel;

/**
 * Tests for the model UserSectionOperationModel
 *
 * @package testS\tests\unit\models
 */
class UserSectionOperationModelTest extends AbstractModelTest
{

    /**
     * Gets model name
     *
     * @return UserSectionOperationModel
     */
    protected function getNewModel()
    {
        return new UserSectionOperationModel();
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
                    "userSectionsId" => "",
                    "operation"      => "",
                ],
                [],
                null,
                null,
                self::EXCEPTION_CONTENT
            ],
            "empty3" => [
                [
                    "userSectionsId" => null,
                    "operation"      => null,
                ],
                [],
                null,
                null,
                self::EXCEPTION_CONTENT
            ],
            "empty4" => [
                [
                    "userSectionsId" => 1,
                ],
                [],
                null,
                null,
                self::EXCEPTION_CONTENT
            ],
            "empty5" => [
                [
                    "operation" => Operation::SECTION_ADD
                ],
                [],
                null,
                null,
                self::EXCEPTION_MODEL
            ],
            "empty6" => [
                [
                    "userSectionsId" => 0,
                    "operation"      => Operation::SECTION_ADD,
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
                    "userSectionsId" => 1,
                    "operation"      => Operation::SECTION_ADD,
                ],
                [
                    "userSectionsId" => 1,
                    "operation"      => Operation::SECTION_ADD,
                ],
            ],
            "correct2" => [
                [
                    "userSectionsId" => 2,
                    "operation"      => Operation::SECTION_UPDATE,
                ],
                [
                    "userSectionsId" => 2,
                    "operation"      => Operation::SECTION_UPDATE,
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
                    "userSectionsId" => "  1  ",
                    "operation"      => Operation::SECTION_ADD,
                ],
                [
                    "userSectionsId" => 1,
                    "operation"      => Operation::SECTION_ADD,
                ],
                [
                    "userSectionsId" => 2,
                    "operation"      => Operation::SECTION_UPDATE,
                ],
                [
                    "userSectionsId" => 1,
                    "operation"      => Operation::SECTION_ADD,
                ],
            ],
            "incorrect2" => [
                [
                    "userSectionsId" => 1,
                    "operation"      => "incorrect",
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
                "userSectionsId" => 1,
                "operation"      => Operation::SECTION_ADD,
            ],
            [],
            self::EXCEPTION_MODEL
        );
    }
}