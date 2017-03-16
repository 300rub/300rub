<?php

namespace testS\tests\unit\models;

use testS\components\Operation;
use testS\models\BlockModel;
use testS\models\UserBlockGroupOperationModel;

/**
 * Tests for the model UserBlockGroupOperationModel
 *
 * @package testS\tests\unit\models
 */
class UserBlockGroupOperationModelTest extends AbstractModelTest
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
                    "blockType" => "",
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
                    "blockType" => null,
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
                    "operation" => Operation::TEXT_ADD,
                ],
                [],
                null,
                null,
                self::EXCEPTION_CONTENT
            ],
            "empty6" => [
                [
                    "userId"    => 0,
                    "operation" => Operation::TEXT_ADD,
                ],
                [],
                null,
                null,
                self::EXCEPTION_CONTENT
            ],
            "empty7" => [
                [
                    "userId"    => 1,
                    "blockType" => BlockModel::TYPE_TEXT,
                ],
                [],
                null,
                null,
                self::EXCEPTION_MODEL
            ],
            "empty8" => [
                [
                    "userId"    => 1,
                    "operation" => Operation::TEXT_ADD,
                ],
                [],
                null,
                null,
                self::EXCEPTION_CONTENT
            ],
            "empty9" => [
                [
                    "blockType" => BlockModel::TYPE_TEXT,
                    "operation" => Operation::TEXT_ADD,
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
                    "blockType" => BlockModel::TYPE_TEXT,
                    "operation" => Operation::TEXT_ADD,
                ],
                [
                    "userId"    => 1,
                    "blockType" => BlockModel::TYPE_TEXT,
                    "operation" => Operation::TEXT_ADD,
                ],
            ],
            "correct2" => [
                [
                    "userId"    => 2,
                    "blockType" => BlockModel::TYPE_TEXT,
                    "operation" => Operation::TEXT_UPDATE_SETTINGS,
                ],
                [
                    "userId"    => 2,
                    "blockType" => BlockModel::TYPE_TEXT,
                    "operation" => Operation::TEXT_UPDATE_SETTINGS,
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
                    "blockType" => BlockModel::TYPE_TEXT,
                    "operation" => Operation::TEXT_ADD,
                ],
                [
                    "userId"    => 1,
                    "blockType" => BlockModel::TYPE_TEXT,
                    "operation" => Operation::TEXT_ADD,
                ],
                [
                    "userId"    => 2,
                    "blockType" => BlockModel::TYPE_IMAGE,
                    "operation" => Operation::TEXT_UPDATE_SETTINGS,
                ],
                [
                    "userId"    => 1,
                    "blockType" => BlockModel::TYPE_TEXT,
                    "operation" => Operation::TEXT_ADD,
                ],
            ],
            "incorrect2" => [
                [
                    "userId"    => 1,
                    "blockType" => BlockModel::TYPE_IMAGE,
                    "operation" => Operation::TEXT_ADD,
                ],
                [],
                null,
                null,
                self::EXCEPTION_MODEL
            ],
            "incorrect3" => [
                [
                    "userId"    => 1,
                    "blockType" => BlockModel::TYPE_TEXT,
                    "operation" => "incorrect",
                ],
                [],
                null,
                null,
                self::EXCEPTION_MODEL
            ],
            "incorrect4" => [
                [
                    "userId"    => 1,
                    "blockType" => "incorrect",
                    "operation" => Operation::TEXT_ADD,
                ],
                [],
                null,
                null,
                self::EXCEPTION_CONTENT
            ],
        ];
    }

    /**
     * Data provider for CRUD. Duplicate
     *
     * @return array
     */
    public function testDuplicate()
    {
        $this->duplicate(
            [
                "userId"    => 1,
                "blockType" => BlockModel::TYPE_TEXT,
                "operation" => Operation::TEXT_ADD,
            ],
            [],
            self::EXCEPTION_MODEL
        );
    }
}