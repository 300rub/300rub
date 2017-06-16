<?php

namespace testS\tests\unit\models;

use testS\models\GridModel;

/**
 * Tests for the model GridModel
 *
 * @package testS\tests\unit\models
 */
class GridModelTest extends AbstractModelTest
{

    /**
     * Gets model name
     *
     * @return GridModel
     */
    protected function getNewModel()
    {
        return new GridModel();
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
                [],
                [],
                self::EXCEPTION_MODEL
            ],
            "empty2" => [
                [
                    "blockId"    => "",
                    "gridLineId" => "",
                    "x"          => "",
                    "y"          => "",
                    "width"      => "",
                ],
                [],
                [],
                [],
                self::EXCEPTION_MODEL
            ],
            "empty3" => [
                [
                    "blockId"    => 1,
                    "gridLineId" => "",
                    "x"          => "",
                    "y"          => "",
                    "width"      => "",
                ],
                [],
                [],
                [],
                self::EXCEPTION_MODEL
            ],
            "empty4" => [
                [
                    "blockId"    => "",
                    "gridLineId" => 1,
                    "x"          => "",
                    "y"          => "",
                    "width"      => "",
                ],
                [],
                [],
                [],
                self::EXCEPTION_MODEL
            ],
            "empty5" => [
                [
                    "blockId"    => 1,
                    "gridLineId" => 1,
                    "x"          => "",
                    "y"          => "",
                    "width"      => "",
                ],
                [
                    "blockId"    => 1,
                    "gridLineId" => 1,
                    "x"          => 0,
                    "y"          => 0,
                    "width"      => 3,
                ],
            ]
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
                    "blockId"    => 1,
                    "gridLineId" => 1,
                    "x"          => 4,
                    "y"          => 1,
                    "width"      => 6,
                ],
                [
                    "blockId"    => 1,
                    "gridLineId" => 1,
                    "x"          => 4,
                    "y"          => 1,
                    "width"      => 6,
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
                    "blockId"    => "incorrect",
                    "gridLineId" => "incorrect",
                    "x"          => "incorrect",
                    "y"          => "incorrect",
                    "width"      => "incorrect",
                ],
                [],
                [],
                [],
                self::EXCEPTION_MODEL
            ],
            "incorrect2" => [
                [
                    "blockId"    => " 1",
                    "gridLineId" => " 1",
                    "x"          => " 2",
                    "y"          => " 3",
                    "width"      => " 4",
                ],
                [
                    "blockId"    => 1,
                    "gridLineId" => 1,
                    "x"          => 2,
                    "y"          => 3,
                    "width"      => 4,
                ],
            ],
            "incorrect3" => [
                [
                    "blockId"    => 1,
                    "gridLineId" => 1,
                    "x"          => 13,
                    "y"          => -5,
                    "width"      => 19,
                ],
                [
                    "blockId"    => 1,
                    "gridLineId" => 1,
                    "x"          => 11,
                    "y"          => 0,
                    "width"      => 1,
                ],
            ],
            "incorrect4" => [
                [
                    "blockId"    => 1,
                    "gridLineId" => 1,
                    "x"          => -4,
                    "width"      => 0,
                ],
                [
                    "blockId"    => 1,
                    "gridLineId" => 1,
                    "x"          => 0,
                    "y"          => 0,
                    "width"      => 3,
                ],
            ],
            "incorrect5" => [
                [
                    "blockId"    => 1,
                    "gridLineId" => 1,
                    "x"          => 10,
                    "width"      => 0,
                ],
                [
                    "blockId"    => 1,
                    "gridLineId" => 1,
                    "x"          => 10,
                    "y"          => 0,
                    "width"      => 2,
                ],
            ]
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
                "blockId"    => 1,
                "gridLineId" => 1,
                "x"          => 4,
                "y"          => 1,
                "width"      => 6,
            ],
            [
                "blockId"    => 1,
                "gridLineId" => 1,
                "x"          => 4,
                "y"          => 1,
                "width"      => 6,
            ]
        );
    }
}