<?php

namespace testS\tests\unit\models;

use testS\models\FieldTemplateModel;

/**
 * Tests for the model FieldTemplateModel
 *
 * @package testS\tests\unit\models
 */
class FieldTemplateModelTest extends AbstractModelTest
{

    /**
     * Gets model name
     *
     * @return FieldTemplateModel
     */
    protected function getNewModel()
    {
        return new FieldTemplateModel();
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
                [
                    "label" => "label",
                ],
                [],
                [],
                [],
                self::EXCEPTION_MODEL
            ],
            "empty2" => [
                [],
                [
                    "label" => ["required"]
                ],
            ],
            "empty3" => [
                [
                    "fieldId"            => 1,
                    "sort"               => "",
                    "label"              => "label",
                    "type"               => "",
                    "validationType"     => "",
                    "isHideForShortCard" => "",
                    "isShowEmpty"        => "",
                ],
                [
                    "fieldId"            => 1,
                    "sort"               => 0,
                    "label"              => "label",
                    "type"               => 0,
                    "validationType"     => 0,
                    "isHideForShortCard" => false,
                    "isShowEmpty"        => false,
                ],
                [
                    "fieldId"            => 1,
                    "sort"               => null,
                    "label"              => "label",
                    "type"               => null,
                    "validationType"     => null,
                    "isHideForShortCard" => null,
                    "isShowEmpty"        => null,
                ],
                [
                    "fieldId"            => 1,
                    "sort"               => 0,
                    "label"              => "label",
                    "type"               => 0,
                    "validationType"     => 0,
                    "isHideForShortCard" => false,
                    "isShowEmpty"        => false,
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
                    "fieldId"            => 1,
                    "sort"               => 10,
                    "label"              => "Label",
                    "type"               => 1,
                    "validationType"     => 1,
                    "isHideForShortCard" => true,
                    "isShowEmpty"        => true,
                ],
                [
                    "fieldId"            => 1,
                    "sort"               => 10,
                    "label"              => "Label",
                    "type"               => 1,
                    "validationType"     => 1,
                    "isHideForShortCard" => true,
                    "isShowEmpty"        => true,
                ],
                [
                    "fieldId"            => 1,
                    "sort"               => 20,
                    "label"              => "New Label",
                    "type"               => 0,
                    "validationType"     => 0,
                    "isHideForShortCard" => false,
                    "isShowEmpty"        => false,
                ],
                [
                    "fieldId"            => 1,
                    "sort"               => 20,
                    "label"              => "New Label",
                    "type"               => 0,
                    "validationType"     => 0,
                    "isHideForShortCard" => false,
                    "isShowEmpty"        => false,
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
                    "fieldId" => 9999,
                    "label"   => 111,
                ],
                [],
                [],
                [],
                self::EXCEPTION_MODEL
            ],
            "incorrect2" => [
                [
                    "fieldId"            => " 1 ",
                    "sort"               => " 10a ",
                    "label"              => 111,
                    "type"               => 999,
                    "validationType"     => 999,
                    "isHideForShortCard" => 999,
                    "isShowEmpty"        => 999,
                ],
                [
                    "fieldId"            => 1,
                    "sort"               => 10,
                    "label"              => "111",
                    "type"               => 0,
                    "validationType"     => 0,
                    "isHideForShortCard" => true,
                    "isShowEmpty"        => true,
                ],
                [
                    "fieldId"            => " 1",
                    "sort"               => "incorrect",
                    "label"              => "label",
                    "type"               => "incorrect",
                    "validationType"     => "incorrect",
                    "isHideForShortCard" => 0,
                    "isShowEmpty"        => 0,
                ],
                [
                    "fieldId"            => 1,
                    "sort"               => 0,
                    "label"              => "label",
                    "type"               => 0,
                    "validationType"     => 0,
                    "isHideForShortCard" => false,
                    "isShowEmpty"        => false,
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
                "fieldId"            => 1,
                "sort"               => 10,
                "label"              => "Label",
                "type"               => 1,
                "validationType"     => 1,
                "isHideForShortCard" => true,
                "isShowEmpty"        => true,
            ],
            [
                "fieldId"            => 1,
                "sort"               => 10,
                "label"              => "Label",
                "type"               => 1,
                "validationType"     => 1,
                "isHideForShortCard" => true,
                "isShowEmpty"        => true,
            ]
        );
    }
}