<?php
//
//namespace testS\tests\unit\models;
//
//use testS\models\DesignImageSliderModel;
//
///**
// * Tests for model DesignImageSimpleModel
// *
// * @package testS\tests\unit\models
// */
//class DesignImageSliderModelTest extends AbstractModelTest
//{
//
//    /**
//     * Model object
//     *
//     * @return DesignImageSliderModel
//     */
//    protected function getModel()
//    {
//        return new DesignImageSliderModel();
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
//                "effect"               => DesignImageSliderModel::EFFECT_NONE,
//                "hasAutoPlay"          => false,
//                "playSpeed"            => 0,
//                "navigationAlignment"  => DesignImageSliderModel::NAVIGATION_ALIGNMENT_NONE,
//                "descriptionAlignment" => DesignImageSliderModel::DESCRIPTION_ALIGNMENT_NONE,
//            ],
//            [],
//            [
//                "effect"               => DesignImageSliderModel::EFFECT_NONE,
//                "hasAutoPlay"          => false,
//                "playSpeed"            => 0,
//                "navigationAlignment"  => DesignImageSliderModel::NAVIGATION_ALIGNMENT_NONE,
//                "descriptionAlignment" => DesignImageSliderModel::DESCRIPTION_ALIGNMENT_NONE,
//            ],
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
//                "designBlockId"            => "",
//                "navigationDesignBlockId"  => "",
//                "descriptionDesignBlockId" => "",
//                "effect"                   => "",
//                "hasAutoPlay"              => "",
//                "playSpeed"                => "",
//                "navigationAlignment"      => "",
//                "descriptionAlignment"     => "",
//            ],
//            [
//                "effect"               => DesignImageSliderModel::EFFECT_NONE,
//                "hasAutoPlay"          => false,
//                "playSpeed"            => 0,
//                "navigationAlignment"  => DesignImageSliderModel::DESCRIPTION_ALIGNMENT_NONE,
//                "descriptionAlignment" => DesignImageSliderModel::DESCRIPTION_ALIGNMENT_NONE,
//            ],
//            [
//                "designBlockId"            => "",
//                "navigationDesignBlockId"  => "",
//                "descriptionDesignBlockId" => "",
//                "effect"                   => "",
//                "hasAutoPlay"              => "",
//                "playSpeed"                => "",
//                "navigationAlignment"      => "",
//                "descriptionAlignment"     => "",
//            ],
//            [
//                "effect"               => DesignImageSliderModel::EFFECT_NONE,
//                "hasAutoPlay"          => false,
//                "playSpeed"            => 0,
//                "navigationAlignment"  => DesignImageSliderModel::DESCRIPTION_ALIGNMENT_NONE,
//                "descriptionAlignment" => DesignImageSliderModel::DESCRIPTION_ALIGNMENT_NONE,
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
//                "effect"                   => DesignImageSliderModel::EFFECT_NONE,
//                "hasAutoPlay"              => true,
//                "playSpeed"                => 5,
//                "navigationAlignment"      => DesignImageSliderModel::NAVIGATION_ALIGNMENT_MIDDLE_CENTER,
//                "descriptionAlignment"     => DesignImageSliderModel::DESCRIPTION_ALIGNMENT_RIGHT,
//            ],
//            [
//                "effect"                   => DesignImageSliderModel::EFFECT_NONE,
//                "hasAutoPlay"              => true,
//                "playSpeed"                => 5,
//                "navigationAlignment"      => DesignImageSliderModel::NAVIGATION_ALIGNMENT_MIDDLE_CENTER,
//                "descriptionAlignment"     => DesignImageSliderModel::DESCRIPTION_ALIGNMENT_RIGHT,
//            ],
//            [
//                "effect"                   => DesignImageSliderModel::EFFECT_NONE,
//                "hasAutoPlay"              => false,
//                "playSpeed"                => 0,
//                "navigationAlignment"      => DesignImageSliderModel::NAVIGATION_ALIGNMENT_TOP_CENTER,
//                "descriptionAlignment"     => DesignImageSliderModel::DESCRIPTION_ALIGNMENT_LEFT,
//            ],
//            [
//                "effect"                   => DesignImageSliderModel::EFFECT_NONE,
//                "hasAutoPlay"              => false,
//                "playSpeed"                => 0,
//                "navigationAlignment"      => DesignImageSliderModel::NAVIGATION_ALIGNMENT_TOP_CENTER,
//                "descriptionAlignment"     => DesignImageSliderModel::DESCRIPTION_ALIGNMENT_LEFT,
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
//                "effect"               => "incorrect",
//                "hasAutoPlay"          => "incorrect",
//                "playSpeed"            => "incorrect",
//                "navigationAlignment"  => "incorrect",
//                "descriptionAlignment" => "incorrect",
//            ],
//            [
//                "effect"               => DesignImageSliderModel::EFFECT_NONE,
//                "hasAutoPlay"          => true,
//                "playSpeed"            => 0,
//                "navigationAlignment"  => DesignImageSliderModel::NAVIGATION_ALIGNMENT_NONE,
//                "descriptionAlignment" => DesignImageSliderModel::DESCRIPTION_ALIGNMENT_NONE,
//            ],
//            [
//                "effect"               => "incorrect",
//                "hasAutoPlay"          => "incorrect",
//                "playSpeed"            => "incorrect",
//                "navigationAlignment"  => "incorrect",
//                "descriptionAlignment" => "incorrect",
//            ],
//            [
//                "effect"               => DesignImageSliderModel::EFFECT_NONE,
//                "hasAutoPlay"          => true,
//                "playSpeed"            => 0,
//                "navigationAlignment"  => DesignImageSliderModel::NAVIGATION_ALIGNMENT_NONE,
//                "descriptionAlignment" => DesignImageSliderModel::DESCRIPTION_ALIGNMENT_NONE,
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
//                "effect"               => 5,
//                "hasAutoPlay"          => 99,
//                "playSpeed"            => "5",
//                "navigationAlignment"  => 999,
//                "descriptionAlignment" => 999,
//            ],
//            [
//                "effect"               => DesignImageSliderModel::EFFECT_NONE,
//                "hasAutoPlay"          => true,
//                "playSpeed"            => 5,
//                "navigationAlignment"  => DesignImageSliderModel::NAVIGATION_ALIGNMENT_BOTTOM_CENTER,
//                "descriptionAlignment" => DesignImageSliderModel::DESCRIPTION_ALIGNMENT_LEFT,
//            ],
//            [
//                "effect"               => -1,
//                "hasAutoPlay"          => -99,
//                "playSpeed"            => -5,
//                "navigationAlignment"  => -999,
//                "descriptionAlignment" => -999,
//            ],
//            [
//                "effect"               => DesignImageSliderModel::EFFECT_NONE,
//                "hasAutoPlay"          => true,
//                "playSpeed"            => 0,
//                "navigationAlignment"  => DesignImageSliderModel::NAVIGATION_ALIGNMENT_BOTTOM_CENTER,
//                "descriptionAlignment" => DesignImageSliderModel::DESCRIPTION_ALIGNMENT_LEFT,
//            ],
//        ];
//    }
//}