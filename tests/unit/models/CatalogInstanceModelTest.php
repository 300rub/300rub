<?php

namespace testS\tests\unit\models;

use testS\models\CatalogInstanceModel;

/**
 * Tests for the model CatalogInstanceModel
 *
 * @package testS\tests\unit\models
 */
class CatalogInstanceModelTest extends AbstractModelTest
{

    /**
     * Gets model name
     *
     * @return CatalogInstanceModel
     */
    protected function getNewModel()
    {
        return new CatalogInstanceModel();
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
                    "seoModel"        => "",
                    "tabGroupModel"   => "",
                    "imageGroupModel" => "",
                    "catalogMenuId"   => "",
                    "fieldGroupModel" => "",
                    "price"           => "",
                    "oldPrice"        => "",
                    "date"            => "",
                ],
                [],
                null,
                null,
                self::EXCEPTION_MODEL
            ],
            "empty3" => [
                [
                    "tabGroupModel"   => [
                        "tabId" => 1,
                    ],
                    "catalogMenuId"   => 1,
                    "fieldGroupModel" => [
                        "fieldId" => 1,
                    ],
                ],
                [
                    "seoModel"        => [
                        "name" => ["required"],
                        "url"  => ["required", "url"]
                    ],
                    "imageGroupModel" => [
                        "name" => ["required"]
                    ]
                ],
            ],
            "empty4" => [
                [
                    "tabGroupModel"   => [
                        "tabId" => 1,
                    ],
                    "seoModel"        => [
                        "name" => "name",
                    ],
                    "catalogMenuId"   => 1,
                    "fieldGroupModel" => [
                        "fieldId" => 1,
                    ],
                    "imageGroupModel" => [
                        "imageId" => 1,
                        "name"    => "name"
                    ]
                ],
                [
                    "seoModel"        => [
                        "name"        => "name",
                        "url"         => "name",
                        "title"       => "",
                        "keywords"    => "",
                        "description" => "",
                    ],
                    "tabGroupModel"   => [
                        "tabId" => 1,
                    ],
                    "imageGroupModel" => [
                        "imageId" => 1,
                        "name"    => "name",
                        "sort"    => 0,
                    ],
                    "catalogMenuId"   => 1,
                    "fieldGroupModel" => [
                        "fieldId" => 1,
                    ],
                    "price"           => 0.0,
                    "oldPrice"        => 0.0,
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
                    "seoModel"        => [
                        "name"        => "name 1",
                        "url"         => "url-1",
                        "title"       => "title 1",
                        "keywords"    => "keywords 1",
                        "description" => "description 1",
                    ],
                    "tabGroupModel"   => [
                        "tabId" => 1,
                    ],
                    "imageGroupModel" => [
                        "imageId" => 1,
                        "name"    => "name",
                        "sort"    => 10,
                    ],
                    "catalogMenuId"   => 1,
                    "fieldGroupModel" => [
                        "fieldId" => 1,
                    ],
                    "price"           => 10.34,
                    "oldPrice"        => 20.54,
                ],
                [
                    "seoModel"        => [
                        "name"        => "name 1",
                        "url"         => "url-1",
                        "title"       => "title 1",
                        "keywords"    => "keywords 1",
                        "description" => "description 1",
                    ],
                    "tabGroupModel"   => [
                        "tabId" => 1,
                    ],
                    "imageGroupModel" => [
                        "imageId" => 1,
                        "name"    => "name",
                        "sort"    => 10,
                    ],
                    "catalogMenuId"   => 1,
                    "fieldGroupModel" => [
                        "fieldId" => 1,
                    ],
                    "price"           => 10.34,
                    "oldPrice"        => 20.54,
                ],
                [
                    "seoModel"        => [
                        "name"        => "name 2",
                        "url"         => "url-2",
                        "title"       => "title 2",
                        "keywords"    => "keywords 2",
                        "description" => "description 2",
                    ],
                    "tabGroupModel"   => [
                        "tabId" => 2,
                    ],
                    "imageGroupModel" => [
                        "imageId" => 2,
                        "name"    => "name 2",
                        "sort"    => 20,
                    ],
                    "catalogMenuId"   => 1,
                    "fieldGroupModel" => [
                        "fieldId" => 2,
                    ],
                    "price"           => 40.34,
                    "oldPrice"        => 50.54,
                ],
                [
                    "seoModel"        => [
                        "name"        => "name 2",
                        "url"         => "url-2",
                        "title"       => "title 2",
                        "keywords"    => "keywords 2",
                        "description" => "description 2",
                    ],
                    "tabGroupModel"   => [
                        "tabId" => 1,
                    ],
                    "imageGroupModel" => [
                        "imageId" => 1,
                        "name"    => "name 2",
                        "sort"    => 20,
                    ],
                    "catalogMenuId"   => 1,
                    "fieldGroupModel" => [
                        "fieldId" => 1,
                    ],
                    "price"           => 40.34,
                    "oldPrice"        => 50.54,
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
                    "seoModel"        => "incorrect",
                    "tabGroupModel"   => "incorrect",
                    "imageGroupModel" => "incorrect",
                    "catalogMenuId"   => "incorrect",
                    "fieldGroupModel" => "incorrect",
                    "price"           => "incorrect",
                    "oldPrice"        => "incorrect",
                    "date"            => "incorrect",
                ],
                [],
                null,
                null,
                self::EXCEPTION_MODEL
            ],
            "incorrect2" => [
                [
                    "seoModel"        => [
                        "name"        => "<br> name 1",
                    ],
                    "tabGroupModel"   => [
                        "tabId" => " 1 as",
                    ],
                    "imageGroupModel" => [
                        "imageId" => " 1 ",
                        "name"    => 123,
                        "sort"    => "aaaa",
                    ],
                    "catalogMenuId"   => "1 asd",
                    "fieldGroupModel" => [
                        "fieldId" => " 1 ",
                    ],
                    "price"           => "asd",
                    "oldPrice"        => " 20.54 asd",
                ],
                [
                    "seoModel"        => [
                        "name"        => "name 1",
                        "url"         => "name-1",
                        "title"       => "",
                        "keywords"    => "",
                        "description" => "",
                    ],
                    "tabGroupModel"   => [
                        "tabId" => 1,
                    ],
                    "imageGroupModel" => [
                        "imageId" => 1,
                        "name"    => "123",
                        "sort"    => 0,
                    ],
                    "catalogMenuId"   => 1,
                    "fieldGroupModel" => [
                        "fieldId" => 1,
                    ],
                    "price"           => 0.0,
                    "oldPrice"        => 20.54,
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
                "seoModel"        => [
                    "name"        => "name 1",
                    "url"         => "url-1",
                    "title"       => "title 1",
                    "keywords"    => "keywords 1",
                    "description" => "description 1",
                ],
                "tabGroupModel"   => [
                    "tabId" => 1,
                ],
                "imageGroupModel" => [
                    "imageId" => 1,
                    "name"    => "name",
                    "sort"    => 10,
                ],
                "catalogMenuId"   => 1,
                "fieldGroupModel" => [
                    "fieldId" => 1,
                ],
                "price"           => 10.34,
                "oldPrice"        => 20.54,
            ],
            [],
            self::EXCEPTION_MODEL
        );
    }
}