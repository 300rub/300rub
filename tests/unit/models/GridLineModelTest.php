<?php

namespace tests\unit\models;

use models\GridLineModel;

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
                    "t.section_id"        => "",
                    "t.sort"              => "",
                    "t.outside_design_id" => "",
                    "t.inside_design_id"  => "",
                ],
                []
            ],
            // Insert: correct values. Update: correct values.
            [
                [
                    "t.section_id"        => 1,
                    "t.sort"              => 0,
                    "t.outside_design_id" => "",
                    "t.inside_design_id"  => "",
                ],
                [],
                [
                    "t.section_id" => 1,
                    "t.sort"       => 0,
                ],
                [
                    "t.sort" => 2,
                ],
                [],
                [
                    "t.section_id" => 1,
                    "t.sort"       => 2,
                ]
            ],
            // Insert: incorrect values. Update: incorrect correct values.
            [
                [
                    "t.section_id"        => 1,
                    "t.sort"              => "incorrect value",
                    "t.outside_design_id" => "incorrect value",
                    "t.inside_design_id"  => "incorrect value",
                ],
                [],
                [
                    "t.section_id" => 1,
                    "t.sort"       => 0,
                ],
                [
                    "t.sort" => "incorrect value",
                ],
                [],
                [
                    "t.section_id" => 1,
                    "t.sort"       => 0,
                ]
            ],
        ];
    }
}