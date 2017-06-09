<?php

namespace testS\tests\unit\models;

use testS\models\TabModel;

/**
 * Tests for the model TabModel
 *
 * @package testS\tests\unit\models
 */
class TabModelTest extends AbstractModelTest
{

    /**
     * Gets model name
     *
     * @return TabModel
     */
    protected function getNewModel()
    {
        return new TabModel();
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
                    "designTabsModel" => [
                        "containerDesignBlockModel" => [
                            "marginTop" => 0
                        ],
                        "tabDesignBlockModel"     => [
                            "marginTop" => 0
                        ],
                        "tabDesignTextModel"      => [
                            "size" => 0
                        ],
                        "contentDesignBlockModel"     => [
                            "marginTop" => 0
                        ],
                    ],
                    "textModel"       => [
                        "designTextModel"  => [
                            "size" => 0
                        ],
                        "designBlockModel" => [
                            "marginTop" => 0
                        ],
                        "type"          => 0,
                        "hasEditor"     => false,
                    ],
                    "isShowEmpty"     => false,
                    "isLazyLoad"      => false,
                ]
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
    public function testDuplicate()
    {
        $this->markTestSkipped();
        return [];
    }
}