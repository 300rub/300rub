<?php
//
//namespace testS\tests\unit\models;
//
//use testS\models\DesignImageZoomModel;
//
///**
// * Tests for model DesignImageZoomModel
// *
// * @package testS\tests\unit\models
// */
//class DesignImageZoomModelTest extends AbstractModelTest
//{
//
//    /**
//     * Model object
//     *
//     * @return DesignImageZoomModel
//     */
//    protected function getModel()
//    {
//        return new DesignImageZoomModel();
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
//            [
//                "hasScroll"            => false,
//                "thumbsAlignment"      => DesignImageZoomModel::THUMBS_ALIGNMENT_NONE,
//                "descriptionAlignment" => DesignImageZoomModel::DESCRIPTION_ALIGNMENT_NONE,
//                "effect"               => DesignImageZoomModel::EFFECT_NONE
//            ],
//            [],
//            [
//                "hasScroll"            => false,
//                "thumbsAlignment"      => DesignImageZoomModel::THUMBS_ALIGNMENT_NONE,
//                "descriptionAlignment" => DesignImageZoomModel::DESCRIPTION_ALIGNMENT_NONE,
//                "effect"               => DesignImageZoomModel::EFFECT_NONE
//            ]
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
//                "hasScroll"            => "",
//                "thumbsAlignment"      => "",
//                "descriptionAlignment" => "",
//                "effect"               => ""
//            ],
//            [
//                "hasScroll"            => false,
//                "thumbsAlignment"      => DesignImageZoomModel::THUMBS_ALIGNMENT_NONE,
//                "descriptionAlignment" => DesignImageZoomModel::DESCRIPTION_ALIGNMENT_NONE,
//                "effect"               => DesignImageZoomModel::EFFECT_NONE
//            ],
//            [
//                "designBlockId"        => "",
//                "hasScroll"            => "",
//                "thumbsAlignment"      => "",
//                "descriptionAlignment" => "",
//                "effect"               => ""
//            ],
//            [
//                "hasScroll"            => false,
//                "thumbsAlignment"      => DesignImageZoomModel::THUMBS_ALIGNMENT_NONE,
//                "descriptionAlignment" => DesignImageZoomModel::DESCRIPTION_ALIGNMENT_NONE,
//                "effect"               => DesignImageZoomModel::EFFECT_NONE
//            ]
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
//                "hasScroll"            => true,
//                "thumbsAlignment"      => DesignImageZoomModel::THUMBS_ALIGNMENT_LEFT,
//                "descriptionAlignment" => DesignImageZoomModel::DESCRIPTION_ALIGNMENT_BOTTOM,
//                "effect"               => DesignImageZoomModel::EFFECT_NONE
//            ],
//            [
//                "hasScroll"            => true,
//                "thumbsAlignment"      => DesignImageZoomModel::THUMBS_ALIGNMENT_LEFT,
//                "descriptionAlignment" => DesignImageZoomModel::DESCRIPTION_ALIGNMENT_BOTTOM,
//                "effect"               => DesignImageZoomModel::EFFECT_NONE
//            ],
//            [
//                "hasScroll"            => false,
//                "thumbsAlignment"      => DesignImageZoomModel::THUMBS_ALIGNMENT_RIGHT,
//                "descriptionAlignment" => DesignImageZoomModel::DESCRIPTION_ALIGNMENT_TOP,
//                "effect"               => DesignImageZoomModel::EFFECT_NONE
//            ],
//            [
//                "hasScroll"            => false,
//                "thumbsAlignment"      => DesignImageZoomModel::THUMBS_ALIGNMENT_RIGHT,
//                "descriptionAlignment" => DesignImageZoomModel::DESCRIPTION_ALIGNMENT_TOP,
//                "effect"               => DesignImageZoomModel::EFFECT_NONE
//            ]
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
//                "designBlockId"        => "incorrect",
//                "hasScroll"            => "incorrect",
//                "thumbsAlignment"      => "incorrect",
//                "descriptionAlignment" => "incorrect",
//                "effect"               => "incorrect",
//            ],
//            [
//                "hasScroll"            => true,
//                "thumbsAlignment"      => DesignImageZoomModel::THUMBS_ALIGNMENT_NONE,
//                "descriptionAlignment" => DesignImageZoomModel::DESCRIPTION_ALIGNMENT_NONE,
//                "effect"               => DesignImageZoomModel::EFFECT_NONE
//            ],
//            [
//                "designBlockId"        => "incorrect",
//                "hasScroll"            => "incorrect",
//                "thumbsAlignment"      => "incorrect",
//                "descriptionAlignment" => "incorrect",
//                "effect"               => "incorrect",
//            ],
//            [
//                "hasScroll"            => true,
//                "thumbsAlignment"      => DesignImageZoomModel::THUMBS_ALIGNMENT_NONE,
//                "descriptionAlignment" => DesignImageZoomModel::DESCRIPTION_ALIGNMENT_NONE,
//                "effect"               => DesignImageZoomModel::EFFECT_NONE
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
//                "hasScroll"            => 99,
//                "thumbsAlignment"      => 99,
//                "descriptionAlignment" => 99,
//                "effect"               => 99,
//            ],
//            [
//                "hasScroll"            => true,
//                "thumbsAlignment"      => DesignImageZoomModel::THUMBS_ALIGNMENT_NONE,
//                "descriptionAlignment" => DesignImageZoomModel::DESCRIPTION_ALIGNMENT_NONE,
//                "effect"               => DesignImageZoomModel::EFFECT_NONE
//            ],
//            [
//                "hasScroll"            => -99,
//                "thumbsAlignment"      => -99,
//                "descriptionAlignment" => -99,
//                "effect"               => -99,
//            ],
//            [
//                "hasScroll"            => true,
//                "thumbsAlignment"      => DesignImageZoomModel::THUMBS_ALIGNMENT_NONE,
//                "descriptionAlignment" => DesignImageZoomModel::DESCRIPTION_ALIGNMENT_NONE,
//                "effect"               => DesignImageZoomModel::EFFECT_NONE
//            ]
//        ];
//    }
//}