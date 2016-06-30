<?php

namespace tests\unit\models;

use models\ImageInstanceModel;
use models\ImageModel;

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
                    "file_name"      => "",
                    "image_album_id" => "",
                    "is_cover"       => "",
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
                    "thumb_x1"       => "",
                    "thumb_y1"       => "",
                    "thumb_x2"       => "",
                    "thumb_y2"       => "",
                ],
                [
                    "t.image_album_id" => "relation",
                ]
            ],
            // Correct data
            [
                [
                    "image_album_id" => 1,
                    "is_cover"       => 0,
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
                    "thumb_x1"       => 10,
                    "thumb_y1"       => 10,
                    "thumb_x2"       => 200,
                    "thumb_y2"       => 200,
                ],
                [],
                [
                    "image_album_id" => 1,
                    "is_cover"       => 0,
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
                    "thumb_x1"       => 10,
                    "thumb_y1"       => 10,
                    "thumb_x2"       => 200,
                    "thumb_y2"       => 200,
                ],
                [
                    "sort"           => 4,
                    "alt"            => "New Description",
                    "x1"             => 20,
                    "y1"             => 20,
                    "x2"             => 710,
                    "y2"             => 510,
                    "thumb_x1"       => 30,
                    "thumb_y1"       => 30,
                    "thumb_x2"       => 100,
                    "thumb_y2"       => 100,
                ],
                [],
                [
                    "sort"           => 4,
                    "alt"            => "New Description",
                    "x1"             => 20,
                    "y1"             => 20,
                    "x2"             => 710,
                    "y2"             => 510,
                    "thumb_x1"       => 30,
                    "thumb_y1"       => 30,
                    "thumb_x2"       => 100,
                    "thumb_y2"       => 100,
                ],
            ],
            // Incorrect data
            [
                [
                    "image_album_id" => 1,
                    "is_cover"       => "incorrect",
                    "sort"           => "incorrect",
                    "width"          => "incorrect",
                    "height"         => "incorrect",
                    "x1"             => "incorrect",
                    "y1"             => "incorrect",
                    "x2"             => "incorrect",
                    "y2"             => "incorrect",
                    "thumb_width"    => "incorrect",
                    "thumb_height"   => "incorrect",
                    "thumb_x1"       => "incorrect",
                    "thumb_y1"       => "incorrect",
                    "thumb_x2"       => "incorrect",
                    "thumb_y2"       => "incorrect",
                ],
                [],
                [
                    "is_cover"       => 0,
                    "sort"           => 0,
                    "width"          => ImageInstanceModel::MIN_SIZE,
                    "height"         => ImageInstanceModel::MIN_SIZE,
                    "x1"             => 0,
                    "y1"             => 0,
                    "x2"             => ImageInstanceModel::MIN_SIZE,
                    "y2"             => ImageInstanceModel::MIN_SIZE,
                    "thumb_width"    => ImageInstanceModel::MIN_SIZE,
                    "thumb_height"   => ImageInstanceModel::MIN_SIZE,
                    "thumb_x1"       => 0,
                    "thumb_y1"       => 0,
                    "thumb_x2"       => ImageInstanceModel::MIN_SIZE,
                    "thumb_y2"       => ImageInstanceModel::MIN_SIZE,
                ],
                [
                    "is_cover"       => -10,
                    "sort"           => -10,
                    "width"          => -10,
                    "height"         => -10,
                    "x1"             => -10,
                    "y1"             => -10,
                    "x2"             => -10,
                    "y2"             => -10,
                    "thumb_width"    => -10,
                    "thumb_height"   => -10,
                    "thumb_x1"       => -10,
                    "thumb_y1"       => -10,
                    "thumb_x2"       => -10,
                    "thumb_y2"       => -10,
                ],
                [],
                [
                    "is_cover"       => 0,
                    "sort"           => 0,
                    "width"          => ImageInstanceModel::MIN_SIZE,
                    "height"         => ImageInstanceModel::MIN_SIZE,
                    "x1"             => 0,
                    "y1"             => 0,
                    "x2"             => ImageInstanceModel::MIN_SIZE,
                    "y2"             => ImageInstanceModel::MIN_SIZE,
                    "thumb_width"    => ImageInstanceModel::MIN_SIZE,
                    "thumb_height"   => ImageInstanceModel::MIN_SIZE,
                    "thumb_x1"       => 0,
                    "thumb_y1"       => 0,
                    "thumb_x2"       => ImageInstanceModel::MIN_SIZE,
                    "thumb_y2"       => ImageInstanceModel::MIN_SIZE,
                ],
            ],
            // Incorrect data + correct but string values
            [
                [
                    "image_album_id" => 1,
                    "is_cover"       => 999,
                    "width"          => ImageInstanceModel::MAX_SIZE + 10,
                    "height"         => ImageInstanceModel::MAX_SIZE + 10,
                    "x1"             => ImageInstanceModel::MAX_SIZE + 10,
                    "y1"             => ImageInstanceModel::MAX_SIZE + 10,
                    "x2"             => ImageInstanceModel::MAX_SIZE + 10,
                    "y2"             => ImageInstanceModel::MAX_SIZE + 10,
                    "thumb_width"    => ImageInstanceModel::MAX_THUMB_SIZE + 10,
                    "thumb_height"   => ImageInstanceModel::MAX_THUMB_SIZE + 10,
                    "thumb_x1"       => ImageInstanceModel::MAX_THUMB_SIZE + 10,
                    "thumb_y1"       => ImageInstanceModel::MAX_THUMB_SIZE + 10,
                    "thumb_x2"       => ImageInstanceModel::MAX_THUMB_SIZE + 10,
                    "thumb_y2"       => ImageInstanceModel::MAX_THUMB_SIZE + 10,
                ],
                [],
                [
                    "is_cover"       => 1,
                    "width"          => ImageInstanceModel::MAX_SIZE,
                    "height"         => ImageInstanceModel::MAX_SIZE,
                    "x1"             => ImageInstanceModel::MAX_SIZE - ImageInstanceModel::MIN_SIZE,
                    "y1"             => ImageInstanceModel::MAX_SIZE - ImageInstanceModel::MIN_SIZE,
                    "x2"             => ImageInstanceModel::MAX_SIZE,
                    "y2"             => ImageInstanceModel::MAX_SIZE,
                    "thumb_width"    => ImageInstanceModel::MAX_THUMB_SIZE,
                    "thumb_height"   => ImageInstanceModel::MAX_THUMB_SIZE,
                    "thumb_x1"       => ImageInstanceModel::MAX_THUMB_SIZE - ImageInstanceModel::MIN_SIZE,
                    "thumb_y1"       => ImageInstanceModel::MAX_THUMB_SIZE - ImageInstanceModel::MIN_SIZE,
                    "thumb_x2"       => ImageInstanceModel::MAX_THUMB_SIZE,
                    "thumb_y2"       => ImageInstanceModel::MAX_THUMB_SIZE,
                ],
                [
                    "sort"           => "400",
                    "x1"             => "20",
                    "y1"             => "20",
                    "x2"             => "710",
                    "y2"             => "510",
                    "thumb_x1"       => "30",
                    "thumb_y1"       => "30",
                    "thumb_x2"       => "100",
                    "thumb_y2"       => "100",
                ],
                [],
                [
                    "sort"           => 400,
                    "x1"             => 20,
                    "y1"             => 20,
                    "x2"             => 710,
                    "y2"             => 510,
                    "thumb_x1"       => 30,
                    "thumb_y1"       => 30,
                    "thumb_x2"       => 100,
                    "thumb_y2"       => 100,
                ],
            ]
        ];
    }
}