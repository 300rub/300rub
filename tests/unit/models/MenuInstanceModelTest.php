<?php

namespace testS\tests\unit\models;

use testS\models\MenuInstanceModel;

/**
 * Tests for the model MenuInstanceModel
 *
 * @package testS\tests\unit\models
 */
class MenuInstanceModelTest extends AbstractModelTest
{

    /**
     * Gets model name
     *
     * @return MenuInstanceModel
     */
    protected function getNewModel()
    {
        return new MenuInstanceModel();
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
                    "menuId"    => "",
                    "parentId"  => "",
                    "sectionId" => "",
                    "icon"      => "",
                    "subName"   => "",
                    "sort"      => "",
                ],
                [],
                null,
                null,
                self::EXCEPTION_MODEL
            ],
            "empty3" => [
                [
                    "menuId"    => 1,
                    "sectionId" => 1,
                ],
                [
                    "menuId"    => 1,
                    "parentId"  => null,
                    "sectionId" => 1,
                    "icon"      => "",
                    "subName"   => "",
                    "sort"      => 0,
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
                    "menuId"    => 1,
                    "parentId"  => null,
                    "sectionId" => 1,
                    "icon"      => "fa-user",
                    "subName"   => "Name",
                    "sort"      => 10,
                ],
                [
                    "menuId"    => 1,
                    "parentId"  => null,
                    "sectionId" => 1,
                    "icon"      => "fa-user",
                    "subName"   => "Name",
                    "sort"      => 10,
                ],
                [
                    "menuId"    => 1,
                    "parentId"  => 1,
                    "sectionId" => 1,
                    "icon"      => "",
                    "subName"   => "",
                    "sort"      => 20,
                ],
                [
                    "menuId"    => 1,
                    "parentId"  => 1,
                    "sectionId" => 1,
                    "icon"      => "",
                    "subName"   => "",
                    "sort"      => 20,
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
                    "menuId"    => "incorrect",
                    "parentId"  => "incorrect",
                    "sectionId" => "incorrect",
                    "icon"      => "incorrect",
                    "subName"   => "incorrect",
                    "sort"      => "incorrect",
                ],
                [],
                null,
                null,
                self::EXCEPTION_MODEL
            ],
            "incorrect2" => [
                [
                    "menuId"    => " 1 asd",
                    "parentId"  => "incorrect",
                    "sectionId" => " 1 aaaa ",
                    "icon"      => "incorrect",
                    "subName"   => "incorrect",
                    "sort"      => "incorrect",
                ],
                [
                    "menuId"    => 1,
                    "parentId"  => null,
                    "sectionId" => 1,
                    "icon"      => "incorrect",
                    "subName"   => "incorrect",
                    "sort"      => 0,
                ],
                [
                    "menuId"   => 2,
                    "parentId" => "1 as",
                    "icon"     => "",
                    "subName"  => "",
                ],
                [
                    "menuId"    => 1,
                    "parentId"  => 1,
                    "sectionId" => 1,
                    "icon"      => "",
                    "subName"   => "",
                    "sort"      => 0,
                ],
            ],
            "incorrect3" => [
                [
                    "menuId"    => 1,
                    "sectionId" => 1,
                    "icon"      => "<b> icon </b>",
                ],
                [
                    "icon" => "icon",
                ],
                [
                    "icon" => $this->generateStringWithLength(51),
                ],
                [
                    "icon" => ["maxLength"],
                ],
            ],
            "incorrect4" => [
                [
                    "menuId"    => 1,
                    "sectionId" => 1,
                    "subName"   => "<b> name </b>",
                ],
                [
                    "subName" => "name",
                ],
                [
                    "subName" => $this->generateStringWithLength(256),
                ],
                [
                    "subName" => ["maxLength"],
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
                "menuId"    => 1,
                "parentId"  => null,
                "sectionId" => 1,
                "icon"      => "fa-user",
                "subName"   => "Name",
                "sort"      => 10,
            ],
            [],
            self::EXCEPTION_MODEL
        );
    }
}