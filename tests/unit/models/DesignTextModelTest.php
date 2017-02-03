<?php

namespace testS\tests\unit\models;

use testS\models\DesignTextModel;

/**
 * Tests for the model DesignTextModel
 *
 * @package testS\tests\unit\models
 */
class DesignTextModelTest extends AbstractModelTest
{

    /**
     * Gets model name
     *
     * @return string
     */
    protected function getNewModel()
    {
        return new DesignTextModel();
    }

    /**
     * Data provider for CRUD. Empty values
     *
     * @return array
     */
    protected function getDataProviderCRUDEmpty()
    {
        return [
            "empty1" => [
                [],
                [
                    "size"               => 0,
                    "family"             => 0,
                    "color"              => "",
                    "isItalic"           => false,
                    "isBold"             => false,
                    "align"              => 0,
                    "decoration"         => 0,
                    "transform"          => 0,
                    "letterSpacing"      => 0,
                    "lineHeight"         => 0,
                    "sizeHover"          => 0,
                    "colorHover"         => "",
                    "isItalicHover"      => false,
                    "isBoldHover"        => false,
                    "decorationHover"    => 0,
                    "transformHover"     => 0,
                    "letterSpacingHover" => 0,
                    "lineHeightHover"    => 0,
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
                    "size"               => 0,
                    "family"             => 0,
                    "color"              => "",
                    "isItalic"           => false,
                    "isBold"             => false,
                    "align"              => 0,
                    "decoration"         => 0,
                    "transform"          => 0,
                    "letterSpacing"      => 0,
                    "lineHeight"         => 0,
                    "sizeHover"          => 0,
                    "colorHover"         => "",
                    "isItalicHover"      => false,
                    "isBoldHover"        => false,
                    "decorationHover"    => 0,
                    "transformHover"     => 0,
                    "letterSpacingHover" => 0,
                    "lineHeightHover"    => 0,
                ],
            ],
            "empty2" => [
                [
                    "size"               => null,
                    "family"             => null,
                    "color"              => null,
                    "isItalic"           => null,
                    "isBold"             => null,
                    "align"              => null,
                    "decoration"         => null,
                    "transform"          => null,
                    "letterSpacing"      => null,
                    "lineHeight"         => null,
                    "sizeHover"          => null,
                    "colorHover"         => null,
                    "isItalicHover"      => null,
                    "isBoldHover"        => null,
                    "decorationHover"    => null,
                    "transformHover"     => null,
                    "letterSpacingHover" => null,
                    "lineHeightHover"    => null,
                ],
                [
                    "size"               => 0,
                    "family"             => 0,
                    "color"              => "",
                    "isItalic"           => false,
                    "isBold"             => false,
                    "align"              => 0,
                    "decoration"         => 0,
                    "transform"          => 0,
                    "letterSpacing"      => 0,
                    "lineHeight"         => 0,
                    "sizeHover"          => 0,
                    "colorHover"         => "",
                    "isItalicHover"      => false,
                    "isBoldHover"        => false,
                    "decorationHover"    => 0,
                    "transformHover"     => 0,
                    "letterSpacingHover" => 0,
                    "lineHeightHover"    => 0,
                ],
                [
                    "size"               => "  ",
                    "family"             => "  ",
                    "color"              => " ",
                    "isItalic"           => " ",
                    "isBold"             => " ",
                    "align"              => "  ",
                    "decoration"         => "  ",
                    "transform"          => "  ",
                    "letterSpacing"      => "  ",
                    "lineHeight"         => "  ",
                    "sizeHover"          => "  ",
                    "colorHover"         => "  ",
                    "isItalicHover"      => "   ",
                    "isBoldHover"        => "   ",
                    "decorationHover"    => "  ",
                    "transformHover"     => " ",
                    "letterSpacingHover" => "  ",
                    "lineHeightHover"    => "   ",
                ],
                [
                    "size"               => 0,
                    "family"             => 0,
                    "color"              => "",
                    "isItalic"           => false,
                    "isBold"             => false,
                    "align"              => 0,
                    "decoration"         => 0,
                    "transform"          => 0,
                    "letterSpacing"      => 0,
                    "lineHeight"         => 0,
                    "sizeHover"          => 0,
                    "colorHover"         => "",
                    "isItalicHover"      => false,
                    "isBoldHover"        => false,
                    "decorationHover"    => 0,
                    "transformHover"     => 0,
                    "letterSpacingHover" => 0,
                    "lineHeightHover"    => 0,
                ],
            ]
        ];
    }

    /**
     * Data provider for CRUD. Correct values
     *
     * @return array
     */
    protected function getDataProviderCRUDCorrect()
    {
        return [
            "correct1" => [
                [
                    "size"               => 20,
                    "family"             => 1,
                    "color"              => "rgb(0,255,0)",
                    "isItalic"           => true,
                    "isBold"             => true,
                    "align"              => 1,
                    "decoration"         => 1,
                    "transform"          => 3,
                    "letterSpacing"      => 10,
                    "lineHeight"         => 150,
                    "sizeHover"          => 20,
                    "colorHover"         => "rgb(0,255,0)",
                    "isItalicHover"      => true,
                    "isBoldHover"        => true,
                    "decorationHover"    => 1,
                    "transformHover"     => 3,
                    "letterSpacingHover" => 10,
                    "lineHeightHover"    => 150,
                ],
                [
                    "size"               => 20,
                    "family"             => 1,
                    "color"              => "rgb(0,255,0)",
                    "isItalic"           => true,
                    "isBold"             => true,
                    "align"              => 1,
                    "decoration"         => 1,
                    "transform"          => 3,
                    "letterSpacing"      => 10,
                    "lineHeight"         => 150,
                    "sizeHover"          => 20,
                    "colorHover"         => "rgb(0,255,0)",
                    "isItalicHover"      => true,
                    "isBoldHover"        => true,
                    "decorationHover"    => 1,
                    "transformHover"     => 3,
                    "letterSpacingHover" => 10,
                    "lineHeightHover"    => 150,
                ],
                [
                    "size"               => 30,
                    "family"             => 5,
                    "color"              => "rgba(20,255,40,0.5)",
                    "isItalic"           => false,
                    "isBold"             => false,
                    "align"              => 2,
                    "decoration"         => 2,
                    "transform"          => 2,
                ],
                [
                    "size"               => 30,
                    "family"             => 5,
                    "color"              => "rgba(20,255,40,0.5)",
                    "isItalic"           => false,
                    "isBold"             => false,
                    "align"              => 2,
                    "decoration"         => 2,
                    "transform"          => 2,
                    "letterSpacing"      => 10,
                    "lineHeight"         => 150,
                    "sizeHover"          => 20,
                    "colorHover"         => "rgb(0,255,0)",
                    "isItalicHover"      => true,
                    "isBoldHover"        => true,
                    "decorationHover"    => 1,
                    "transformHover"     => 3,
                    "letterSpacingHover" => 10,
                    "lineHeightHover"    => 150,
                ],
            ]
        ];
    }

    /**
     * Data provider for CRUD. Incorrect values
     *
     * @return array
     */
    protected function getDataProviderCRUDIncorrect()
    {
        return [];
    }

    /**
     * Data provider for CRUD. Duplicate
     *
     * @return array
     */
    public function getDataProviderDuplicate()
    {
        $this->markTestSkipped();
        return [];
    }
}