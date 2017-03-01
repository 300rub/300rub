<?php

namespace testS\tests\unit\models;

use testS\models\TextModel;

/**
 * Tests for the model TextModel
 *
 * @package testS\tests\unit\models
 */
class TextModelTest extends AbstractModelTest
{

    /**
     * Gets model name
     *
     * @return TextModel
     */
    protected function getNewModel()
    {
        return new TextModel();
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
                    "designTextModel"  => [
                        "size" => 0
                    ],
                    "designBlockModel" => [
                        "marginTop" => 0
                    ],
                    "type"             => 0,
                    "hasEditor"        => false
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
        return [];
    }

    /**
     * Data provider for CRUD. Incorrect values
     *
     * @return array
     */
    protected function getDataProviderCRUDIncorrect()
    {
        return [];
    }

    /**
     * Data provider for CRUD. Duplicate
     *
     * @return array
     */
    public function getDataProviderDuplicate()
    {
        $this->markTestSkipped();
        return [];
    }
}