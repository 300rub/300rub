<?php

namespace tests\unit\models;

use models\ImageAlbumModel;

/**
 * Tests for model ImageAlbumModel
 *
 * @package tests\unit\models
 */
class ImageAlbumModelTest extends AbstractModelTest
{

    /**
     * Model object
     *
     * @return ImageAlbumModel
     */
    protected function getModel()
    {
        return new ImageAlbumModel;
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
                    "t.name"     => "",
                    "t.imageId" => [],
                    "t.sort"     => [],
                ],
                [
                    "t.name" => "required",
                ]
            ],
            // Correct data
            [
                [
                    "t.name"     => "image album name",
                    "t.imageId" => 1,
                    "t.sort"     => 1,
                ],
                [],
                [
                    "t.name"     => "image album name",
                    "t.imageId" => 1,
                    "t.sort"     => 1,
                ],
                [
                    "t.name"     => "image album new name",
                    "t.imageId" => 2,
                    "t.sort"     => 200,
                ],
                [],
                [
                    "t.name"     => "image album new name",
                    "t.imageId" => 2,
                    "t.sort"     => 200,
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
            // Incorrect imageId
            [
                [
                    "t.name"     => "image album name",
                    "t.imageId" => "incorrect",
                    "t.sort"     => "incorrect",
                ],
                [
                    "t.imageId" => "relation",
                ]
            ],
            // Incorrect sort
            [
                [
                    "t.name"     => "image album name",
                    "t.imageId" => 1,
                    "t.sort"     => "incorrect",
                ],
                [],
                [
                    "t.sort" => 0,
                ],
                [
                    "t.sort" => -19,
                ],
                [],
                [
                    "t.sort" => 0,
                ],
            ],
        ];
    }
}