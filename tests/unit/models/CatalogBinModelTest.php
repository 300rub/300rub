<?php

namespace testS\tests\unit\models;

use testS\models\CatalogBinModel;

/**
 * Tests for the model CatalogBinModel
 *
 * @package testS\tests\unit\models
 */
class CatalogBinModelTest extends AbstractModelTest
{

    /**
     * Gets model name
     *
     * @return CatalogBinModel
     */
    protected function getNewModel()
    {
        return new CatalogBinModel();
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
                [
                    "count" => ["minValue"]
                ]
            ],
            "empty2" => [
                [
                    "catalogId"         => "",
                    "catalogInstanceId" => "",
                    "count"             => "",
                    "status"            => "",
                ],
                [
                    "count" => ["minValue"]
                ]
            ],
            "empty3" => [
                [
                    "count" => 1
                ],
                [],
                null,
                null,
                self::EXCEPTION_MODEL
            ],
            "empty4" => [
                [
                    "catalogId"         => 1,
                    "catalogInstanceId" => 1,
                    "count"             => 1,
                ],
                [
                    "catalogId"         => 1,
                    "catalogInstanceId" => 1,
                    "count"             => 1,
                    "status"            => 0,
                ]
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
                    "catalogId"         => 1,
                    "catalogInstanceId" => 1,
                    "count"             => 1,
                    "status"            => 0,
                ],
                [
                    "catalogId"         => 1,
                    "catalogInstanceId" => 1,
                    "count"             => 1,
                    "status"            => 0,
                ],
                [
                    "count"             => 20,
                    "status"            => 1,
                ],
                [
                    "catalogId"         => 1,
                    "catalogInstanceId" => 1,
                    "count"             => 20,
                    "status"            => 1,
                ],
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
                    "catalogId"         => "incorrect1",
                    "catalogInstanceId" => "incorrect1",
                    "count"             => "incorrect1",
                    "status"            => "incorrect1",
                ],
                [
                    "count" => ["minValue"]
                ]
            ],
            "incorrect2" => [
                [
                    "catalogId"         => " 1 a ",
                    "catalogInstanceId" => " 1 a ",
                    "count"             => " 21 a",
                    "status"            => " 1 a",
                ],
                [
                    "catalogId"         => 1,
                    "catalogInstanceId" => 1,
                    "count"             => 21,
                    "status"            => 1,
                ],
                [
                    "catalogId"         => 3,
                    "catalogInstanceId" => 3,
                    "count"             => true,
                    "status"            => 999,
                ],
                [
                    "catalogId"         => 1,
                    "catalogInstanceId" => 1,
                    "count"             => 1,
                    "status"            => 0,
                ],
            ],
            "incorrect3" => [
                [
                    "catalogId"         => 1,
                    "catalogInstanceId" => 1,
                    "count"             => -1,
                    "status"            => 1,
                ],
                [
                    "count" => ["minValue"]
                ]
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
                "catalogId"         => 1,
                "catalogInstanceId" => 1,
                "count"             => 1,
                "status"            => 0,
            ],
            [
                "count" => ["minValue"]
            ]
        );
    }
}