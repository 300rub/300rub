<?php

namespace testS\tests\unit\models;

use testS\models\FieldListValueModel;

/**
 * Tests for the model FieldListValueModel
 *
 * @package testS\tests\unit\models
 */
class FieldListValueModelTest extends AbstractModelTest
{

    /**
     * Gets model name
     *
     * @return FieldListValueModel
     */
    protected function getNewModel()
    {
        return new FieldListValueModel();
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
                    "value" => ["required"]
                ],
            ],
            "empty2" => [
                [
                    "fieldTemplateId" => "",
                    "value"           => "",
                    "sort"            => "",
                    "isChecked"       => "",
                ],
                [
                    "value" => ["required"]
                ],
            ],
            "empty3" => [
                [
                    "fieldTemplateId" => 1,
                    "value"           => "",
                    "sort"            => "",
                    "isChecked"       => "",
                ],
                [
                    "value" => ["required"]
                ],
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
                    "fieldTemplateId" => 1,
                    "value"           => "Value 1",
                    "sort"            => 10,
                    "isChecked"       => true,
                ],
                [
                    "fieldTemplateId" => 1,
                    "value"           => "Value 1",
                    "sort"            => 10,
                    "isChecked"       => true,
                ],
                [
                    "fieldTemplateId" => 2,
                    "value"           => "Value 2",
                    "sort"            => 20,
                    "isChecked"       => false,
                ],
                [
                    "fieldTemplateId" => 2,
                    "value"           => "Value 2",
                    "sort"            => 20,
                    "isChecked"       => false,
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
                    "fieldTemplateId" => "incorrect",
                    "value"           => 123,
                    "sort"            => "incorrect",
                    "isChecked"       => "incorrect",
                ],
                [],
                [],
                [],
                self::EXCEPTION_MODEL
            ],
            "incorrect2" => [
                [
                    "fieldTemplateId" => " 1 ",
                    "value"           => 123,
                    "sort"            => "bla",
                    "isChecked"       => "bla",
                ],
                [
                    "fieldTemplateId" => 1,
                    "value"           => "123",
                    "sort"            => 0,
                    "isChecked"       => false,
                ],
                [
                    "fieldTemplateId" => " 2asd ",
                    "value"           => 3231,
                    "sort"            => " 10 7",
                    "isChecked"       => "55",
                ],
                [
                    "fieldTemplateId" => 2,
                    "value"           => "3231",
                    "sort"            => 10,
                    "isChecked"       => false,
                ],
            ],
            "incorrect3" => [
                [
                    "fieldTemplateId" => 1,
                    "value"           => $this->generateStringWithLength(256),
                ],
                [
                    "value" => ["maxLength"]
                ]
            ],
            "incorrect4" => [
                [
                    "fieldTemplateId" => 1,
                    "value"           => "<b> 123 </b> </"
                ],
                [
                    "fieldTemplateId" => 1,
                    "value"           => "123",
                    "sort"            => 0,
                    "isChecked"       => false,
                ]
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
                "fieldTemplateId" => 1,
                "value"           => "Value 1",
                "sort"            => 10,
                "isChecked"       => true,
            ],
            [
                "fieldTemplateId" => 1,
                "value"           => "Value 1",
                "sort"            => 10,
                "isChecked"       => true,
            ]
        );
    }
}