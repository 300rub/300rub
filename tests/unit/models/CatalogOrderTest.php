<?php

namespace testS\tests\unit\models;

use testS\models\CatalogOrderModel;

/**
 * Tests for the model CatalogOrderModel
 *
 * @package testS\tests\unit\models
 */
class CatalogOrderModelTest extends AbstractModelTest
{

    /**
     * Gets model name
     *
     * @return CatalogOrderModel
     */
    protected function getNewModel()
    {
        return new CatalogOrderModel();
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
                    "email" => ["email"]
                ],
            ],
            "empty2" => [
                [
                    "catalogBinId" => "",
                    "formId"       => "",
                    "email"        => "",
                ],
                [
                    "email" => ["email"]
                ],
            ],
            "empty3" => [
                [
                    "email" => "email@email.com",
                ],
                [],
                null,
                null,
                self::EXCEPTION_MODEL
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
                    "catalogBinId" => 1,
                    "formId"       => 1,
                    "email"        => "email@email.com",
                ],
                [
                    "catalogBinId" => 1,
                    "formId"       => 1,
                    "email"        => "email@email.com",
                ],
                [
                    "email" => "email2@email.com",
                ],
                [
                    "catalogBinId" => 1,
                    "formId"       => 1,
                    "email"        => "email2@email.com",
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
                    "catalogBinId" => "incorrect",
                    "formId"       => "incorrect",
                    "email"        => "incorrect",
                ],
                [
                    "email" => ["email"]
                ],
            ],
            "incorrect2" => [
                [
                    "catalogBinId" => " 1 s",
                    "formId"       => " 1 s",
                    "email"        => "   email@email.com   ",
                ],
                [
                    "catalogBinId" => 1,
                    "formId"       => 1,
                    "email"        => "email@email.com",
                ],
                [
                    "catalogBinId" => 3,
                    "formId"       => 3,
                    "email"        => "email2@email.com",
                ],
                [
                    "catalogBinId" => 1,
                    "formId"       => 1,
                    "email"        => "email2@email.com",
                ],
            ],
            "incorrect3" => [
                [
                    "catalogBinId" => 999,
                    "formId"       => 999,
                    "email"        => "email2@email.com",
                ],
                [],
                null,
                null,
                self::EXCEPTION_MODEL
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
                "catalogBinId" => 1,
                "formId"       => 1,
                "email"        => "email@email.com",
            ],
            [
                "email" => ["email"]
            ]
        );
    }
}