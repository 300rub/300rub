<?php
//
//namespace testS\tests\unit\models;
//
//use testS\models\ImageInstanceModel;
//
///**
// * Tests for model DesignImageZoomModel
// *
// * @package testS\tests\unit\models
// */
//class ImageInstanceModelTest extends AbstractModelTest
//{
//
//    /**
//     * Model object
//     *
//     * @return ImageInstanceModel
//     */
//    protected function getModel()
//    {
//        return new ImageInstanceModel();
//    }
//
//    /**
//     * Data provider for CRUD test
//     *
//     * @return array
//     */
//    public function dataProviderForCRUD()
//    {
//        return [
//            $this->_dataProviderForCRUDNull(),
//            $this->_dataProviderForCRUDEmpty(),
//            $this->_dataProviderForCRUDCorrect(),
//            $this->_dataProviderForCRUDIncorrectType(),
//            $this->_dataProviderForCRUDIncorrectValue()
//        ];
//    }
//
//    /**
//     * Insert: null fields.
//     * Update: null fields.
//     *
//     * @return array
//     */
//    private function _dataProviderForCRUDNull()
//    {
//        return [
//            [],
//            self::MODEL_EXCEPTION,
//        ];
//    }
//
//    /**
//     * Insert: empty values.
//     * Update: empty values.
//     *
//     * @return array
//     */
//    private function _dataProviderForCRUDEmpty()
//    {
//        return [
//            [
//                "imageAlbumId" => 1,
//                "isCover"      => false,
//                "sort"         => 0,
//                "alt"          => "",
//                "width"        => ImageInstanceModel::MIN_SIZE,
//                "height"       => ImageInstanceModel::MIN_SIZE,
//                "x1"           => 0,
//                "y1"           => 0,
//                "x2"           => 0,
//                "y2"           => 0,
//                "thumbX1"      => 0,
//                "thumbY1"      => 0,
//                "thumbX2"      => 0,
//                "thumbY2"      => 0,
//            ],
//            [
//                "isCover"      => false,
//                "sort"         => 0,
//                "alt"          => "",
//                "width"        => ImageInstanceModel::MIN_SIZE,
//                "height"       => ImageInstanceModel::MIN_SIZE,
//                "x1"           => 0,
//                "y1"           => 0,
//                "x2"           => ImageInstanceModel::MIN_SIZE,
//                "y2"           => ImageInstanceModel::MIN_SIZE,
//                "thumbX1"      => 0,
//                "thumbY1"      => 0,
//                "thumbX2"      => ImageInstanceModel::MIN_SIZE,
//                "thumbY2"      => ImageInstanceModel::MIN_SIZE,
//            ],
//            [
//                "isCover"      => "",
//                "sort"         => "",
//                "alt"          => "",
//                "width"        => "",
//                "height"       => "",
//                "x1"           => "",
//                "y1"           => "",
//                "x2"           => "",
//                "y2"           => "",
//                "thumbX1"      => "",
//                "thumbY1"      => "",
//                "thumbX2"      => "",
//                "thumbY2"      => "",
//            ],
//            [
//                "isCover"      => false,
//                "sort"         => 0,
//                "alt"          => "",
//                "width"        => ImageInstanceModel::MIN_SIZE,
//                "height"       => ImageInstanceModel::MIN_SIZE,
//                "x1"           => 0,
//                "y1"           => 0,
//                "x2"           => ImageInstanceModel::MIN_SIZE,
//                "y2"           => ImageInstanceModel::MIN_SIZE,
//                "thumbX1"      => 0,
//                "thumbY1"      => 0,
//                "thumbX2"      => ImageInstanceModel::MIN_SIZE,
//                "thumbY2"      => ImageInstanceModel::MIN_SIZE,
//            ],
//        ];
//    }
//
//    /**
//     * Insert: correct values.
//     * Update: correct values.
//     *
//     * @return array
//     */
//    private function _dataProviderForCRUDCorrect()
//    {
//        return [
//            [
//                "imageAlbumId" => 1,
//                "isCover"      => true,
//                "sort"         => 1,
//                "alt"          => "alt 1",
//                "width"        => 800,
//                "height"       => 600,
//                "x1"           => 10,
//                "y1"           => 10,
//                "x2"           => 500,
//                "y2"           => 500,
//                "thumbX1"      => 5,
//                "thumbY1"      => 5,
//                "thumbX2"      => 200,
//                "thumbY2"      => 200,
//            ],
//            [
//                "isCover"      => true,
//                "sort"         => 1,
//                "alt"          => "alt 1",
//                "width"        => 800,
//                "height"       => 600,
//                "x1"           => 10,
//                "y1"           => 10,
//                "x2"           => 500,
//                "y2"           => 500,
//                "thumbX1"      => 5,
//                "thumbY1"      => 5,
//                "thumbX2"      => 200,
//                "thumbY2"      => 200,
//            ],
//            [
//                "isCover"      => false,
//                "sort"         => 2,
//                "alt"          => "alt 2",
//                "width"        => 1024,
//                "height"       => 768,
//                "x1"           => 20,
//                "y1"           => 20,
//                "x2"           => 600,
//                "y2"           => 600,
//                "thumbX1"      => 15,
//                "thumbY1"      => 15,
//                "thumbX2"      => 150,
//                "thumbY2"      => 160,
//            ],
//            [
//                "isCover"      => false,
//                "sort"         => 2,
//                "alt"          => "alt 2",
//                "width"        => 1024,
//                "height"       => 768,
//                "x1"           => 20,
//                "y1"           => 20,
//                "x2"           => 600,
//                "y2"           => 600,
//                "thumbX1"      => 15,
//                "thumbY1"      => 15,
//                "thumbX2"      => 150,
//                "thumbY2"      => 160,
//            ],
//        ];
//    }
//
//    /**
//     * Insert: values with incorrect type.
//     * Update: values with incorrect type
//     *
//     * @return array
//     */
//    private function _dataProviderForCRUDIncorrectType()
//    {
//        return [
//            [
//                "imageAlbumId" => 1,
//                "isCover"      => "incorrect",
//                "sort"         => "incorrect",
//                "alt"          => 7,
//                "width"        => "incorrect",
//                "height"       => "incorrect",
//                "x1"           => "incorrect",
//                "y1"           => "incorrect",
//                "x2"           => "incorrect",
//                "y2"           => "incorrect",
//                "thumbX1"      => "incorrect",
//                "thumbY1"      => "incorrect",
//                "thumbX2"      => "incorrect",
//                "thumbY2"      => "incorrect",
//            ],
//            [
//                "isCover"      => true,
//                "sort"         => 0,
//                "alt"          => "7",
//                "width"        => ImageInstanceModel::MIN_SIZE,
//                "height"       => ImageInstanceModel::MIN_SIZE,
//                "x1"           => 0,
//                "y1"           => 0,
//                "x2"           => ImageInstanceModel::MIN_SIZE,
//                "y2"           => ImageInstanceModel::MIN_SIZE,
//                "thumbX1"      => 0,
//                "thumbY1"      => 0,
//                "thumbX2"      => ImageInstanceModel::MIN_SIZE,
//                "thumbY2"      => ImageInstanceModel::MIN_SIZE,
//            ],
//            [
//                "isCover"      => "incorrect",
//                "sort"         => "incorrect",
//                "alt"          => "<asd>asd",
//                "width"        => "incorrect",
//                "height"       => "incorrect",
//                "x1"           => "incorrect",
//                "y1"           => "incorrect",
//                "x2"           => "incorrect",
//                "y2"           => "incorrect",
//                "thumbX1"      => "incorrect",
//                "thumbY1"      => "incorrect",
//                "thumbX2"      => "incorrect",
//                "thumbY2"      => "incorrect",
//            ],
//            [
//                "isCover"      => true,
//                "sort"         => 0,
//                "alt"          => "asd",
//                "width"        => ImageInstanceModel::MIN_SIZE,
//                "height"       => ImageInstanceModel::MIN_SIZE,
//                "x1"           => 0,
//                "y1"           => 0,
//                "x2"           => ImageInstanceModel::MIN_SIZE,
//                "y2"           => ImageInstanceModel::MIN_SIZE,
//                "thumbX1"      => 0,
//                "thumbY1"      => 0,
//                "thumbX2"      => ImageInstanceModel::MIN_SIZE,
//                "thumbY2"      => ImageInstanceModel::MIN_SIZE,
//            ],
//        ];
//    }
//
//    /**
//     * Insert: incorrect values.
//     * Update: incorrect values.
//     *
//     * @return array
//     */
//    private function _dataProviderForCRUDIncorrectValue()
//    {
//        return [
//            [
//                "imageAlbumId" => 1,
//                "isCover"      => 999,
//                "sort"         => -10,
//                "alt"          => "<b>asd",
//                "width"        => 12,
//                "height"       => 300000,
//                "x1"           => 5000,
//                "y1"           => 5000,
//                "x2"           => 3000,
//                "y2"           => 3000,
//                "thumbX1"      => -10,
//                "thumbY1"      => 20,
//                "thumbX2"      => 500,
//                "thumbY2"      => 800,
//            ],
//            [
//                "sort"         => -10,
//                "alt"          => "asd",
//                "width"        => ImageInstanceModel::MIN_SIZE,
//                "height"       => ImageInstanceModel::MAX_SIZE,
//                "x1"           => 0,
//                "y1"           => ImageInstanceModel::MAX_SIZE - ImageInstanceModel::MIN_SIZE,
//                "x2"           => ImageInstanceModel::MIN_SIZE,
//                "y2"           => ImageInstanceModel::MAX_SIZE,
//                "thumbX1"      => 0,
//                "thumbY1"      => 20,
//                "thumbX2"      => ImageInstanceModel::MAX_THUMB_SIZE,
//                "thumbY2"      => ImageInstanceModel::MAX_THUMB_SIZE,
//            ],
//            [
//                "isCover"      => 999,
//                "sort"         => -180,
//                "alt"          => "<b>asd<ghj",
//                "width"        => ImageInstanceModel::MIN_SIZE,
//                "height"       => -300000,
//                "x1"           => 2,
//                "y1"           => 4,
//                "x2"           => 4,
//                "y2"           => -10,
//                "thumbX1"      => -55,
//                "thumbY1"      => -5,
//                "thumbX2"      => 23,
//                "thumbY2"      => 23,
//            ],
//            [
//                "isCover"      => true,
//                "sort"         => -180,
//                "alt"          => "asd",
//                "width"        => ImageInstanceModel::MIN_SIZE,
//                "height"       => ImageInstanceModel::MIN_SIZE,
//                "x1"           => 0,
//                "y1"           => 0,
//                "x2"           => ImageInstanceModel::MIN_SIZE,
//                "y2"           => ImageInstanceModel::MIN_SIZE,
//                "thumbX1"      => 0,
//                "thumbY1"      => 0,
//                "thumbX2"      => ImageInstanceModel::MIN_SIZE,
//                "thumbY2"      => ImageInstanceModel::MIN_SIZE,
//            ],
//        ];
//    }
//}