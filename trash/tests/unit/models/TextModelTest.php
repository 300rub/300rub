<?php
//
//namespace testS\tests\unit\models;
//
//use testS\components\Language;
//use testS\models\TextModel;
//
///**
// * Tests for model TextModel
// *
// * @package tests\unit\models
// */
//class TextModelTest extends AbstractModelTest
//{
//
//    /**
//     * Model object
//     *
//     * @return TextModel
//     */
//    protected function getModel()
//    {
//        return new TextModel;
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
//            $this->_dataProviderForCRUDNameOnly(),
//            $this->_dataProviderForCRUDNameHtml(),
//            $this->_dataProviderForCRUDNameIncorrect(),
//            $this->_dataProviderForCRUDNameCorrect(),
//           $this->_dataProviderForCRUDNameWithRelations()
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
//            [
//                "name" => ["required"],
//            ]
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
//                "name"          => "",
//                "language"      => "",
//                "type"          => "",
//                "isEditor"      => "",
//                "text"          => "",
//                "designTextId"  => "",
//                "designBlockId" => "",
//            ],
//            [
//                "name" => ["required"],
//            ]
//        ];
//    }
//
//    /**
//     * Insert: only name
//     * Update: empty fields
//     *
//     * @return array
//     */
//    private function _dataProviderForCRUDNameOnly()
//    {
//        return [
//            [
//                "name" => "Text test name",
//            ],
//            [
//                "name"     => "Text test name",
//                "language" => Language::getActiveId(),
//                "type"     => TextModel::TYPE_DIV,
//                "isEditor" => 0,
//                "text"     => ""
//            ],
//            [],
//            [
//                "name"     => "Text test name",
//                "language" => Language::getActiveId(),
//                "type"     => TextModel::TYPE_DIV,
//                "isEditor" => 0,
//                "text"     => ""
//            ]
//        ];
//    }
//
//    /**
//     * Insert: only name with HTML tags.
//     * Update: empty name
//     *
//     * @return array
//     */
//    private function _dataProviderForCRUDNameHtml()
//    {
//        return [
//            [
//                "name" => "<b>Text</b> <i>test</i> <div>name</div>",
//            ],
//            [
//                "name" => "Text test name",
//            ],
//            [
//                "name" => "",
//            ],
//            [
//                "name" => ["required"],
//            ]
//        ];
//    }
//
//    /**
//     * Insert: incorrect format parameters.
//     * Update with incorrect values
//     *
//     * @return array
//     */
//    private function _dataProviderForCRUDNameIncorrect()
//    {
//        return [
//            [
//                "name"          => "Text test name",
//                "language"      => "incorrect language",
//                "type"          => "incorrect type",
//                "isEditor"      => "incorrect editor",
//                "designTextId"  => "incorrect design text",
//                "designBlockId" => "incorrect design block",
//            ],
//            [
//                "name"     => "Text test name",
//                "language" => Language::getActiveId(),
//                "type"     => TextModel::TYPE_DIV,
//                "isEditor" => true,
//                "text"     => ""
//            ],
//            [
//                "language"      => 99,
//                "type"          => 144,
//                "isEditor"      => 34,
//                "designTextId"  => 1111,
//                "designBlockId" => 3224,
//            ],
//            [
//                "language" => Language::getActiveId(),
//                "type"     => TextModel::TYPE_DIV,
//                "isEditor" => true,
//            ]
//        ];
//    }
//
//    /**
//     * Insert and update with correct parameters
//     *
//     * @return array
//     */
//    private function _dataProviderForCRUDNameCorrect()
//    {
//        return [
//            [
//                "name"     => "Text test name",
//                "language" => Language::LANGUAGE_EN_ID,
//                "type"     => TextModel::TYPE_H1,
//                "isEditor" => 1,
//                "text"     => "<b>Text</b>",
//            ],
//            [
//                "name"     => "Text test name",
//                "language" => Language::LANGUAGE_EN_ID,
//                "type"     => TextModel::TYPE_H1,
//                "isEditor" => 1,
//                "text"     => "<b>Text</b>",
//            ],
//            [
//                "language" => Language::LANGUAGE_RU_ID,
//                "type"     => TextModel::TYPE_H3,
//                "isEditor" => 0,
//                "text"     => "<i>New text</i>",
//            ],
//            [
//                "name"     => "Text test name",
//                "language" => Language::LANGUAGE_RU_ID,
//                "type"     => TextModel::TYPE_H3,
//                "isEditor" => 0,
//                "text"     => "<i>New text</i>",
//            ]
//        ];
//    }
//
//    /**
//     * Insert and update with design parameters
//     *
//     * @return array
//     */
//    private function _dataProviderForCRUDNameWithRelations()
//    {
//        return [
//            [
//                "name"            => "Text test name",
//                "designTextModel" => [
//                    "size"      => 20,
//                    "isItalic"  => true,
//                    "isBold"    => true
//                ]
//            ],
//            [
//                "designTextModel" => [
//                    "size"      => 20,
//                    "isItalic"  => true,
//                    "isBold"    => true
//                ]
//            ],
//            [
//                "designTextModel" => [
//                    "size"      => 30,
//                    "isItalic"  => false,
//                    "isBold"    => false
//                ]
//            ],
//            [
//                "designTextModel" => [
//                    "size"      => 30,
//                    "isItalic"  => false,
//                    "isBold"    => false
//                ]
//            ]
//        ];
//    }
//}