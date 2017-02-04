<?php

namespace tests\unit\models;

use testS\models\ImageInstanceModel;
use testS\models\ImageModel;
use testS\components\Language;

/**
 * Tests for model ImageModel
 *
 * @package tests\unit\models
 */
class ImageModelTest extends AbstractModelTest
{

    /**
     * Model object
     *
     * @return ImageModel
     */
    protected function getModel()
    {
        return new ImageModel;
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
                [
                    "t.name" => "required",
                ]
            ],
            // Insert: empty values
            [
                [
                    "t.name"                  => "",
                    "t.language"              => "",
                    "t.designBlockId"       => "",
                    "t.design_image_block_id" => "",
                    "t.crop_type"             => "",
                    "t.cropWidth"            => "",
                    "t.cropHeight"           => "",
                    "t.cropX"                => "",
                    "t.cropY"                => "",
                    "t.useAlbums"            => "",
                ],
                [
                    "t.name" => "required",
                ]
            ],
            // Correct data
            [
                [
                    "t.name"        => "image name",
                    "t.language"    => Language::LANGUAGE_EN_ID,
                    "t.crop_type"   => ImageModel::CROP_TYPE_BOTTOM_CENTER,
                    "t.cropWidth"  => 800,
                    "t.cropHeight" => 600,
                    "t.cropX"      => 0,
                    "t.cropY"      => 0,
                    "t.useAlbums"  => 0,
                ],
                [],
                [
                    "t.name"        => "image name",
                    "t.language"    => Language::LANGUAGE_EN_ID,
                    "t.crop_type"   => ImageModel::CROP_TYPE_BOTTOM_CENTER,
                    "t.cropWidth"  => 800,
                    "t.cropHeight" => 600,
                    "t.cropX"      => 0,
                    "t.cropY"      => 0,
                    "t.useAlbums"  => 0,
                ],
                [
                    "t.crop_type"   => ImageModel::CROP_TYPE_TOP_RIGHT,
                    "t.cropWidth"  => 0,
                    "t.cropHeight" => 0,
                    "t.cropX"      => 1,
                    "t.cropY"      => 1,
                    "t.useAlbums"  => 1,
                ],
                [],
                [
                    "t.crop_type"   => ImageModel::CROP_TYPE_TOP_RIGHT,
                    "t.cropWidth"  => 0,
                    "t.cropHeight" => 0,
                    "t.cropX"      => 1,
                    "t.cropY"      => 1,
                    "t.useAlbums"  => 1,
                ],
            ],
            // Long name
            [
                [
                    "t.name" => "length more than 255 symbols length more than 255 symbols
						length more than 255 symbols length more than 255 symbols length more than 255 symbols
						length more than 255 symbols length more than 255 symbols length more than 255 symbols
						length more than 255 symbols length more than 255 symbols length more than 255 symbols",
                ],
                [
                    "t.name" => "max",
                ]
            ],
            // Incorrect data
            [
                [
                    "t.name"        => "image name",
                    "t.language"    => Language::LANGUAGE_EN_ID,
                    "t.crop_type"   => "incorrect",
                    "t.cropWidth"  => "incorrect",
                    "t.cropHeight" => "incorrect",
                    "t.cropX"      => "incorrect",
                    "t.cropY"      => "incorrect",
                    "t.useAlbums"  => "incorrect",
                ],
                [],
                [
                    "t.crop_type"   => 0,
                    "t.cropWidth"  => 0,
                    "t.cropHeight" => 0,
                    "t.cropX"      => 0,
                    "t.cropY"      => 0,
                    "t.useAlbums"  => 0,
                ],
                [
                    "t.crop_type"   => 999,
                    "t.cropWidth"  => -200,
                    "t.cropHeight" => ImageInstanceModel::MAX_SIZE + 1,
                    "t.cropX"      => -5,
                    "t.cropY"      => -10,
                    "t.useAlbums"  => 999,
                ],
                [],
                [
                    "t.crop_type"   => 0,
                    "t.cropWidth"  => 0,
                    "t.cropHeight" => ImageInstanceModel::MAX_SIZE,
                    "t.cropX"      => 0,
                    "t.cropY"      => 0,
                    "t.useAlbums"  => 1,
                ],
            ],
            // Only one crop parameter
            [
                [
                    "t.name"        => "image name",
                    "t.language"    => Language::LANGUAGE_EN_ID,
                    "t.crop_type"   => ImageModel::CROP_TYPE_TOP_RIGHT,
                    "t.cropWidth"  => 500,
                    "t.cropHeight" => 0,
                    "t.cropX"      => 2,
                    "t.cropY"      => 0,
                ],
                [],
                [
                    "t.cropWidth"  => 0,
                    "t.cropHeight" => 0,
                    "t.cropX"      => 0,
                    "t.cropY"      => 0,
                ],
                [
                    "t.cropWidth"  => 0,
                    "t.cropHeight" => 300,
                    "t.cropX"      => 0,
                    "t.cropY"      => 3,
                    "t.useAlbums"  => 0,
                ],
                [],
                [
                    "t.cropWidth"  => 0,
                    "t.cropHeight" => 0,
                    "t.cropX"      => 0,
                    "t.cropY"      => 0,
                ],
            ],
            // Empty and not-empty cropHeight and cropWidth
            [
                [
                    "t.name"        => "image name",
                    "t.language"    => Language::LANGUAGE_EN_ID,
                    "t.crop_type"   => ImageModel::CROP_TYPE_TOP_RIGHT,
                    "t.cropWidth"  => 500,
                    "t.cropHeight" => 0,
                    "t.cropX"      => 2,
                    "t.cropY"      => 1,
                ],
                [],
                [
                    "t.cropWidth"  => 0,
                    "t.cropHeight" => 0,
                    "t.cropX"      => 2,
                    "t.cropY"      => 1,
                ],
                [
                    "t.cropWidth"  => 300,
                    "t.cropHeight" => 300,
                    "t.cropX"      => 3,
                    "t.cropY"      => 4,
                ],
                [],
                [
                    "t.cropWidth"  => 300,
                    "t.cropHeight" => 300,
                    "t.cropX"      => 0,
                    "t.cropY"      => 0,
                ],
            ],
            // Empty and not-empty crop_type
            [
                [
                    "t.name"        => "image name",
                    "t.language"    => Language::LANGUAGE_EN_ID,
                    "t.crop_type"   => 0,
                    "t.cropWidth"  => 500,
                    "t.cropHeight" => 400,
                    "t.cropX"      => 2,
                    "t.cropY"      => 1,
                ],
                [],
                [
                    "t.cropWidth"  => 0,
                    "t.cropHeight" => 0,
                    "t.cropX"      => 0,
                    "t.cropY"      => 0,
                ],
                [
                    "t.crop_type"   => ImageModel::CROP_TYPE_TOP_RIGHT,
                    "t.cropWidth"  => 500,
                    "t.cropHeight" => 400,
                    "t.cropX"      => 2,
                    "t.cropY"      => 1,
                ],
                [],
                [
                    "t.cropWidth"  => 500,
                    "t.cropHeight" => 400,
                    "t.cropX"      => 0,
                    "t.cropY"      => 0,
                ],
            ],
        ];
    }
}