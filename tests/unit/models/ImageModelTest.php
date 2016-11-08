<?php

namespace testS\tests\unit\models;

use testS\components\Language;
use testS\models\ImageModel;

/**
 * Tests for model ImageModel
 *
 * @package testS\tests\unit\models
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
        return new ImageModel();
    }

    /**
     * Data provider for CRUD test
     *
     * @return array
     */
    public function dataProviderForCRUD()
    {
        return [
            $this->_dataProviderForCRUDNull(),
            $this->_dataProviderForCRUDEmpty(),
            $this->_dataProviderForCRUDCorrect(),
            $this->_dataProviderForCRUDIncorrectType(),
            $this->_dataProviderForCRUDIncorrectValue()
        ];
    }

    /**
     * Insert: null fields.
     * Update: null fields.
     *
     * @return array
     */
    private function _dataProviderForCRUDNull()
    {
        return [
            [],
            [
                "name" => ["required"],
            ],
            [],
            [
                "name" => ["required"],
            ]
        ];
    }

    /**
     * Insert: empty values.
     * Update: empty values.
     *
     * @return array
     */
    private function _dataProviderForCRUDEmpty()
    {
        return [
            [
                "designBlockId"       => "",
                "designImageSliderId" => "",
                "designImageZoomId"   => "",
                "designImageSimpleId" => "",
                "name"                => "name",
                "language"            => "",
                "type"                => "",
                "autoCropType"        => "",
                "cropWidth"           => "",
                "cropHeight"          => "",
                "cropX"               => "",
                "cropY"               => "",
                "thumbAutoCropType"   => "",
                "thumbCropX"          => "",
                "thumbCropY"          => "",
                "useAlbums"           => "",
            ],
            [
                "name"                => "name",
                "language"            => Language::$activeId,
                "type"                => ImageModel::TYPE_ZOOM,
                "autoCropType"        => ImageModel::AUTO_CROP_TYPE_NONE,
                "cropWidth"           => 0,
                "cropHeight"          => 0,
                "cropX"               => 0,
                "cropY"               => 0,
                "thumbAutoCropType"   => ImageModel::AUTO_CROP_TYPE_NONE,
                "thumbCropX"          => 0,
                "thumbCropY"          => 0,
                "useAlbums"           => false,
            ],
            [
                "designBlockId"       => "",
                "designImageSliderId" => "",
                "designImageZoomId"   => "",
                "designImageSimpleId" => "",
                "name"                => "",
                "language"            => "",
                "type"                => "",
                "autoCropType"        => "",
                "cropWidth"           => "",
                "cropHeight"          => "",
                "cropX"               => "",
                "cropY"               => "",
                "thumbAutoCropType"   => "",
                "thumbCropX"          => "",
                "thumbCropY"          => "",
                "useAlbums"           => "",
            ],
            [
                "name" => ["required"],
            ]
        ];
    }

    /**
     * Insert: correct values.
     * Update: correct values.
     *
     * @return array
     */
    private function _dataProviderForCRUDCorrect()
    {
        return [
            [
                "name"                => "name",
                "language"            => Language::LANGUAGE_EN_ID,
                "type"                => ImageModel::TYPE_ZOOM,
                "autoCropType"        => ImageModel::AUTO_CROP_TYPE_TOP_CENTER,
                "cropWidth"           => 300,
                "cropHeight"          => 300,
                "cropX"               => 1,
                "cropY"               => 1,
                "thumbAutoCropType"   => ImageModel::AUTO_CROP_TYPE_BOTTOM_CENTER,
                "thumbCropX"          => 1,
                "thumbCropY"          => 2,
                "useAlbums"           => true,
            ],
            [
                "name"                => "name",
                "language"            => Language::LANGUAGE_EN_ID,
                "type"                => ImageModel::TYPE_ZOOM,
                "autoCropType"        => ImageModel::AUTO_CROP_TYPE_TOP_CENTER,
                "cropWidth"           => 300,
                "cropHeight"          => 300,
                "cropX"               => 1,
                "cropY"               => 1,
                "thumbAutoCropType"   => ImageModel::AUTO_CROP_TYPE_BOTTOM_CENTER,
                "thumbCropX"          => 1,
                "thumbCropY"          => 2,
                "useAlbums"           => true,
            ],
            [
                "name"                => "  name <b>12</b> ",
                "language"            => Language::LANGUAGE_EN_ID,
                "type"                => ImageModel::TYPE_ZOOM,
                "autoCropType"        => ImageModel::AUTO_CROP_TYPE_TOP_RIGHT,
                "cropWidth"           => 0,
                "cropHeight"          => 0,
                "cropX"               => 3,
                "cropY"               => 1,
                "thumbAutoCropType"   => ImageModel::AUTO_CROP_TYPE_MIDDLE_LEFT,
                "thumbCropX"          => 4,
                "thumbCropY"          => 3,
                "useAlbums"           => false,
            ],
            [
                "name"                => "name 12",
                "language"            => Language::LANGUAGE_EN_ID,
                "type"                => ImageModel::TYPE_ZOOM,
                "autoCropType"        => ImageModel::AUTO_CROP_TYPE_TOP_RIGHT,
                "cropWidth"           => 0,
                "cropHeight"          => 0,
                "cropX"               => 3,
                "cropY"               => 1,
                "thumbAutoCropType"   => ImageModel::AUTO_CROP_TYPE_MIDDLE_LEFT,
                "thumbCropX"          => 4,
                "thumbCropY"          => 3,
                "useAlbums"           => false,
            ]
        ];
    }

    /**
     * Insert: values with incorrect type.
     * Update: values with incorrect type
     *
     * @return array
     */
    private function _dataProviderForCRUDIncorrectType()
    {
        return [
            [
                "designBlockId"       => "incorrect",
                "designImageSliderId" => "incorrect",
                "designImageZoomId"   => "incorrect",
                "designImageSimpleId" => "incorrect",
                "name"                => "incorrect",
                "language"            => "incorrect",
                "type"                => "incorrect",
                "autoCropType"        => "incorrect",
                "cropWidth"           => "incorrect",
                "cropHeight"          => "incorrect",
                "cropX"               => "incorrect",
                "cropY"               => "incorrect",
                "thumbAutoCropType"   => "incorrect",
                "thumbCropX"          => "incorrect",
                "thumbCropY"          => "incorrect",
                "useAlbums"           => "incorrect",
            ],
            [
                "name"                => "incorrect",
                "language"            => Language::$activeId,
                "type"                => ImageModel::TYPE_ZOOM,
                "autoCropType"        => ImageModel::AUTO_CROP_TYPE_NONE,
                "cropWidth"           => 0,
                "cropHeight"          => 0,
                "cropX"               => 0,
                "cropY"               => 0,
                "thumbAutoCropType"   => ImageModel::AUTO_CROP_TYPE_NONE,
                "thumbCropX"          => 0,
                "thumbCropY"          => 0,
                "useAlbums"           => true,
            ],
            [
                "designBlockId"       => "incorrect",
                "designImageSliderId" => "incorrect",
                "designImageZoomId"   => "incorrect",
                "designImageSimpleId" => "incorrect",
                "name"                => "incorrect",
                "language"            => "incorrect",
                "type"                => "incorrect",
                "autoCropType"        => "incorrect",
                "cropWidth"           => "incorrect",
                "cropHeight"          => "incorrect",
                "cropX"               => "incorrect",
                "cropY"               => "incorrect",
                "thumbAutoCropType"   => "incorrect",
                "thumbCropX"          => "incorrect",
                "thumbCropY"          => "incorrect",
                "useAlbums"           => "incorrect",
            ],
            [
                "name"                => "incorrect",
                "language"            => Language::$activeId,
                "type"                => ImageModel::TYPE_ZOOM,
                "autoCropType"        => ImageModel::AUTO_CROP_TYPE_NONE,
                "cropWidth"           => 0,
                "cropHeight"          => 0,
                "cropX"               => 0,
                "cropY"               => 0,
                "thumbAutoCropType"   => ImageModel::AUTO_CROP_TYPE_NONE,
                "thumbCropX"          => 0,
                "thumbCropY"          => 0,
                "useAlbums"           => true,
            ],
        ];
    }

    /**
     * Insert: incorrect values.
     * Update: incorrect values.
     *
     * @return array
     */
    private function _dataProviderForCRUDIncorrectValue()
    {
        return [
            [
                "name"                => "inco <asd",
                "language"            => 999,
                "type"                => 999,
                "autoCropType"        => 999,
                "cropWidth"           => -1,
                "cropHeight"          => -1,
                "cropX"               => -1,
                "cropY"               => -1,
                "thumbAutoCropType"   => 999,
                "thumbCropX"          => -2,
                "thumbCropY"          => -2,
                "useAlbums"           => 99,
            ],
            [
                "name"                => "inco",
                "language"            => Language::$activeId,
                "type"                => ImageModel::TYPE_ZOOM,
                "autoCropType"        => ImageModel::AUTO_CROP_TYPE_MIDDLE_CENTER,
                "cropWidth"           => 0,
                "cropHeight"          => 0,
                "cropX"               => 0,
                "cropY"               => 0,
                "thumbAutoCropType"   => ImageModel::AUTO_CROP_TYPE_MIDDLE_CENTER,
                "thumbCropX"          => 0,
                "thumbCropY"          => 0,
                "useAlbums"           => true,
            ],
            [
                "name"                => "inco<strongasd>asa<asd",
                "language"            => -999,
                "type"                => -999,
                "autoCropType"        => -999,
                "cropWidth"           => -10,
                "cropHeight"          => -10,
                "cropX"               => -10,
                "cropY"               => -10,
                "thumbAutoCropType"   => -999,
                "thumbCropX"          => -20,
                "thumbCropY"          => -20,
                "useAlbums"           => -99,
            ],
            [
                "name"                => "incoasa",
                "language"            => Language::$activeId,
                "type"                => ImageModel::TYPE_ZOOM,
                "autoCropType"        => ImageModel::AUTO_CROP_TYPE_MIDDLE_CENTER,
                "cropWidth"           => 0,
                "cropHeight"          => 0,
                "cropX"               => 0,
                "cropY"               => 0,
                "thumbAutoCropType"   => ImageModel::AUTO_CROP_TYPE_MIDDLE_CENTER,
                "thumbCropX"          => 0,
                "thumbCropY"          => 0,
                "useAlbums"           => true,
            ],
        ];
    }
}