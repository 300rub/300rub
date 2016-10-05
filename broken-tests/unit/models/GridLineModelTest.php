<?php

namespace tests\unit\models;

use testS\models\GridLineModel;

/**
 * Tests for model GridModel
 *
 * @package tests\unit\models
 */
class GridLineModelTest extends AbstractModelTest
{

    /**
     * Model object
     *
     * @return GridLineModel
     */
    protected function getModel()
    {
        return new GridLineModel;
    }

    /**
     * Data provider for CRUD test
     *
     * @return array
     */
    public function dataProviderForCRUD()
    {
        return [
            // Insert: empty fields
            [
                [],
                []
            ],
            // Insert: empty values
            [
                [
                    "t.sectionId"        => "",
                    "t.sort"              => "",
                    "t.outsideDesignId" => "",
                    "t.insideDesignId"  => "",
                ],
                []
            ],
            // Insert: correct values. Update: correct values.
            [
                [
                    "t.sectionId"        => 1,
                    "t.sort"              => 0,
                    "t.outsideDesignId" => "",
                    "t.insideDesignId"  => "",
                ],
                [],
                [
                    "t.sectionId" => 1,
                    "t.sort"       => 0,
                ],
                [
                    "t.sort" => 2,
                ],
                [],
                [
                    "t.sectionId" => 1,
                    "t.sort"       => 2,
                ]
            ],
            // Insert: incorrect values. Update: incorrect correct values.
            [
                [
                    "t.sectionId"        => 1,
                    "t.sort"              => "incorrect value",
                    "t.outsideDesignId" => "incorrect value",
                    "t.insideDesignId"  => "incorrect value",
                ],
                [],
                [
                    "t.sectionId" => 1,
                    "t.sort"       => 0,
                ],
                [
                    "t.sort" => "incorrect value",
                ],
                [],
                [
                    "t.sectionId" => 1,
                    "t.sort"       => 0,
                ]
            ],
        ];
    }
}