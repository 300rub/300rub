<?php

namespace testS\tests\unit\models;

use testS\models\DesignTextModel;

/**
 * Tests for model DesignTextModel
 *
 * @package testS\tests\unit\models
 */
abstract class DesignTextModelTest extends AbstractModelTest
{

    /**
     * Model object
     *
     * @return DesignTextModel
     */
    protected function getModel()
    {
        return new DesignTextModel;
    }

    /**
     * Data provider for CRUD test
     *
     * @return array
     */
    public function dataProviderForCRUD()
    {
        return array_merge(
            $this->_dataProviderForCRUDNull(),
            $this->_dataProviderForCRUDEmpty(),
            $this->_dataProviderForCRUDCorrect(),
            $this->_dataProviderForCRUDIncorrectType(),
            $this->_dataProviderForCRUDIncorrectValue()
        );
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
            [
                [],
                [],
                [
                    "size"          => DesignTextModel::MIN_SIZE_VALUE,
                    "family"        => DesignTextModel::FAMILY_MYRAD,
                    "color"         => "",
                    "isItalic"      => false,
                    "isBold"        => false,
                    "align"         => DesignTextModel::TEXT_ALIGN_LEFT,
                    "decoration"    => DesignTextModel::TEXT_DECORATION_NONE,
                    "transform"     => DesignTextModel::TEXT_TRANSFORM_NONE,
                    "letterSpacing" => 0,
                    "lineHeight"    => DesignTextModel::DEFAULT_LINE_HEIGHT,
                ],
                [],
                [],
                [
                    "size"          => DesignTextModel::MIN_SIZE_VALUE,
                    "family"        => DesignTextModel::FAMILY_MYRAD,
                    "color"         => "",
                    "isItalic"      => false,
                    "isBold"        => false,
                    "align"         => DesignTextModel::TEXT_ALIGN_LEFT,
                    "decoration"    => DesignTextModel::TEXT_DECORATION_NONE,
                    "transform"     => DesignTextModel::TEXT_TRANSFORM_NONE,
                    "letterSpacing" => 0,
                    "lineHeight"    => DesignTextModel::DEFAULT_LINE_HEIGHT,
                ],
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
                [
                    "size"          => "",
                    "family"        => "",
                    "color"         => "",
                    "isItalic"      => "",
                    "isBold"        => "",
                    "align"         => "",
                    "decoration"    => "",
                    "transform"     => "",
                    "letterSpacing" => "",
                    "lineHeight"    => "",
                ],
                [],
                [
                    "size"          => DesignTextModel::MIN_SIZE_VALUE,
                    "family"        => DesignTextModel::FAMILY_MYRAD,
                    "color"         => "",
                    "isItalic"      => false,
                    "isBold"        => false,
                    "align"         => DesignTextModel::TEXT_ALIGN_LEFT,
                    "decoration"    => DesignTextModel::TEXT_DECORATION_NONE,
                    "transform"     => DesignTextModel::TEXT_TRANSFORM_NONE,
                    "letterSpacing" => 0,
                    "lineHeight"    => DesignTextModel::DEFAULT_LINE_HEIGHT,
                ],
                [
                    "size"          => "",
                    "family"        => "",
                    "color"         => "",
                    "isItalic"      => "",
                    "isBold"        => "",
                    "align"         => "",
                    "decoration"    => "",
                    "transform"     => "",
                    "letterSpacing" => "",
                    "lineHeight"    => "",
                ],
                [],
                [
                    "size"          => DesignTextModel::MIN_SIZE_VALUE,
                    "family"        => DesignTextModel::FAMILY_MYRAD,
                    "color"         => "",
                    "isItalic"      => false,
                    "isBold"        => false,
                    "align"         => DesignTextModel::TEXT_ALIGN_LEFT,
                    "decoration"    => DesignTextModel::TEXT_DECORATION_NONE,
                    "transform"     => DesignTextModel::TEXT_TRANSFORM_NONE,
                    "letterSpacing" => 0,
                    "lineHeight"    => DesignTextModel::DEFAULT_LINE_HEIGHT,
                ],
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
                [
                    "size"          => 20,
                    "family"        => DesignTextModel::FAMILY_ARIAL,
                    "color"         => "rgb(0,255,0)",
                    "isItalic"      => 1,
                    "isBold"        => 1,
                    "align"         => DesignTextModel::TEXT_ALIGN_CENTER,
                    "decoration"    => DesignTextModel::TEXT_DECORATION_UNDERLINE,
                    "transform"     => DesignTextModel::TEXT_TRANSFORM_CAPITALIZE,
                    "letterSpacing" => 10,
                    "lineHeight"    => 150,
                ],
                [],
                [
                    "size"          => 20,
                    "family"        => DesignTextModel::FAMILY_ARIAL,
                    "color"         => "rgb(0,255,0)",
                    "isItalic"      => true,
                    "isBold"        => true,
                    "align"         => DesignTextModel::TEXT_ALIGN_CENTER,
                    "decoration"    => DesignTextModel::TEXT_DECORATION_UNDERLINE,
                    "transform"     => DesignTextModel::TEXT_TRANSFORM_CAPITALIZE,
                    "letterSpacing" => 10,
                    "lineHeight"    => 150,
                ],
                [
                    "size"          => "30",
                    "family"        => DesignTextModel::FAMILY_GEORGIA,
                    "color"         => "rgba(20,255,40,0.5)",
                    "isItalic"      => "0",
                    "isBold"        => "0",
                    "align"         => DesignTextModel::TEXT_ALIGN_RIGHT,
                    "decoration"    => DesignTextModel::TEXT_DECORATION_LINE_THROUGH,
                    "transform"     => DesignTextModel::TEXT_TRANSFORM_LOWERCASE,
                    "letterSpacing" => "20",
                    "lineHeight"    => "100",
                ],
                [],
                [
                    "size"          => 30,
                    "family"        => DesignTextModel::FAMILY_GEORGIA,
                    "color"         => "rgba(20,255,40,0.5)",
                    "isItalic"      => false,
                    "isBold"        => false,
                    "align"         => DesignTextModel::TEXT_ALIGN_RIGHT,
                    "decoration"    => DesignTextModel::TEXT_DECORATION_LINE_THROUGH,
                    "transform"     => DesignTextModel::TEXT_TRANSFORM_LOWERCASE,
                    "letterSpacing" => 20,
                    "lineHeight"    => 100,
                ],
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
                [
                    "size"          => "incorrect_type",
                    "family"        => "incorrect_type",
                    "color"         => "incorrect_type",
                    "isItalic"      => "incorrect_type",
                    "isBold"        => "incorrect_type",
                    "align"         => "incorrect_type",
                    "decoration"    => "incorrect_type",
                    "transform"     => "incorrect_type",
                    "letterSpacing" => "incorrect_type",
                    "lineHeight"    => "incorrect_type",
                ],
                [],
                [
                    "size"          => DesignTextModel::MIN_SIZE_VALUE,
                    "family"        => DesignTextModel::FAMILY_MYRAD,
                    "color"         => "",
                    "isItalic"      => true,
                    "isBold"        => true,
                    "align"         => DesignTextModel::TEXT_ALIGN_LEFT,
                    "decoration"    => DesignTextModel::TEXT_DECORATION_NONE,
                    "transform"     => DesignTextModel::TEXT_TRANSFORM_NONE,
                    "letterSpacing" => 0,
                    "lineHeight"    => DesignTextModel::DEFAULT_LINE_HEIGHT,
                ],
                [
                    "size"          => "incorrect_type",
                    "family"        => "incorrect_type",
                    "color"         => "incorrect_type",
                    "isItalic"      => "incorrect_type",
                    "isBold"        => "incorrect_type",
                    "align"         => "incorrect_type",
                    "decoration"    => "incorrect_type",
                    "transform"     => "incorrect_type",
                    "letterSpacing" => "incorrect_type",
                    "lineHeight"    => "incorrect_type",
                ],
                [],
                [
                    "size"          => DesignTextModel::MIN_SIZE_VALUE,
                    "family"        => DesignTextModel::FAMILY_MYRAD,
                    "color"         => "",
                    "isItalic"      => true,
                    "isBold"        => true,
                    "align"         => DesignTextModel::TEXT_ALIGN_LEFT,
                    "decoration"    => DesignTextModel::TEXT_DECORATION_NONE,
                    "transform"     => DesignTextModel::TEXT_TRANSFORM_NONE,
                    "letterSpacing" => 0,
                    "lineHeight"    => DesignTextModel::DEFAULT_LINE_HEIGHT,
                ],
            ]
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
                [
                    "size"          => DesignTextModel::MIN_SIZE_VALUE - 1,
                    "family"        => 999,
                    "color"         => "0,255,0",
                    "isItalic"      => 8,
                    "isBold"        => 6,
                    "align"         => 67,
                    "decoration"    => 74,
                    "transform"     => 37,
                    "letterSpacing" => DesignTextModel::MIN_LETTER_SPACING_VALUE - 1,
                    "lineHeight"    => DesignTextModel::MIN_LINE_HEIGHT_VALUE - 1,
                ],
                [],
                [
                    "size"          => DesignTextModel::MIN_SIZE_VALUE,
                    "family"        => DesignTextModel::FAMILY_MYRAD,
                    "color"         => "",
                    "isItalic"      => true,
                    "isBold"        => true,
                    "align"         => DesignTextModel::TEXT_ALIGN_LEFT,
                    "decoration"    => DesignTextModel::TEXT_DECORATION_NONE,
                    "transform"     => DesignTextModel::TEXT_TRANSFORM_NONE,
                    "letterSpacing" => DesignTextModel::MIN_LETTER_SPACING_VALUE,
                    "lineHeight"    => DesignTextModel::MIN_LINE_HEIGHT_VALUE,
                ],
                [
                    "size"          => DesignTextModel::MIN_SIZE_VALUE - 100,
                    "family"        => -12,
                    "color"         => "#cccccc",
                    "isItalic"      => -3,
                    "isBold"        => -1,
                    "align"         => -10,
                    "decoration"    => -5,
                    "transform"     => -12,
                    "letterSpacing" => DesignTextModel::MIN_LETTER_SPACING_VALUE - 1,
                    "lineHeight"    => DesignTextModel::MIN_LINE_HEIGHT_VALUE - 1,
                ],
                [],
                [
                    "size"          => DesignTextModel::MIN_SIZE_VALUE,
                    "family"        => DesignTextModel::FAMILY_MYRAD,
                    "color"         => "",
                    "isItalic"      => true,
                    "isBold"        => true,
                    "align"         => DesignTextModel::TEXT_ALIGN_LEFT,
                    "decoration"    => DesignTextModel::TEXT_DECORATION_NONE,
                    "transform"     => DesignTextModel::TEXT_TRANSFORM_NONE,
                    "letterSpacing" => DesignTextModel::MIN_LETTER_SPACING_VALUE,
                    "lineHeight"    => DesignTextModel::MIN_LINE_HEIGHT_VALUE,
                ],
            ]
        ];
    }
}