<?php

namespace tests\unit\models;

use models\ImageInstanceModel;
use models\ImageModel;
use components\Language;

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
                    "t.design_block_id"       => "",
                    "t.design_image_block_id" => "",
                    "t.crop_type"             => "",
                    "t.crop_width"            => "",
                    "t.crop_height"           => "",
                    "t.crop_x"                => "",
                    "t.crop_y"                => "",
                    "t.use_albums"            => "",
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
                    "t.crop_width"  => 800,
                    "t.crop_height" => 600,
                    "t.crop_x"      => 0,
                    "t.crop_y"      => 0,
                    "t.use_albums"  => 0,
                ],
                [],
                [
                    "t.name"        => "image name",
                    "t.language"    => Language::LANGUAGE_EN_ID,
                    "t.crop_type"   => ImageModel::CROP_TYPE_BOTTOM_CENTER,
                    "t.crop_width"  => 800,
                    "t.crop_height" => 600,
                    "t.crop_x"      => 0,
                    "t.crop_y"      => 0,
                    "t.use_albums"  => 0,
                ],
                [
                    "t.crop_type"   => ImageModel::CROP_TYPE_TOP_RIGHT,
                    "t.crop_width"  => 0,
                    "t.crop_height" => 0,
                    "t.crop_x"      => 1,
                    "t.crop_y"      => 1,
                    "t.use_albums"  => 1,
                ],
                [],
                [
                    "t.crop_type"   => ImageModel::CROP_TYPE_TOP_RIGHT,
                    "t.crop_width"  => 0,
                    "t.crop_height" => 0,
                    "t.crop_x"      => 1,
                    "t.crop_y"      => 1,
                    "t.use_albums"  => 1,
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
                    "t.crop_width"  => "incorrect",
                    "t.crop_height" => "incorrect",
                    "t.crop_x"      => "incorrect",
                    "t.crop_y"      => "incorrect",
                    "t.use_albums"  => "incorrect",
                ],
                [],
                [
                    "t.crop_type"   => 0,
                    "t.crop_width"  => 0,
                    "t.crop_height" => 0,
                    "t.crop_x"      => 0,
                    "t.crop_y"      => 0,
                    "t.use_albums"  => 0,
                ],
                [
                    "t.crop_type"   => 999,
                    "t.crop_width"  => -200,
                    "t.crop_height" => ImageInstanceModel::MAX_SIZE + 1,
                    "t.crop_x"      => -5,
                    "t.crop_y"      => -10,
                    "t.use_albums"  => 999,
                ],
                [],
                [
                    "t.crop_type"   => 0,
                    "t.crop_width"  => 0,
                    "t.crop_height" => ImageInstanceModel::MAX_SIZE,
                    "t.crop_x"      => 0,
                    "t.crop_y"      => 0,
                    "t.use_albums"  => 1,
                ],
            ],
            // Only one crop parameter
            [
                [
                    "t.name"        => "image name",
                    "t.language"    => Language::LANGUAGE_EN_ID,
                    "t.crop_type"   => ImageModel::CROP_TYPE_TOP_RIGHT,
                    "t.crop_width"  => 500,
                    "t.crop_height" => 0,
                    "t.crop_x"      => 2,
                    "t.crop_y"      => 0,
                ],
                [],
                [
                    "t.crop_width"  => 0,
                    "t.crop_height" => 0,
                    "t.crop_x"      => 0,
                    "t.crop_y"      => 0,
                ],
                [
                    "t.crop_width"  => 0,
                    "t.crop_height" => 300,
                    "t.crop_x"      => 0,
                    "t.crop_y"      => 3,
                    "t.use_albums"  => 0,
                ],
                [],
                [
                    "t.crop_width"  => 0,
                    "t.crop_height" => 0,
                    "t.crop_x"      => 0,
                    "t.crop_y"      => 0,
                ],
            ],
            // Empty and not-empty crop_height and crop_width
            [
                [
                    "t.name"        => "image name",
                    "t.language"    => Language::LANGUAGE_EN_ID,
                    "t.crop_type"   => ImageModel::CROP_TYPE_TOP_RIGHT,
                    "t.crop_width"  => 500,
                    "t.crop_height" => 0,
                    "t.crop_x"      => 2,
                    "t.crop_y"      => 1,
                ],
                [],
                [
                    "t.crop_width"  => 0,
                    "t.crop_height" => 0,
                    "t.crop_x"      => 2,
                    "t.crop_y"      => 1,
                ],
                [
                    "t.crop_width"  => 300,
                    "t.crop_height" => 300,
                    "t.crop_x"      => 3,
                    "t.crop_y"      => 4,
                ],
                [],
                [
                    "t.crop_width"  => 300,
                    "t.crop_height" => 300,
                    "t.crop_x"      => 0,
                    "t.crop_y"      => 0,
                ],
            ],
            // Empty and not-empty crop_type
            [
                [
                    "t.name"        => "image name",
                    "t.language"    => Language::LANGUAGE_EN_ID,
                    "t.crop_type"   => 0,
                    "t.crop_width"  => 500,
                    "t.crop_height" => 400,
                    "t.crop_x"      => 2,
                    "t.crop_y"      => 1,
                ],
                [],
                [
                    "t.crop_width"  => 0,
                    "t.crop_height" => 0,
                    "t.crop_x"      => 0,
                    "t.crop_y"      => 0,
                ],
                [
                    "t.crop_type"   => ImageModel::CROP_TYPE_TOP_RIGHT,
                    "t.crop_width"  => 500,
                    "t.crop_height" => 400,
                    "t.crop_x"      => 2,
                    "t.crop_y"      => 1,
                ],
                [],
                [
                    "t.crop_width"  => 500,
                    "t.crop_height" => 400,
                    "t.crop_x"      => 0,
                    "t.crop_y"      => 0,
                ],
            ],
        ];
    }
}