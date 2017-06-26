<?php

namespace testS\tests\unit\models;

use testS\models\CatalogMenuModel;

/**
 * Tests for the model CatalogMenuModel
 *
 * @package testS\tests\unit\models
 */
class CatalogMenuModelTest extends AbstractModelTest
{

    /**
     * Gets model name
     *
     * @return CatalogMenuModel
     */
    protected function getNewModel()
    {
        return new CatalogMenuModel();
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
                    "parentId"  => "",
                    "seoModel"  => "",
                    "catalogId" => "",
                    "icon"      => "",
                    "subName"   => "",
                ],
                [],
                [],
                [],
                self::EXCEPTION_MODEL
            ],
            "empty3" => [
                [
                    "parentId"  => "",
                    "seoModel"  => "",
                    "catalogId" => 1,
                    "icon"      => "",
                    "subName"   => "",
                ],
                [
                    "seoModel" => [
                        "name" => ["required"],
                        "url"  => ["required", "url"],
                    ],
                ],
            ],
            "empty4" => [
                [
                    "parentId"  => "",
                    "seoModel"  => [
                        "name" => "New name"
                    ],
                    "catalogId" => 1,
                    "icon"      => "",
                    "subName"   => "",
                ],
                [
                    "parentId"  => null,
                    "seoModel"  => [
                        "name"        => "New name",
                        "url"         => "new-name",
                        "title"       => "",
                        "keywords"    => "",
                        "description" => "",
                    ],
                    "catalogId" => 1,
                    "icon"      => "",
                    "subName"   => "",
                ],
            ],
            "empty5" => [
                [
                    "parentId"  => null,
                    "seoModel"  => [
                        "name"        => "",
                        "url"         => "",
                        "title"       => "",
                        "keywords"    => "",
                        "description" => "",
                    ],
                    "catalogId" => 1,
                    "icon"      => "",
                    "subName"   => "",
                ],
                [
                    "seoModel" => [
                        "name" => ["required"],
                        "url"  => ["required", "url"],
                    ],
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
                    "parentId"  => null,
                    "seoModel"  => [
                        "name"        => "Name",
                        "url"         => "url",
                        "title"       => "title",
                        "keywords"    => "keywords",
                        "description" => "description",
                    ],
                    "catalogId" => 1,
                    "icon"      => "icon",
                    "subName"   => "subName",
                ],
                [
                    "parentId"  => null,
                    "seoModel"  => [
                        "name"        => "Name",
                        "url"         => "url",
                        "title"       => "title",
                        "keywords"    => "keywords",
                        "description" => "description",
                    ],
                    "catalogId" => 1,
                    "icon"      => "icon",
                    "subName"   => "subName",
                ],
                [
                    "parentId"  => 1,
                    "seoModel"  => [
                        "name"        => "Name 2",
                        "url"         => "url-2",
                        "title"       => "title 2",
                        "keywords"    => "keywords 2",
                        "description" => "description 2",
                    ],
                    "catalogId" => 1,
                    "icon"      => "icon-2",
                    "subName"   => "subName 2",
                ],
                [
                    "parentId"  => 1,
                    "seoModel"  => [
                        "name"        => "Name 2",
                        "url"         => "url-2",
                        "title"       => "title 2",
                        "keywords"    => "keywords 2",
                        "description" => "description 2",
                    ],
                    "catalogId" => 1,
                    "icon"      => "icon-2",
                    "subName"   => "subName 2",
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
                    "parentId"  => "incorrect",
                    "seoModel"  => "incorrect",
                    "catalogId" => "incorrect",
                    "icon"      => "incorrect",
                    "subName"   => "incorrect",
                ],
                [],
                [],
                [],
                self::EXCEPTION_MODEL
            ],
            "incorrect2" => [
                [
                    "parentId"  => "  1 ",
                    "seoModel"  => [
                        "name" => "  as asd <b> as </b> "
                    ],
                    "catalogId" => " 1 asd",
                    "icon"      => "<b> 123 </b>",
                    "subName"   => "<b> 123 </b>",
                ],
                [
                    "parentId"  => 1,
                    "seoModel"  => [
                        "name" => "as asd  as",
                        "url"  => "as-asd--as"
                    ],
                    "catalogId" => 1,
                    "icon"      => "123",
                    "subName"   => "123",
                ],
                [
                    "icon"    => $this->generateStringWithLength(51),
                    "subName" => $this->generateStringWithLength(256),
                ],
                [
                    "icon"    => ["maxLength"],
                    "subName" => ["maxLength"],
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
                "parentId"  => null,
                "seoModel"  => [
                    "name"        => "Name",
                    "url"         => "url",
                    "title"       => "title",
                    "keywords"    => "keywords",
                    "description" => "description",
                ],
                "catalogId" => 1,
                "icon"      => "icon",
                "subName"   => "subName",
            ],
            [
                "parentId"  => null,
                "seoModel"  => [
                    "name"        => "Name (Copy)",
                    "url"         => "url-copy",
                    "title"       => "",
                    "keywords"    => "",
                    "description" => "",
                ],
                "catalogId" => 1,
                "icon"      => "icon",
                "subName"   => "subName",
            ]
        );
    }
}