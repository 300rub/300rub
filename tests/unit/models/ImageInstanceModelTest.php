<?php

namespace testS\tests\unit\models;

use testS\models\ImageInstanceModel;

/**
 * Tests for the model ImageInstanceModel
 *
 * @package testS\tests\unit\models
 */
class ImageInstanceModelTest extends AbstractModelTest
{

    /**
     * Gets model name
     *
     * @return ImageInstanceModel
     */
    protected function getNewModel()
    {
        return new ImageInstanceModel();
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
                    "imageAlbumId" => "",
                    "originalFileModel"    => "",
                    "viewFileModel"    => "",
                    "thumbFileModel"    => "",
                    "isCover"      => "",
                    "sort"         => "",
                    "alt"          => "",
                    "width"        => "",
                    "height"       => "",
                    "x1"           => "",
                    "y1"           => "",
                    "x2"           => "",
                    "y2"           => "",
                    "thumbX1"      => "",
                    "thumbY1"      => "",
                    "thumbX2"      => "",
                    "thumbY2"      => "",
                ],
                [],
                null,
                null,
                self::EXCEPTION_MODEL
            ],
            "empty3" => [
                [
                    "originalFileModel" => [
                        "uniqueName" => "file7.jpg",
                    ],
                    "viewFileModel" => [
                        "uniqueName" => "view_file7.jpg",
                    ],
                    "thumbFileModel" => [
                        "uniqueName" => "thumb_file7.jpg",
                    ]
                ],
                [],
                null,
                null,
                self::EXCEPTION_MODEL
            ],
            "empty4" => [
                [
                    "imageAlbumId" => 1,
                    "originalFileModel" => [
                        "uniqueName" => "file.jpg",
                    ],
                    "viewFileModel" => [
                        "uniqueName" => "view_file.jpg",
                    ],
                    "thumbFileModel" => [
                        "uniqueName" => "thumb_file.jpg",
                    ]
                ],
                [
                    "imageAlbumId" => 1,
                    "originalFileModel" => [
                        "uniqueName" => "file.jpg",
                    ],
                    "viewFileModel" => [
                        "uniqueName" => "view_file.jpg",
                    ],
                    "thumbFileModel" => [
                        "uniqueName" => "thumb_file.jpg",
                    ],
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
                    "imageAlbumId" => 1,
                    "originalFileModel" => [
                        "uniqueName" => "file.jpg",
                    ],
                    "viewFileModel" => [
                        "uniqueName" => "view_file.jpg",
                    ],
                    "thumbFileModel" => [
                        "uniqueName" => "thumb_file.jpg",
                    ],
                    "isCover"      => true,
                    "sort"         => 10,
                    "alt"          => "Alt 1",
                    "width"        => 800,
                    "height"       => 600,
                    "x1"           => 10,
                    "y1"           => 30,
                    "x2"           => 70,
                    "y2"           => 80,
                    "thumbX1"      => 5,
                    "thumbY1"      => 15,
                    "thumbX2"      => 35,
                    "thumbY2"      => 45,
                ],
                [
                    "imageAlbumId" => 1,
                    "originalFileModel" => [
                        "uniqueName" => "file.jpg",
                    ],
                    "viewFileModel" => [
                        "uniqueName" => "view_file.jpg",
                    ],
                    "thumbFileModel" => [
                        "uniqueName" => "thumb_file.jpg",
                    ],
                    "isCover"      => true,
                    "sort"         => 10,
                    "alt"          => "Alt 1",
                    "width"        => 800,
                    "height"       => 600,
                    "x1"           => 10,
                    "y1"           => 30,
                    "x2"           => 70,
                    "y2"           => 80,
                    "thumbX1"      => 5,
                    "thumbY1"      => 15,
                    "thumbX2"      => 35,
                    "thumbY2"      => 45,
                ],
                [
                    "imageAlbumId" => 1,
                    "originalFileModel" => [
                        "uniqueName" => "file2.jpg",
                    ],
                    "viewFileModel" => [
                        "uniqueName" => "view_file2.jpg",
                    ],
                    "thumbFileModel" => [
                        "uniqueName" => "thumb_file2.jpg",
                    ],
                    "isCover"      => false,
                    "sort"         => 20,
                    "alt"          => "Alt 2",
                    "width"        => 1024,
                    "height"       => 768,
                    "x1"           => 100,
                    "y1"           => 300,
                    "x2"           => 700,
                    "y2"           => 800,
                    "thumbX1"      => 50,
                    "thumbY1"      => 115,
                    "thumbX2"      => 135,
                    "thumbY2"      => 145,
                ],
                [
                    "imageAlbumId" => 1,
                    "originalFileModel" => [
                        "uniqueName" => "file2.jpg",
                    ],
                    "viewFileModel" => [
                        "uniqueName" => "view_file2.jpg",
                    ],
                    "thumbFileModel" => [
                        "uniqueName" => "thumb_file2.jpg",
                    ],
                    "isCover"      => false,
                    "sort"         => 20,
                    "alt"          => "Alt 2",
                    "width"        => 1024,
                    "height"       => 768,
                    "x1"           => 100,
                    "y1"           => 300,
                    "x2"           => 700,
                    "y2"           => 800,
                    "thumbX1"      => 50,
                    "thumbY1"      => 115,
                    "thumbX2"      => 135,
                    "thumbY2"      => 145,
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
                    "imageAlbumId" => "incorrect",
                    "originalFileModel" => [
                        "uniqueName" => "incorrect",
                    ],
                    "viewFileModel" => [
                        "uniqueName" => "view_incorrect.jpg",
                    ],
                    "thumbFileModel" => [
                        "uniqueName" => "thumb_incorrect.jpg",
                    ],
                    "isCover"      => "incorrect",
                    "sort"         => "incorrect",
                    "alt"          => "incorrect",
                    "width"        => "incorrect",
                    "height"       => "incorrect",
                    "x1"           => "incorrect",
                    "y1"           => "incorrect",
                    "x2"           => "incorrect",
                    "y2"           => "incorrect",
                    "thumbX1"      => "incorrect",
                    "thumbY1"      => "incorrect",
                    "thumbX2"      => "incorrect",
                    "thumbY2"      => "incorrect",
                ],
                [],
                null,
                null,
                self::EXCEPTION_MODEL
            ],
            "incorrect2" => [
                [
                    "imageAlbumId" => "1 ",
                    "originalFileModel" => [
                        "uniqueName" => "<b> 123 </b>",
                    ],
                    "viewFileModel" => [
                        "uniqueName" => "<b> view_123 </b>",
                    ],
                    "thumbFileModel" => [
                        "uniqueName" => "<b> thumb_123 </b>",
                    ],
                    "isCover"      => "incorrect",
                    "sort"         => "incorrect",
                    "alt"          => "incorrect",
                    "width"        => "incorrect",
                    "height"       => "incorrect",
                    "x1"           => "incorrect",
                    "y1"           => "incorrect",
                    "x2"           => "incorrect",
                    "y2"           => "incorrect",
                    "thumbX1"      => "incorrect",
                    "thumbY1"      => "incorrect",
                    "thumbX2"      => "incorrect",
                    "thumbY2"      => "incorrect",
                ],
                [
                    "imageAlbumId" => 1,
                    "originalFileModel" => [
                        "uniqueName" => "123",
                    ],
                    "viewFileModel" => [
                        "uniqueName" => "view_123",
                    ],
                    "thumbFileModel" => [
                        "uniqueName" => "thumb_123",
                    ],
                    "isCover"      => false,
                    "sort"         => 0,
                    "alt"          => "incorrect",
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
                [
                    "originalFileModel" => [
                        "uniqueName" => $this->generateStringWithLength(26),
                    ],
                    "viewFileModel" => [
                        "uniqueName" => $this->generateStringWithLength(26),
                    ],
                    "thumbFileModel" => [
                        "uniqueName" => $this->generateStringWithLength(26),
                    ],
                ],
                [
                    "originalFileModel" => [
                        "uniqueName" => ["maxLength"]
                    ],
                    "viewFileModel" => [
                        "uniqueName" => ["maxLength"]
                    ],
                    "thumbFileModel" => [
                        "uniqueName" => ["maxLength"]
                    ],
                ]
            ],
            "incorrect3" => [
                [
                    "imageAlbumId" => "1 ",
                    "originalFileModel" => [
                        "uniqueName" => 12345
                    ],
                    "viewFileModel" => [
                        "uniqueName" => 11111
                    ],
                    "thumbFileModel" => [
                        "uniqueName" => 22222
                    ],
                    "isCover"      => 9999,
                    "sort"         => 9999,
                    "alt"          => 9999,
                    "width"        => 9999,
                    "height"       => 9999,
                    "x1"           => 9999,
                    "y1"           => 9999,
                    "x2"           => 9999,
                    "y2"           => 9999,
                    "thumbX1"      => 9999,
                    "thumbY1"      => 9999,
                    "thumbX2"      => 9999,
                    "thumbY2"      => 9999,
                ],
                [
                    "imageAlbumId" => 1,
                    "originalFileModel" => [
                        "uniqueName" => "12345",
                    ],
                    "viewFileModel" => [
                        "uniqueName" => "11111",
                    ],
                    "thumbFileModel" => [
                        "uniqueName" => "22222",
                    ],
                    "isCover"      => true,
                    "sort"         => 9999,
                    "alt"          => "9999",
                    "width"        => 2000,
                    "height"       => 2000,
                    "x1"           => 2000,
                    "y1"           => 2000,
                    "x2"           => 2000,
                    "y2"           => 2000,
                    "thumbX1"      => 300,
                    "thumbY1"      => 300,
                    "thumbX2"      => 300,
                    "thumbY2"      => 300,
                ],
                [
                    "isCover" => -10,
                    "sort"    => -10,
                    "alt"     => -10,
                    "width"   => -10,
                    "height"  => -10,
                    "x1"      => -10,
                    "y1"      => -10,
                    "x2"      => -10,
                    "y2"      => -10,
                    "thumbX1" => -10,
                    "thumbY1" => -10,
                    "thumbX2" => -10,
                    "thumbY2" => -10,
                ],
                [
                    "imageAlbumId" => 1,
                    "originalFileModel" => [
                        "uniqueName" => "12345",
                    ],
                    "viewFileModel" => [
                        "uniqueName" => "11111",
                    ],
                    "thumbFileModel" => [
                        "uniqueName" => "22222",
                    ],
                    "isCover"      => false,
                    "sort"         => -10,
                    "alt"          => "-10",
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
                "imageAlbumId" => 1,
                "originalFileModel" => [
                    "uniqueName" => "file.jpg",
                ],
                "viewFileModel" => [
                    "uniqueName" => "view_file.jpg",
                ],
                "thumbFileModel" => [
                    "uniqueName" => "thumb_file.jpg",
                ],
                "isCover"      => true,
                "sort"         => 10,
                "alt"          => "Alt 1",
                "width"        => 800,
                "height"       => 600,
                "x1"           => 10,
                "y1"           => 30,
                "x2"           => 70,
                "y2"           => 80,
                "thumbX1"      => 5,
                "thumbY1"      => 15,
                "thumbX2"      => 35,
                "thumbY2"      => 45,
            ],
            [],
            self::EXCEPTION_MODEL
        );
    }
}