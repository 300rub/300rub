<?php

namespace testS\tests\unit\models;

use testS\models\TabTemplateModel;

/**
 * Tests for the model TabTemplateModel
 *
 * @package testS\tests\unit\models
 */
class TabTemplateModelTest extends AbstractModelTest
{

    /**
     * Gets model name
     *
     * @return TabTemplateModel
     */
    protected function getNewModel()
    {
        return new TabTemplateModel();
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
                    "sort"  => "",
                    "label" => "",
                ],
                [],
                null,
                null,
                self::EXCEPTION_MODEL
            ],
            "empty3" => [
                [
                    "tabId" => null,
                    "sort"  => null,
                    "label" => null,
                ],
                [],
                null,
                null,
                self::EXCEPTION_MODEL
            ],
            "empty4" => [
                [
                    "tabId" => 1,
                ],
                [
                    "tabId" => 1,
                    "sort"  => 0,
                    "label" => "",
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
                    "tabId" => 1,
                    "sort"  => 10,
                    "label" => "Label",
                ],
                [
                    "tabId" => 1,
                    "sort"  => 10,
                    "label" => "Label",
                ],
                [
                    "tabId" => 1,
                    "sort"  => 20,
                    "label" => "New label",
                ],
                [
                    "tabId" => 1,
                    "sort"  => 20,
                    "label" => "New label",
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
                    "sort" => " 40 asda",
                    "label" => 123
                ],
                [
                    "tabId" => 1,
                    "sort"  => 40,
                    "label" => "123",
                ],
                [
                    "label" => $this->generateStringWithLength(256),
                ],
                [
                    "label" => ["maxLength"]
                ]
            ],
            "incorrect5" => [
                [
                    "tabId" => 1,
                    "label" => "<b> aaa </b>"
                ],
                [
                    "tabId" => 1,
                    "sort"  => 0,
                    "label" => "aaa",
                ],
                [
                    "label" => "<strong> bbb <"
                ],
                [
                    "tabId" => 1,
                    "sort"  => 0,
                    "label" => "bbb",
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
                "tabId" => 1,
                "sort"  => 10,
                "label" => "Label",
            ],
            [
                "tabId" => 1,
                "sort"  => 10,
                "label" => "Label",
            ]
        );
    }
}