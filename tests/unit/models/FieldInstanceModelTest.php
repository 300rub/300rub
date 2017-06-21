<?php

namespace testS\tests\unit\models;

use testS\models\FieldInstanceModel;

/**
 * Tests for the model FieldInstanceModel
 *
 * @package testS\tests\unit\models
 */
class FieldInstanceModelTest extends AbstractModelTest
{

    /**
     * Gets model name
     *
     * @return FieldInstanceModel
     */
    protected function getNewModel()
    {
        return new FieldInstanceModel();
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
                    "fieldGroupId"    => "",
                    "fieldTemplateId" => "",
                    "value"           => "",
                ],
                [],
                [],
                [],
                self::EXCEPTION_MODEL
            ],
            "empty3" => [
                [
                    "fieldGroupId"    => 1,
                    "fieldTemplateId" => "",
                    "value"           => "",
                ],
                [],
                [],
                [],
                self::EXCEPTION_MODEL
            ],
            "empty4" => [
                [
                    "fieldGroupId"    => "",
                    "fieldTemplateId" => 1,
                    "value"           => "",
                ],
                [],
                [],
                [],
                self::EXCEPTION_MODEL
            ],
            "empty5" => [
                [
                    "fieldGroupId"    => 1,
                    "fieldTemplateId" => 1,
                    "value"           => "",
                ],
                [
                    "fieldGroupId"    => 1,
                    "fieldTemplateId" => 1,
                    "value"           => "",
                ],
                [
                    "fieldGroupId"    => 1,
                    "fieldTemplateId" => 1,
                    "value"           => null,
                ],
                [
                    "fieldGroupId"    => 1,
                    "fieldTemplateId" => 1,
                    "value"           => "",
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
                    "fieldGroupId"    => 1,
                    "fieldTemplateId" => 1,
                    "value"           => "Value 1",
                ],
                [
                    "fieldGroupId"    => 1,
                    "fieldTemplateId" => 1,
                    "value"           => "Value 1",
                ],
                [
                    "fieldGroupId"    => 1,
                    "fieldTemplateId" => 2,
                    "value"           => "Value 2",
                ],
                [
                    "fieldGroupId"    => 1,
                    "fieldTemplateId" => 2,
                    "value"           => "Value 2",
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
                    "fieldGroupId"    => "incorrect",
                    "fieldTemplateId" => "incorrect",
                    "value"           => null,
                ],
                [],
                [],
                [],
                self::EXCEPTION_MODEL
            ],
            "incorrect2" => [
                [
                    "fieldGroupId"    => " 1",
                    "fieldTemplateId" => " 1",
                    "value"           => null,
                ],
                [
                    "fieldGroupId"    => 1,
                    "fieldTemplateId" => 1,
                    "value"           => "",
                ],
                [
                    "value"           => 123,
                ],
                [
                    "fieldGroupId"    => 1,
                    "fieldTemplateId" => 1,
                    "value"           => "123",
                ],
            ],
            "incorrect3" => [
                [
                    "fieldGroupId"    => " 1asd",
                    "fieldTemplateId" => " 1das",
                    "value"           => "<b>123<",
                ],
                [
                    "fieldGroupId"    => 1,
                    "fieldTemplateId" => 1,
                    "value"           => "123",
                ],
                [
                    "value"           => $this->generateStringWithLength(256),
                ],
                [
                    "value"    => ["maxLength"]
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
                "fieldGroupId"    => 1,
                "fieldTemplateId" => 1,
                "value"           => "Value 1",
            ],
            [
                "fieldGroupId"    => 1,
                "fieldTemplateId" => 1,
                "value"           => "Value 1",
            ]
        );
    }
}