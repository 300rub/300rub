<?php

namespace testS\tests\unit\models;

use testS\models\RecordInstanceModel;

/**
 * Tests for the model RecordInstanceModel
 *
 * @package testS\tests\unit\models
 */
class RecordInstanceModelTest extends AbstractModelTest
{

    /**
     * Gets model name
     *
     * @return RecordInstanceModel
     */
    protected function getNewModel()
    {
        return new RecordInstanceModel();
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
                    "recordId"                     => "",
                    "seoModel"                     => "",
                    "textTextInstanceModel"        => "",
                    "descriptionTextInstanceModel" => "",
                    "imageGroupModel"              => "",
                    "coverImageInstanceModel"      => "",
                    "date"                         => "",
                    "sort"                         => "",
                ],
                [],
                null,
                null,
                self::EXCEPTION_MODEL
            ],
            "empty3" => [
                [
                    "recordId"                     => 1,
                    "seoModel"                     => "",
                    "textTextInstanceModel"        => "",
                    "descriptionTextInstanceModel" => "",
                    "imageGroupModel"              => "",
                    "coverImageInstanceModel"      => "",
                    "date"                         => "",
                    "sort"                         => "",
                ],
                [],
                null,
                null,
                self::EXCEPTION_MODEL
            ],
            "empty4" => [
                [
                    "recordId"                     => 1,
                    "seoModel"                     => "",
                    "textTextInstanceModel"        => [
                        "textId" => 1,
                    ],
                    "descriptionTextInstanceModel" => [
                        "textId" => 1,
                    ],
                    "imageGroupModel"              => [
                        "imageId" => 1,
                    ],
                    "coverImageInstanceModel"      => "",
                    "date"                         => "",
                    "sort"                         => "",
                ],
                [
                    "seoModel"                => [
                        "name" => ["required"],
                        "url"  => ["required", "url"]
                    ],
                    "imageGroupModel"         => [
                        "name" => ["required"]
                    ],
                    "coverImageInstanceModel" => [
                        "fileName" => ["required"]
                    ]
                ],
            ],
            "empty5" => [
                [
                    "recordId"                     => 1,
                    "seoModel"                     => [
                        "name" => "name",
                    ],
                    "textTextInstanceModel"        => [
                        "textId" => 1,
                    ],
                    "descriptionTextInstanceModel" => [
                        "textId" => 1,
                    ],
                    "imageGroupModel"              => [
                        "imageId" => 1,
                        "name"    => "Name"
                    ],
                    "coverImageInstanceModel"      => [
                        "imageAlbumId" => 1,
                        "fileName"     => "name"
                    ],
                ],
                [
                    "recordId"                     => 1,
                    "seoModel"                     => [
                        "name"        => "name",
                        "url"         => "name",
                        "title"       => "",
                        "keywords"    => "",
                        "description" => "",
                    ],
                    "textTextInstanceModel"        => [
                        "textId" => 1,
                        "text"   => ""
                    ],
                    "descriptionTextInstanceModel" => [
                        "textId" => 1,
                        "text"   => ""
                    ],
                    "imageGroupModel"              => [
                        "imageId" => 1,
                        "name"    => "Name",
                        "sort"    => 0,
                    ],
                    "coverImageInstanceModel"      => [
                        "imageAlbumId" => 1,
                        "fileName"     => "name",
                        "isCover"      => false,
                        "sort"         => 0,
                        "alt"          => "",
                        "width"        => 0,
                        "height"       => 0,
                        "x1"           => 0,
                        "y1"           => 0,
                        "x2"           => 0,
                        "y2"           => 0,
                        "thumbX1"      => 0,
                        "thumbY1"      => 0,
                        "thumbX2"      => 0,
                        "thumbY2"      => 0,
                    ],
                    "sort"                         => 0,
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
                    "recordId"                     => 1,
                    "seoModel"                     => [
                        "name"        => "name 1",
                        "url"         => "url-1",
                        "title"       => "title 1",
                        "keywords"    => "keywords 1",
                        "description" => "description 1",
                    ],
                    "textTextInstanceModel"        => [
                        "textId" => 1,
                        "text"   => ""
                    ],
                    "descriptionTextInstanceModel" => [
                        "textId" => 1,
                        "text"   => ""
                    ],
                    "imageGroupModel"              => [
                        "imageId" => 1,
                        "name"    => "record",
                        "sort"    => 0,
                    ],
                    "coverImageInstanceModel"      => [
                        "imageAlbumId" => 1,
                        "fileName"     => "record",
                        "isCover"      => false,
                        "sort"         => 0,
                        "alt"          => "",
                        "width"        => 0,
                        "height"       => 0,
                        "x1"           => 0,
                        "y1"           => 0,
                        "x2"           => 0,
                        "y2"           => 0,
                        "thumbX1"      => 0,
                        "thumbY1"      => 0,
                        "thumbX2"      => 0,
                        "thumbY2"      => 0,
                    ],
                    "sort"                         => 0,
                ],
                [
                    "recordId"                     => 1,
                    "seoModel"                     => [
                        "name"        => "name 1",
                        "url"         => "url-1",
                        "title"       => "title 1",
                        "keywords"    => "keywords 1",
                        "description" => "description 1",
                    ],
                    "textTextInstanceModel"        => [
                        "textId" => 1,
                        "text"   => ""
                    ],
                    "descriptionTextInstanceModel" => [
                        "textId" => 1,
                        "text"   => ""
                    ],
                    "imageGroupModel"              => [
                        "imageId" => 1,
                        "name"    => "record",
                        "sort"    => 0,
                    ],
                    "coverImageInstanceModel"      => [
                        "imageAlbumId" => 1,
                        "fileName"     => "record",
                        "isCover"      => false,
                        "sort"         => 0,
                        "alt"          => "",
                        "width"        => 0,
                        "height"       => 0,
                        "x1"           => 0,
                        "y1"           => 0,
                        "x2"           => 0,
                        "y2"           => 0,
                        "thumbX1"      => 0,
                        "thumbY1"      => 0,
                        "thumbX2"      => 0,
                        "thumbY2"      => 0,
                    ],
                    "sort"                         => 0,
                ],
                [
                    "recordId"                     => 1,
                    "seoModel"                     => [
                        "name"        => "name 2",
                        "url"         => "url-2",
                        "title"       => "title 2",
                        "keywords"    => "keywords 2",
                        "description" => "description 2",
                    ],
                    "textTextInstanceModel"        => [
                        "textId" => 1,
                        "text"   => "Text 2"
                    ],
                    "descriptionTextInstanceModel" => [
                        "textId" => 1,
                        "text"   => "Text 3"
                    ],
                    "imageGroupModel"              => [
                        "imageId" => 1,
                        "name"    => "Name 2",
                        "sort"    => 10,
                    ],
                    "coverImageInstanceModel"      => [
                        "imageAlbumId" => 1,
                        "fileName"     => "name.jpg",
                        "isCover"      => false,
                        "sort"         => 10,
                        "alt"          => "123",
                        "width"        => 10,
                        "height"       => 10,
                        "x1"           => 10,
                        "y1"           => 10,
                        "x2"           => 10,
                        "y2"           => 10,
                        "thumbX1"      => 10,
                        "thumbY1"      => 10,
                        "thumbX2"      => 10,
                        "thumbY2"      => 10,
                    ],
                    "sort"                         => 10,
                ],
                [
                    "recordId"                     => 1,
                    "seoModel"                     => [
                        "name"        => "name 2",
                        "url"         => "url-2",
                        "title"       => "title 2",
                        "keywords"    => "keywords 2",
                        "description" => "description 2",
                    ],
                    "textTextInstanceModel"        => [
                        "textId" => 1,
                        "text"   => "Text 2"
                    ],
                    "descriptionTextInstanceModel" => [
                        "textId" => 1,
                        "text"   => "Text 3"
                    ],
                    "imageGroupModel"              => [
                        "imageId" => 1,
                        "name"    => "Name 2",
                        "sort"    => 10,
                    ],
                    "coverImageInstanceModel"      => [
                        "imageAlbumId" => 1,
                        "fileName"     => "name.jpg",
                        "isCover"      => false,
                        "sort"         => 10,
                        "alt"          => "123",
                        "width"        => 10,
                        "height"       => 10,
                        "x1"           => 10,
                        "y1"           => 10,
                        "x2"           => 10,
                        "y2"           => 10,
                        "thumbX1"      => 10,
                        "thumbY1"      => 10,
                        "thumbX2"      => 10,
                        "thumbY2"      => 10,
                    ],
                    "sort"                         => 10,
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
        $this->markTestSkipped();
        return [];
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
                "recordId"                     => 1,
                "seoModel"                     => [
                    "name"        => "name 1",
                    "url"         => "url-1",
                    "title"       => "title 1",
                    "keywords"    => "keywords 1",
                    "description" => "description 1",
                ],
                "textTextInstanceModel"        => [
                    "textId" => 1,
                    "text"   => ""
                ],
                "descriptionTextInstanceModel" => [
                    "textId" => 1,
                    "text"   => ""
                ],
                "imageGroupModel"              => [
                    "imageId" => 1,
                    "name"    => "record",
                    "sort"    => 0,
                ],
                "coverImageInstanceModel"      => [
                    "imageAlbumId" => 1,
                    "fileName"     => "record",
                    "isCover"      => false,
                    "sort"         => 0,
                    "alt"          => "",
                    "width"        => 0,
                    "height"       => 0,
                    "x1"           => 0,
                    "y1"           => 0,
                    "x2"           => 0,
                    "y2"           => 0,
                    "thumbX1"      => 0,
                    "thumbY1"      => 0,
                    "thumbX2"      => 0,
                    "thumbY2"      => 0,
                ],
                "sort"                         => 0,
            ],
            [],
            self::EXCEPTION_MODEL
        );
    }
}