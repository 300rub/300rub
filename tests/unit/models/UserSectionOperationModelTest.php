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
                    "userId"    => "",
                    "sectionId" => "",
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
                    "sectionId" => null,
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
                    "operation" => Operation::SECTION_DUPLICATE
                ],
                [],
                null,
                null,
                self::EXCEPTION_MODEL
            ],
            "empty6" => [
                [
                    "userId"    => 0,
                    "operation" => Operation::SECTION_DUPLICATE,
                ],
                [],
                null,
                null,
                self::EXCEPTION_MODEL
            ],
            "empty7" => [
                [
                    "userId"    => 1,
                    "operation" => Operation::SECTION_DUPLICATE,
                ],
                [],
                null,
                null,
                self::EXCEPTION_MODEL
            ],
            "empty8" => [
                [
                    "userId"    => 1,
                    "sectionId" => 1,
                ],
                [],
                null,
                null,
                self::EXCEPTION_CONTENT
            ],
            "empty9" => [
                [
                    "sectionId" => 1,
                    "operation" => Operation::SECTION_DUPLICATE,
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
                    "sectionId" => 1,
                    "operation" => Operation::SECTION_DUPLICATE,
                ],
                [
                    "userId"    => 1,
                    "sectionId" => 1,
                    "operation" => Operation::SECTION_DUPLICATE,
                ],
            ],
            "correct2" => [
                [
                    "userId"    => 2,
                    "sectionId" => 1,
                    "operation" => Operation::SECTION_UPDATE,
                ],
                [
                    "userId"    => 2,
                    "sectionId" => 1,
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
                    "sectionId" => "  1  ",
                    "operation" => Operation::SECTION_UPDATE,
                ],
                [
                    "userId"    => 1,
                    "sectionId" => 1,
                    "operation" => Operation::SECTION_UPDATE,
                ],
                [
                    "userId"    => 2,
                    "sectionId" => 2,
                    "operation" => Operation::SECTION_DESIGN_UPDATE,
                ],
                [
                    "userId"    => 1,
                    "sectionId" => 1,
                    "operation" => Operation::SECTION_UPDATE,
                ],
            ],
            "incorrect2" => [
                [
                    "userId"    => 1,
                    "sectionId" => 1,
                    "operation" => "incorrect",
                ],
                [],
                null,
                null,
                self::EXCEPTION_CONTENT
            ],
            "incorrect3" => [
                [
                    "userId"    => 999,
                    "sectionId" => 1,
                    "operation" => Operation::SECTION_UPDATE,
                ],
                [],
                null,
                null,
                self::EXCEPTION_MODEL
            ],
            "incorrect4" => [
                [
                    "userId"    => 1,
                    "sectionId" => 999,
                    "operation" => Operation::SECTION_UPDATE,
                ],
                [],
                null,
                null,
                self::EXCEPTION_MODEL
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
                "sectionId" => 1,
                "operation" => Operation::SECTION_UPDATE,
            ],
            [],
            self::EXCEPTION_MODEL
        );
    }
}