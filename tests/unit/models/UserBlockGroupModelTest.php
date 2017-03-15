<?php

namespace testS\tests\unit\models;

use testS\models\BlockModel;
use testS\models\UserBlockGroupModel;

/**
 * Tests for the model UserBlockGroupModel
 *
 * @package testS\tests\unit\models
 */
class UserBlockGroupModelTest extends AbstractModelTest
{

    /**
     * Gets model name
     *
     * @return UserBlockGroupModel
     */
    protected function getNewModel()
    {
        return new UserBlockGroupModel();
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
                    "blockType" => BlockModel::TYPE_TEXT,
                ],
                [],
                null,
                null,
                self::EXCEPTION_MODEL
            ],
            "empty6" => [
                [
                    "userId"    => 0,
                    "blockType" => BlockModel::TYPE_TEXT,
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
                ],
                [
                    "userId"    => 1,
                    "blockType" => BlockModel::TYPE_TEXT,
                ],
            ],
            "correct2" => [
                [
                    "userId"    => 2,
                    "blockType" => BlockModel::TYPE_IMAGE,
                ],
                [
                    "userId"    => 2,
                    "blockType" => BlockModel::TYPE_IMAGE,
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
                ],
                [
                    "userId"    => 1,
                    "blockType" => BlockModel::TYPE_TEXT,
                ],
                [
                    "userId"    => 2,
                    "blockType" => BlockModel::TYPE_IMAGE,
                ],
                [
                    "userId"    => 1,
                    "blockType" => BlockModel::TYPE_TEXT,
                ],
            ],
            "incorrect2" => [
                [
                    "userId"    => 1,
                    "blockType" => 999,
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
            ],
            [],
            self::EXCEPTION_MODEL
        );
    }
}