<?php

namespace tests\unit\models;

use testS\models\ImageInstanceModel;
use testS\models\ImageModel;

/**
 * Tests for model ImageModel
 *
 * @package tests\unit\models
 */
class ImageInstanceModelTest extends AbstractModelTest
{

    /**
     * Model object
     *
     * @return ImageModel
     */
    protected function getModel()
    {
        return new ImageInstanceModel;
    }

    /**
     * Data provider for CRUD test
     *
     * @return array
     */
    public function dataProviderForCRUD()
    {
        return [
            // Insert: empty values
            [
                [
                    "fileName"      => "",
                    "imageAlbumId" => "",
                    "isCover"       => "",
                    "sort"           => "",
                    "alt"            => "",
                    "width"          => "",
                    "height"         => "",
                    "x1"             => "",
                    "y1"             => "",
                    "x2"             => "",
                    "y2"             => "",
                    "thumb_width"    => "",
                    "thumb_height"   => "",
                    "thumbX1"       => "",
                    "thumbY1"       => "",
                    "thumbX2"       => "",
                    "thumbY2"       => "",
                ],
                [
                    "t.imageAlbumId" => "relation",
                ]
            ],
            // Correct data
            [
                [
                    "imageAlbumId" => 1,
                    "isCover"       => 0,
                    "sort"           => 1,
                    "alt"            => "Description",
                    "width"          => 1024,
                    "height"         => 768,
                    "x1"             => 10,
                    "y1"             => 10,
                    "x2"             => 810,
                    "y2"             => 610,
                    "thumb_width"    => 400,
                    "thumb_height"   => 300,
                    "thumbX1"       => 10,
                    "thumbY1"       => 10,
                    "thumbX2"       => 200,
                    "thumbY2"       => 200,
                ],
                [],
                [
                    "imageAlbumId" => 1,
                    "isCover"       => 0,
                    "sort"           => 1,
                    "alt"            => "Description",
                    "width"          => 1024,
                    "height"         => 768,
                    "x1"             => 10,
                    "y1"             => 10,
                    "x2"             => 810,
                    "y2"             => 610,
                    "thumb_width"    => 400,
                    "thumb_height"   => 300,
                    "thumbX1"       => 10,
                    "thumbY1"       => 10,
                    "thumbX2"       => 200,
                    "thumbY2"       => 200,
                ],
                [
                    "sort"           => 4,
                    "alt"            => "New Description",
                    "x1"             => 20,
                    "y1"             => 20,
                    "x2"             => 710,
                    "y2"             => 510,
                    "thumbX1"       => 30,
                    "thumbY1"       => 30,
                    "thumbX2"       => 100,
                    "thumbY2"       => 100,
                ],
                [],
                [
                    "sort"           => 4,
                    "alt"            => "New Description",
                    "x1"             => 20,
                    "y1"             => 20,
                    "x2"             => 710,
                    "y2"             => 510,
                    "thumbX1"       => 30,
                    "thumbY1"       => 30,
                    "thumbX2"       => 100,
                    "thumbY2"       => 100,
                ],
            ],
            // Incorrect data
            [
                [
                    "imageAlbumId" => 1,
                    "isCover"       => "incorrect",
                    "sort"           => "incorrect",
                    "width"          => "incorrect",
                    "height"         => "incorrect",
                    "x1"             => "incorrect",
                    "y1"             => "incorrect",
                    "x2"             => "incorrect",
                    "y2"             => "incorrect",
                    "thumb_width"    => "incorrect",
                    "thumb_height"   => "incorrect",
                    "thumbX1"       => "incorrect",
                    "thumbY1"       => "incorrect",
                    "thumbX2"       => "incorrect",
                    "thumbY2"       => "incorrect",
                ],
                [],
                [
                    "isCover"       => 0,
                    "sort"           => 0,
                    "width"          => ImageInstanceModel::MIN_SIZE,
                    "height"         => ImageInstanceModel::MIN_SIZE,
                    "x1"             => 0,
                    "y1"             => 0,
                    "x2"             => ImageInstanceModel::MIN_SIZE,
                    "y2"             => ImageInstanceModel::MIN_SIZE,
                    "thumb_width"    => ImageInstanceModel::MIN_SIZE,
                    "thumb_height"   => ImageInstanceModel::MIN_SIZE,
                    "thumbX1"       => 0,
                    "thumbY1"       => 0,
                    "thumbX2"       => ImageInstanceModel::MIN_SIZE,
                    "thumbY2"       => ImageInstanceModel::MIN_SIZE,
                ],
                [
                    "isCover"       => -10,
                    "sort"           => -10,
                    "width"          => -10,
                    "height"         => -10,
                    "x1"             => -10,
                    "y1"             => -10,
                    "x2"             => -10,
                    "y2"             => -10,
                    "thumb_width"    => -10,
                    "thumb_height"   => -10,
                    "thumbX1"       => -10,
                    "thumbY1"       => -10,
                    "thumbX2"       => -10,
                    "thumbY2"       => -10,
                ],
                [],
                [
                    "isCover"       => 0,
                    "sort"           => 0,
                    "width"          => ImageInstanceModel::MIN_SIZE,
                    "height"         => ImageInstanceModel::MIN_SIZE,
                    "x1"             => 0,
                    "y1"             => 0,
                    "x2"             => ImageInstanceModel::MIN_SIZE,
                    "y2"             => ImageInstanceModel::MIN_SIZE,
                    "thumb_width"    => ImageInstanceModel::MIN_SIZE,
                    "thumb_height"   => ImageInstanceModel::MIN_SIZE,
                    "thumbX1"       => 0,
                    "thumbY1"       => 0,
                    "thumbX2"       => ImageInstanceModel::MIN_SIZE,
                    "thumbY2"       => ImageInstanceModel::MIN_SIZE,
                ],
            ],
            // Incorrect data + correct but string values
            [
                [
                    "imageAlbumId" => 1,
                    "isCover"       => 999,
                    "width"          => ImageInstanceModel::MAX_SIZE + 10,
                    "height"         => ImageInstanceModel::MAX_SIZE + 10,
                    "x1"             => ImageInstanceModel::MAX_SIZE + 10,
                    "y1"             => ImageInstanceModel::MAX_SIZE + 10,
                    "x2"             => ImageInstanceModel::MAX_SIZE + 10,
                    "y2"             => ImageInstanceModel::MAX_SIZE + 10,
                    "thumb_width"    => ImageInstanceModel::MAX_THUMB_SIZE + 10,
                    "thumb_height"   => ImageInstanceModel::MAX_THUMB_SIZE + 10,
                    "thumbX1"       => ImageInstanceModel::MAX_THUMB_SIZE + 10,
                    "thumbY1"       => ImageInstanceModel::MAX_THUMB_SIZE + 10,
                    "thumbX2"       => ImageInstanceModel::MAX_THUMB_SIZE + 10,
                    "thumbY2"       => ImageInstanceModel::MAX_THUMB_SIZE + 10,
                ],
                [],
                [
                    "isCover"       => 1,
                    "width"          => ImageInstanceModel::MAX_SIZE,
                    "height"         => ImageInstanceModel::MAX_SIZE,
                    "x1"             => ImageInstanceModel::MAX_SIZE - ImageInstanceModel::MIN_SIZE,
                    "y1"             => ImageInstanceModel::MAX_SIZE - ImageInstanceModel::MIN_SIZE,
                    "x2"             => ImageInstanceModel::MAX_SIZE,
                    "y2"             => ImageInstanceModel::MAX_SIZE,
                    "thumb_width"    => ImageInstanceModel::MAX_THUMB_SIZE,
                    "thumb_height"   => ImageInstanceModel::MAX_THUMB_SIZE,
                    "thumbX1"       => ImageInstanceModel::MAX_THUMB_SIZE - ImageInstanceModel::MIN_SIZE,
                    "thumbY1"       => ImageInstanceModel::MAX_THUMB_SIZE - ImageInstanceModel::MIN_SIZE,
                    "thumbX2"       => ImageInstanceModel::MAX_THUMB_SIZE,
                    "thumbY2"       => ImageInstanceModel::MAX_THUMB_SIZE,
                ],
                [
                    "sort"           => "400",
                    "x1"             => "20",
                    "y1"             => "20",
                    "x2"             => "710",
                    "y2"             => "510",
                    "thumbX1"       => "30",
                    "thumbY1"       => "30",
                    "thumbX2"       => "100",
                    "thumbY2"       => "100",
                ],
                [],
                [
                    "sort"           => 400,
                    "x1"             => 20,
                    "y1"             => 20,
                    "x2"             => 710,
                    "y2"             => 510,
                    "thumbX1"       => 30,
                    "thumbY1"       => 30,
                    "thumbX2"       => 100,
                    "thumbY2"       => 100,
                ],
            ]
        ];
    }
}