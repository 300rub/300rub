<?php
//
//namespace testS\tests\unit\models;
//
//use testS\models\GridLineModel;
//
///**
// * Tests for model GridModel
// *
// * @package tests\unit\models
// */
//class GridLineModelTest extends AbstractModelTest
//{
//
//    /**
//     * Model object
//     *
//     * @return GridLineModel
//     */
//    protected function getModel()
//    {
//        return new GridLineModel;
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
//            $this->_dataProviderForCRUDIncorrect()
//        ];
//    }
//
//    /**
//     * Insert: null data.
//     *
//     * @return array
//     */
//    private function _dataProviderForCRUDNull()
//    {
//        return [
//            [],
//            self::MODEL_EXCEPTION
//        ];
//    }
//
//    /**
//     * Insert: empty data.
//     *
//     * @return array
//     */
//    private function _dataProviderForCRUDEmpty()
//    {
//        return [
//            [
//                "sectionId"       => "",
//                "sort"            => "",
//                "outsideDesignId" => "",
//                "insideDesignId"  => "",
//            ],
//            self::MODEL_EXCEPTION
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
//                "sectionId"       => 1,
//                "sort"            => 0,
//                "outsideDesignId" => "",
//                "insideDesignId"  => "",
//            ],
//            [
//                "sectionId" => 1,
//                "sort"      => 0,
//            ],
//            [
//                "sort" => 2,
//            ],
//            [
//                "sectionId" => 1,
//                "sort"      => 2,
//            ]
//        ];
//    }
//
//    /**
//     * Insert: incorrect values.
//     * Update: incorrect values.
//     *
//     * @return array
//     */
//    private function _dataProviderForCRUDIncorrect()
//    {
//        return [
//            [
//                "sectionId"       => 1,
//                "sort"            => "incorrect value",
//                "outsideDesignId" => "incorrect value",
//                "insideDesignId"  => "incorrect value",
//            ],
//            [
//                "sectionId" => 1,
//                "sort"      => 0,
//            ],
//            [
//                "sort" => "incorrect value",
//            ],
//            [
//                "sectionId" => 1,
//                "sort"      => 0,
//            ]
//        ];
//    }
//}