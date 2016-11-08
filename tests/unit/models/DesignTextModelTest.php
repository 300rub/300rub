<?php

namespace testS\tests\unit\models;

use testS\models\DesignTextModel;

/**
 * Tests for model DesignTextModel
 *
 * @package testS\tests\unit\models
 */
class DesignTextModelTest extends AbstractModelTest
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
                "size"               => DesignTextModel::MIN_SIZE_VALUE,
                "family"             => DesignTextModel::FAMILY_MYRAD,
                "color"              => "",
                "isItalic"           => false,
                "isBold"             => false,
                "align"              => DesignTextModel::TEXT_ALIGN_LEFT,
                "decoration"         => DesignTextModel::TEXT_DECORATION_NONE,
                "transform"          => DesignTextModel::TEXT_TRANSFORM_NONE,
                "letterSpacing"      => 0,
                "lineHeight"         => DesignTextModel::DEFAULT_LINE_HEIGHT,
                "sizeHover"          => DesignTextModel::MIN_SIZE_VALUE,
                "colorHover"         => "",
                "isItalicHover"      => false,
                "isBoldHover"        => false,
                "decorationHover"    => DesignTextModel::TEXT_DECORATION_NONE,
                "transformHover"     => DesignTextModel::TEXT_TRANSFORM_NONE,
                "letterSpacingHover" => 0,
                "lineHeightHover"    => DesignTextModel::DEFAULT_LINE_HEIGHT,
            ],
            [],
            [
                "size"               => DesignTextModel::MIN_SIZE_VALUE,
                "family"             => DesignTextModel::FAMILY_MYRAD,
                "color"              => "",
                "isItalic"           => false,
                "isBold"             => false,
                "align"              => DesignTextModel::TEXT_ALIGN_LEFT,
                "decoration"         => DesignTextModel::TEXT_DECORATION_NONE,
                "transform"          => DesignTextModel::TEXT_TRANSFORM_NONE,
                "letterSpacing"      => 0,
                "lineHeight"         => DesignTextModel::DEFAULT_LINE_HEIGHT,
                "sizeHover"          => DesignTextModel::MIN_SIZE_VALUE,
                "colorHover"         => "",
                "isItalicHover"      => false,
                "isBoldHover"        => false,
                "decorationHover"    => DesignTextModel::TEXT_DECORATION_NONE,
                "transformHover"     => DesignTextModel::TEXT_TRANSFORM_NONE,
                "letterSpacingHover" => 0,
                "lineHeightHover"    => DesignTextModel::DEFAULT_LINE_HEIGHT,
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
                "size"               => "",
                "family"             => "",
                "color"              => "",
                "isItalic"           => "",
                "isBold"             => "",
                "align"              => "",
                "decoration"         => "",
                "transform"          => "",
                "letterSpacing"      => "",
                "lineHeight"         => "",
                "sizeHover"          => "",
                "colorHover"         => "",
                "isItalicHover"      => "",
                "isBoldHover"        => "",
                "decorationHover"    => "",
                "transformHover"     => "",
                "letterSpacingHover" => "",
                "lineHeightHover"    => "",
            ],
            [
                "size"               => DesignTextModel::MIN_SIZE_VALUE,
                "family"             => DesignTextModel::FAMILY_MYRAD,
                "color"              => "",
                "isItalic"           => false,
                "isBold"             => false,
                "align"              => DesignTextModel::TEXT_ALIGN_LEFT,
                "decoration"         => DesignTextModel::TEXT_DECORATION_NONE,
                "transform"          => DesignTextModel::TEXT_TRANSFORM_NONE,
                "letterSpacing"      => 0,
                "lineHeight"         => DesignTextModel::DEFAULT_LINE_HEIGHT,
                "sizeHover"          => DesignTextModel::MIN_SIZE_VALUE,
                "colorHover"         => "",
                "isItalicHover"      => false,
                "isBoldHover"        => false,
                "decorationHover"    => DesignTextModel::TEXT_DECORATION_NONE,
                "transformHover"     => DesignTextModel::TEXT_TRANSFORM_NONE,
                "letterSpacingHover" => 0,
                "lineHeightHover"    => DesignTextModel::DEFAULT_LINE_HEIGHT,
            ],
            [
                "size"               => "",
                "family"             => "",
                "color"              => "",
                "isItalic"           => "",
                "isBold"             => "",
                "align"              => "",
                "decoration"         => "",
                "transform"          => "",
                "letterSpacing"      => "",
                "lineHeight"         => "",
                "sizeHover"          => "",
                "colorHover"         => "",
                "isItalicHover"      => "",
                "isBoldHover"        => "",
                "decorationHover"    => "",
                "transformHover"     => "",
                "letterSpacingHover" => "",
                "lineHeightHover"    => "",
            ],
            [
                "size"               => DesignTextModel::MIN_SIZE_VALUE,
                "family"             => DesignTextModel::FAMILY_MYRAD,
                "color"              => "",
                "isItalic"           => false,
                "isBold"             => false,
                "align"              => DesignTextModel::TEXT_ALIGN_LEFT,
                "decoration"         => DesignTextModel::TEXT_DECORATION_NONE,
                "transform"          => DesignTextModel::TEXT_TRANSFORM_NONE,
                "letterSpacing"      => 0,
                "lineHeight"         => DesignTextModel::DEFAULT_LINE_HEIGHT,
                "sizeHover"          => DesignTextModel::MIN_SIZE_VALUE,
                "colorHover"         => "",
                "isItalicHover"      => false,
                "isBoldHover"        => false,
                "decorationHover"    => DesignTextModel::TEXT_DECORATION_NONE,
                "transformHover"     => DesignTextModel::TEXT_TRANSFORM_NONE,
                "letterSpacingHover" => 0,
                "lineHeightHover"    => DesignTextModel::DEFAULT_LINE_HEIGHT,
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
                "size"               => 20,
                "family"             => DesignTextModel::FAMILY_ARIAL,
                "color"              => "rgb(0,255,0)",
                "isItalic"           => 1,
                "isBold"             => 1,
                "align"              => DesignTextModel::TEXT_ALIGN_CENTER,
                "decoration"         => DesignTextModel::TEXT_DECORATION_UNDERLINE,
                "transform"          => DesignTextModel::TEXT_TRANSFORM_CAPITALIZE,
                "letterSpacing"      => 10,
                "lineHeight"         => 150,
                "sizeHover"          => 20,
                "colorHover"         => "rgb(0,255,0)",
                "isItalicHover"      => 1,
                "isBoldHover"        => 1,
                "decorationHover"    => DesignTextModel::TEXT_DECORATION_UNDERLINE,
                "transformHover"     => DesignTextModel::TEXT_TRANSFORM_CAPITALIZE,
                "letterSpacingHover" => 10,
                "lineHeightHover"    => 150,
            ],
            [
                "size"               => 20,
                "family"             => DesignTextModel::FAMILY_ARIAL,
                "color"              => "rgb(0,255,0)",
                "isItalic"           => true,
                "isBold"             => true,
                "align"              => DesignTextModel::TEXT_ALIGN_CENTER,
                "decoration"         => DesignTextModel::TEXT_DECORATION_UNDERLINE,
                "transform"          => DesignTextModel::TEXT_TRANSFORM_CAPITALIZE,
                "letterSpacing"      => 10,
                "lineHeight"         => 150,
                "sizeHover"          => 20,
                "colorHover"         => "rgb(0,255,0)",
                "isItalicHover"      => true,
                "isBoldHover"        => true,
                "decorationHover"    => DesignTextModel::TEXT_DECORATION_UNDERLINE,
                "transformHover"     => DesignTextModel::TEXT_TRANSFORM_CAPITALIZE,
                "letterSpacingHover" => 10,
                "lineHeightHover"    => 150,
            ],
            [
                "size"               => "30",
                "family"             => DesignTextModel::FAMILY_GEORGIA,
                "color"              => "rgba(20,255,40,0.5)",
                "isItalic"           => "0",
                "isBold"             => "0",
                "align"              => DesignTextModel::TEXT_ALIGN_RIGHT,
                "decoration"         => DesignTextModel::TEXT_DECORATION_LINE_THROUGH,
                "transform"          => DesignTextModel::TEXT_TRANSFORM_LOWERCASE,
                "letterSpacing"      => "20",
                "lineHeight"         => "100",
                "sizeHover"          => "30",
                "colorHover"         => "rgba(20,255,40,0.5)",
                "isItalicHover"      => "0",
                "isBoldHover"        => "0",
                "decorationHover"    => DesignTextModel::TEXT_DECORATION_LINE_THROUGH,
                "transformHover"     => DesignTextModel::TEXT_TRANSFORM_LOWERCASE,
                "letterSpacingHover" => "20",
                "lineHeightHover"    => "100",
            ],
            [
                "size"               => 30,
                "family"             => DesignTextModel::FAMILY_GEORGIA,
                "color"              => "rgba(20,255,40,0.5)",
                "isItalic"           => false,
                "isBold"             => false,
                "align"              => DesignTextModel::TEXT_ALIGN_RIGHT,
                "decoration"         => DesignTextModel::TEXT_DECORATION_LINE_THROUGH,
                "transform"          => DesignTextModel::TEXT_TRANSFORM_LOWERCASE,
                "letterSpacing"      => 20,
                "lineHeight"         => 100,
                "sizeHover"          => 30,
                "colorHover"         => "rgba(20,255,40,0.5)",
                "isItalicHover"      => false,
                "isBoldHover"        => false,
                "decorationHover"    => DesignTextModel::TEXT_DECORATION_LINE_THROUGH,
                "transformHover"     => DesignTextModel::TEXT_TRANSFORM_LOWERCASE,
                "letterSpacingHover" => 20,
                "lineHeightHover"    => 100,
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
                "size"               => "incorrect_type",
                "family"             => "incorrect_type",
                "color"              => "incorrect_type",
                "isItalic"           => "incorrect_type",
                "isBold"             => "incorrect_type",
                "align"              => "incorrect_type",
                "decoration"         => "incorrect_type",
                "transform"          => "incorrect_type",
                "letterSpacing"      => "incorrect_type",
                "lineHeight"         => "incorrect_type",
                "sizeHover"          => "incorrect_type",
                "colorHover"         => "incorrect_type",
                "isItalicHover"      => "incorrect_type",
                "isBoldHover"        => "incorrect_type",
                "decorationHover"    => "incorrect_type",
                "transformHover"     => "incorrect_type",
                "letterSpacingHover" => "incorrect_type",
                "lineHeightHover"    => "incorrect_type",
            ],
            [
                "size"               => DesignTextModel::MIN_SIZE_VALUE,
                "family"             => DesignTextModel::FAMILY_MYRAD,
                "color"              => "",
                "isItalic"           => true,
                "isBold"             => true,
                "align"              => DesignTextModel::TEXT_ALIGN_LEFT,
                "decoration"         => DesignTextModel::TEXT_DECORATION_NONE,
                "transform"          => DesignTextModel::TEXT_TRANSFORM_NONE,
                "letterSpacing"      => 0,
                "lineHeight"         => DesignTextModel::DEFAULT_LINE_HEIGHT,
                "sizeHover"          => DesignTextModel::MIN_SIZE_VALUE,
                "colorHover"         => "",
                "isItalicHover"      => true,
                "isBoldHover"        => true,
                "decorationHover"    => DesignTextModel::TEXT_DECORATION_NONE,
                "transformHover"     => DesignTextModel::TEXT_TRANSFORM_NONE,
                "letterSpacingHover" => 0,
                "lineHeightHover"    => DesignTextModel::DEFAULT_LINE_HEIGHT,
            ],
            [
                "size"               => "incorrect_type",
                "family"             => "incorrect_type",
                "color"              => "incorrect_type",
                "isItalic"           => "incorrect_type",
                "isBold"             => "incorrect_type",
                "align"              => "incorrect_type",
                "decoration"         => "incorrect_type",
                "transform"          => "incorrect_type",
                "letterSpacing"      => "incorrect_type",
                "lineHeight"         => "incorrect_type",
                "sizeHover"          => "incorrect_type",
                "colorHover"         => "incorrect_type",
                "isItalicHover"      => "incorrect_type",
                "isBoldHover"        => "incorrect_type",
                "decorationHover"    => "incorrect_type",
                "transformHover"     => "incorrect_type",
                "letterSpacingHover" => "incorrect_type",
                "lineHeightHover"    => "incorrect_type",
            ],
            [
                "size"               => DesignTextModel::MIN_SIZE_VALUE,
                "family"             => DesignTextModel::FAMILY_MYRAD,
                "color"              => "",
                "isItalic"           => true,
                "isBold"             => true,
                "align"              => DesignTextModel::TEXT_ALIGN_LEFT,
                "decoration"         => DesignTextModel::TEXT_DECORATION_NONE,
                "transform"          => DesignTextModel::TEXT_TRANSFORM_NONE,
                "letterSpacing"      => 0,
                "lineHeight"         => DesignTextModel::DEFAULT_LINE_HEIGHT,
                "sizeHover"          => DesignTextModel::MIN_SIZE_VALUE,
                "colorHover"         => "",
                "isItalicHover"      => true,
                "isBoldHover"        => true,
                "decorationHover"    => DesignTextModel::TEXT_DECORATION_NONE,
                "transformHover"     => DesignTextModel::TEXT_TRANSFORM_NONE,
                "letterSpacingHover" => 0,
                "lineHeightHover"    => DesignTextModel::DEFAULT_LINE_HEIGHT,
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
                "size"               => DesignTextModel::MIN_SIZE_VALUE - 1,
                "family"             => 999,
                "color"              => "0,255,0",
                "isItalic"           => 8,
                "isBold"             => 6,
                "align"              => 67,
                "decoration"         => 74,
                "transform"          => 37,
                "letterSpacing"      => DesignTextModel::MIN_LETTER_SPACING_VALUE - 1,
                "lineHeight"         => DesignTextModel::MIN_LINE_HEIGHT_VALUE - 1,
                "sizeHover"          => DesignTextModel::MIN_SIZE_VALUE - 1,
                "colorHover"         => "0,255,0",
                "isItalicHover"      => 8,
                "isBoldHover"        => 6,
                "decorationHover"    => 74,
                "transformHover"     => 37,
                "letterSpacingHover" => DesignTextModel::MIN_LETTER_SPACING_VALUE - 1,
                "lineHeightHover"    => DesignTextModel::MIN_LINE_HEIGHT_VALUE - 1,
            ],
            [
                "size"               => DesignTextModel::MIN_SIZE_VALUE,
                "family"             => DesignTextModel::FAMILY_MYRAD,
                "color"              => "",
                "isItalic"           => true,
                "isBold"             => true,
                "align"              => DesignTextModel::TEXT_ALIGN_LEFT,
                "decoration"         => DesignTextModel::TEXT_DECORATION_NONE,
                "transform"          => DesignTextModel::TEXT_TRANSFORM_NONE,
                "letterSpacing"      => DesignTextModel::MIN_LETTER_SPACING_VALUE,
                "lineHeight"         => DesignTextModel::DEFAULT_LINE_HEIGHT,
                "sizeHover"          => DesignTextModel::MIN_SIZE_VALUE,
                "colorHover"         => "",
                "isItalicHover"      => true,
                "isBoldHover"        => true,
                "decorationHover"    => DesignTextModel::TEXT_DECORATION_NONE,
                "transformHover"     => DesignTextModel::TEXT_TRANSFORM_NONE,
                "letterSpacingHover" => DesignTextModel::MIN_LETTER_SPACING_VALUE,
                "lineHeightHover"    => DesignTextModel::DEFAULT_LINE_HEIGHT,
            ],
            [
                "size"               => DesignTextModel::MIN_SIZE_VALUE - 100,
                "family"             => -12,
                "color"              => "#cccccc",
                "isItalic"           => -3,
                "isBold"             => -1,
                "align"              => -10,
                "decoration"         => -5,
                "transform"          => -12,
                "letterSpacing"      => DesignTextModel::MIN_LETTER_SPACING_VALUE - 1,
                "lineHeight"         => DesignTextModel::MIN_LINE_HEIGHT_VALUE - 1,
                "sizeHover"          => DesignTextModel::MIN_SIZE_VALUE - 100,
                "colorHover"         => "#cccccc",
                "isItalicHover"      => -3,
                "isBoldHover"        => -1,
                "decorationHover"    => -5,
                "transformHover"     => -12,
                "letterSpacingHover" => DesignTextModel::MIN_LETTER_SPACING_VALUE - 1,
                "lineHeightHover"    => DesignTextModel::MIN_LINE_HEIGHT_VALUE - 1,
            ],
            [
                "size"               => DesignTextModel::MIN_SIZE_VALUE,
                "family"             => DesignTextModel::FAMILY_MYRAD,
                "color"              => "",
                "isItalic"           => true,
                "isBold"             => true,
                "align"              => DesignTextModel::TEXT_ALIGN_LEFT,
                "decoration"         => DesignTextModel::TEXT_DECORATION_NONE,
                "transform"          => DesignTextModel::TEXT_TRANSFORM_NONE,
                "letterSpacing"      => DesignTextModel::MIN_LETTER_SPACING_VALUE,
                "lineHeight"         => DesignTextModel::DEFAULT_LINE_HEIGHT,
                "sizeHover"          => DesignTextModel::MIN_SIZE_VALUE,
                "colorHover"         => "",
                "isItalicHover"      => true,
                "isBoldHover"        => true,
                "decorationHover"    => DesignTextModel::TEXT_DECORATION_NONE,
                "transformHover"     => DesignTextModel::TEXT_TRANSFORM_NONE,
                "letterSpacingHover" => DesignTextModel::MIN_LETTER_SPACING_VALUE,
                "lineHeightHover"    => DesignTextModel::DEFAULT_LINE_HEIGHT,
            ]
        ];
    }
}