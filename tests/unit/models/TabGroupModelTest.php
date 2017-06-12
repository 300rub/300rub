<?php

namespace testS\tests\unit\models;

use testS\models\TabGroupModel;

/**
 * Tests for the model TabGroupModel
 *
 * @package testS\tests\unit\models
 */
class TabGroupModelTest extends AbstractModelTest
{

    /**
     * Gets model name
     *
     * @return TabGroupModel
     */
    protected function getNewModel()
    {
        return new TabGroupModel();
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
                self::EXCEPTION_MODEL
            ],
            "empty2" => [
                [
                    "tabId" => "",
                ],
                [],
                null,
                null,
                self::EXCEPTION_MODEL
            ],
            "empty3" => [
                [
                    "tabId" => null,
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
                    "tabId" => 1,
                ],
                [
                    "tabId" => 1,
                ]
            ]
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
                    "tabId" => "incorrect",
                ],
                [],
                null,
                null,
                self::EXCEPTION_MODEL
            ],
            "incorrect2" => [
                [
                    "tabId" => 999,
                ],
                [],
                null,
                null,
                self::EXCEPTION_MODEL
            ],
            "incorrect3" => [
                [
                    "tabId" => -1,
                ],
                [],
                null,
                null,
                self::EXCEPTION_MODEL
            ],
            "incorrect4" => [
                [
                    "tabId" => "  1 gf",
                ],
                [
                    "tabId" => 1,
                ],
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
                "tabId" => 1,
            ],
            [
                "tabId" => 1,
            ]
        );
    }
}