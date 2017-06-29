<?php

namespace testS\tests\unit\models;

use testS\models\CatalogInstanceLinkModel;

/**
 * Tests for the model CatalogInstanceLinkModel
 *
 * @package testS\tests\unit\models
 */
class CatalogInstanceLinkModelTest extends AbstractModelTest
{

    /**
     * Gets model name
     *
     * @return CatalogInstanceLinkModel
     */
    protected function getNewModel()
    {
        return new CatalogInstanceLinkModel();
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
                    "catalogInstanceId"     => "",
                    "linkCatalogInstanceId" => "",
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
                    "catalogInstanceId"     => 1,
                    "linkCatalogInstanceId" => 2,
                ],
                [
                    "catalogInstanceId"     => 1,
                    "linkCatalogInstanceId" => 2,
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
                    "catalogInstanceId"     => "incorrect",
                    "linkCatalogInstanceId" => "incorrect",
                ],
                [],
                null,
                null,
                self::EXCEPTION_MODEL
            ],
            "incorrect2" => [
                [
                    "catalogInstanceId"     => 999,
                    "linkCatalogInstanceId" => 997,
                ],
                [],
                null,
                null,
                self::EXCEPTION_MODEL
            ],
            "incorrect3" => [
                [
                    "catalogInstanceId"     => " 1a ",
                    "linkCatalogInstanceId" => " 2a ",
                ],
                [
                    "catalogInstanceId"     => 1,
                    "linkCatalogInstanceId" => 2,
                ],
            ],
            "incorrect4" => [
                [
                    "catalogInstanceId"     => 1,
                    "linkCatalogInstanceId" => 2,
                ],
                [
                    "catalogInstanceId"     => 1,
                    "linkCatalogInstanceId" => 2,
                ],
                [
                    "catalogInstanceId"     => 2,
                    "linkCatalogInstanceId" => 1,
                ],
                [
                    "catalogInstanceId"     => 1,
                    "linkCatalogInstanceId" => 2,
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
                "catalogInstanceId"     => 1,
                "linkCatalogInstanceId" => 2,
            ],
            [],
            self::EXCEPTION_MODEL
        );
    }
}