<?php

namespace testS\tests\unit\models;

use testS\models\DesignBlockModel;

/**
 * Tests for model DesignTextModel
 *
 * @package testS\tests\unit\models
 */
class DesignBlockModelTest extends AbstractModelTest
{

    /**
     * Model object
     *
     * @return DesignBlockModel
     */
    protected function getModel()
    {
        return new DesignBlockModel;
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
     * Insert: null data.
     * Update: null data
     *
     * @return array
     */
    private function _dataProviderForCRUDNull()
    {
        return [
            [],
            [
                "marginTop"               => 0,
                "marginRight"             => 0,
                "marginBottom"            => 0,
                "marginLeft"              => 0,
                "paddingTop"              => 0,
                "paddingRight"            => 0,
                "paddingBottom"           => 0,
                "paddingLeft"             => 0,
                "backgroundColorFrom"     => "",
                "backgroundColorTo"       => "",
                "gradientDirection"       => 0,
                "borderTopWidth"          => 0,
                "borderTopLeftRadius"     => 0,
                "borderRightWidth"        => 0,
                "borderTopRightRadius"    => 0,
                "borderBottomWidth"       => 0,
                "borderBottomRightRadius" => 0,
                "borderLeftWidth"         => 0,
                "borderBottomLeftRadius"  => 0,
                "borderColor"             => "",
                "borderStyle"             => 0,
            ],
            [],
            [
                "marginTop"               => 0,
                "marginRight"             => 0,
                "marginBottom"            => 0,
                "marginLeft"              => 0,
                "paddingTop"              => 0,
                "paddingRight"            => 0,
                "paddingBottom"           => 0,
                "paddingLeft"             => 0,
                "backgroundColorFrom"     => "",
                "backgroundColorTo"       => "",
                "gradientDirection"       => 0,
                "borderTopWidth"          => 0,
                "borderTopLeftRadius"     => 0,
                "borderRightWidth"        => 0,
                "borderTopRightRadius"    => 0,
                "borderBottomWidth"       => 0,
                "borderBottomRightRadius" => 0,
                "borderLeftWidth"         => 0,
                "borderBottomLeftRadius"  => 0,
                "borderColor"             => "",
                "borderStyle"             => 0,
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
                "marginTop"               => "",
                "marginRight"             => "",
                "marginBottom"            => "",
                "marginLeft"              => "",
                "paddingTop"              => "",
                "paddingRight"            => "",
                "paddingBottom"           => "",
                "paddingLeft"             => "",
                "backgroundColorFrom"     => "",
                "backgroundColorTo"       => "",
                "gradientDirection"       => "",
                "borderTopWidth"          => "",
                "borderTopLeftRadius"     => "",
                "borderRightWidth"        => "",
                "borderTopRightRadius"    => "",
                "borderBottomWidth"       => "",
                "borderBottomRightRadius" => "",
                "borderLeftWidth"         => "",
                "borderBottomLeftRadius"  => "",
                "borderColor"             => "",
                "borderStyle"             => "",
            ],
            [
                "marginTop"               => 0,
                "marginRight"             => 0,
                "marginBottom"            => 0,
                "marginLeft"              => 0,
                "paddingTop"              => 0,
                "paddingRight"            => 0,
                "paddingBottom"           => 0,
                "paddingLeft"             => 0,
                "backgroundColorFrom"     => "",
                "backgroundColorTo"       => "",
                "gradientDirection"       => 0,
                "borderTopWidth"          => 0,
                "borderTopLeftRadius"     => 0,
                "borderRightWidth"        => 0,
                "borderTopRightRadius"    => 0,
                "borderBottomWidth"       => 0,
                "borderBottomRightRadius" => 0,
                "borderLeftWidth"         => 0,
                "borderBottomLeftRadius"  => 0,
                "borderColor"             => "",
                "borderStyle"             => 0,
            ],
            [
                "marginTop"               => "",
                "marginRight"             => "",
                "marginBottom"            => "",
                "marginLeft"              => "",
                "paddingTop"              => "",
                "paddingRight"            => "",
                "paddingBottom"           => "",
                "paddingLeft"             => "",
                "backgroundColorFrom"     => "",
                "backgroundColorTo"       => "",
                "gradientDirection"       => "",
                "borderTopWidth"          => "",
                "borderTopLeftRadius"     => "",
                "borderRightWidth"        => "",
                "borderTopRightRadius"    => "",
                "borderBottomWidth"       => "",
                "borderBottomRightRadius" => "",
                "borderLeftWidth"         => "",
                "borderBottomLeftRadius"  => "",
                "borderColor"             => "",
                "borderStyle"             => "",
            ],
            [
                "marginTop"               => 0,
                "marginRight"             => 0,
                "marginBottom"            => 0,
                "marginLeft"              => 0,
                "paddingTop"              => 0,
                "paddingRight"            => 0,
                "paddingBottom"           => 0,
                "paddingLeft"             => 0,
                "backgroundColorFrom"     => "",
                "backgroundColorTo"       => "",
                "gradientDirection"       => 0,
                "borderTopWidth"          => 0,
                "borderTopLeftRadius"     => 0,
                "borderRightWidth"        => 0,
                "borderTopRightRadius"    => 0,
                "borderBottomWidth"       => 0,
                "borderBottomRightRadius" => 0,
                "borderLeftWidth"         => 0,
                "borderBottomLeftRadius"  => 0,
                "borderColor"             => "",
                "borderStyle"             => 0,
            ]
        ];
    }

    /**
     * Insert: correct values.
     * Update: correct values
     *
     * @return array
     */
    private function _dataProviderForCRUDCorrect()
    {
        return [
            [
                "marginTop"               => 10,
                "marginRight"             => 20,
                "marginBottom"            => 30,
                "marginLeft"              => 40,
                "paddingTop"              => 15,
                "paddingRight"            => 25,
                "paddingBottom"           => 35,
                "paddingLeft"             => 45,
                "backgroundColorFrom"     => "rgba(255,255,255,0.5)",
                "backgroundColorTo"       => "rgb(0,0,0)",
                "gradientDirection"       => DesignBlockModel::GRADIENT_DIRECTION_HORIZONTAL,
                "borderTopWidth"          => 1,
                "borderTopLeftRadius"     => 5,
                "borderRightWidth"        => 2,
                "borderTopRightRadius"    => 10,
                "borderBottomWidth"       => 3,
                "borderBottomRightRadius" => 15,
                "borderLeftWidth"         => 4,
                "borderBottomLeftRadius"  => 20,
                "borderColor"             => "rgba(0,255,255,0.5)",
                "borderStyle"             => DesignBlockModel::BORDER_STYLE_SOLID,
            ],
            [
                "marginTop"               => 10,
                "marginRight"             => 20,
                "marginBottom"            => 30,
                "marginLeft"              => 40,
                "paddingTop"              => 15,
                "paddingRight"            => 25,
                "paddingBottom"           => 35,
                "paddingLeft"             => 45,
                "backgroundColorFrom"     => "rgba(255,255,255,0.5)",
                "backgroundColorTo"       => "rgb(0,0,0)",
                "gradientDirection"       => DesignBlockModel::GRADIENT_DIRECTION_HORIZONTAL,
                "borderTopWidth"          => 1,
                "borderTopLeftRadius"     => 5,
                "borderRightWidth"        => 2,
                "borderTopRightRadius"    => 10,
                "borderBottomWidth"       => 3,
                "borderBottomRightRadius" => 15,
                "borderLeftWidth"         => 4,
                "borderBottomLeftRadius"  => 20,
                "borderColor"             => "rgba(0,255,255,0.5)",
                "borderStyle"             => DesignBlockModel::BORDER_STYLE_SOLID,
            ],
            [
                "marginTop"               => "5",
                "marginRight"             => "6",
                "marginBottom"            => "7",
                "marginLeft"              => "8",
                "paddingTop"              => "9",
                "paddingRight"            => "10",
                "paddingBottom"           => "11",
                "paddingLeft"             => "12",
                "backgroundColorFrom"     => "rgba(255,0,255,0.5)",
                "backgroundColorTo"       => "rgba(255,255,0,0.5)",
                "gradientDirection"       => DesignBlockModel::GRADIENT_DIRECTION_VERTICAL,
                "borderTopWidth"          => "3",
                "borderTopLeftRadius"     => "4",
                "borderRightWidth"        => "5",
                "borderTopRightRadius"    => "6",
                "borderBottomWidth"       => "7",
                "borderBottomRightRadius" => "8",
                "borderLeftWidth"         => "9",
                "borderBottomLeftRadius"  => "10",
                "borderColor"             => "rgb(0,255,0)",
                "borderStyle"             => DesignBlockModel::BORDER_STYLE_DOTTED,
            ],
            [
                "marginTop"               => 5,
                "marginRight"             => 6,
                "marginBottom"            => 7,
                "marginLeft"              => 8,
                "paddingTop"              => 9,
                "paddingRight"            => 10,
                "paddingBottom"           => 11,
                "paddingLeft"             => 12,
                "backgroundColorFrom"     => "rgba(255,0,255,0.5)",
                "backgroundColorTo"       => "rgba(255,255,0,0.5)",
                "gradientDirection"       => DesignBlockModel::GRADIENT_DIRECTION_VERTICAL,
                "borderTopWidth"          => 3,
                "borderTopLeftRadius"     => 4,
                "borderRightWidth"        => 5,
                "borderTopRightRadius"    => 6,
                "borderBottomWidth"       => 7,
                "borderBottomRightRadius" => 8,
                "borderLeftWidth"         => 9,
                "borderBottomLeftRadius"  => 10,
                "borderColor"             => "rgb(0,255,0)",
                "borderStyle"             => DesignBlockModel::BORDER_STYLE_DOTTED,
            ]
        ];
    }

    /**
     * Insert: values with incorrect type
     * Update: values with incorrect type
     *
     * @return array
     */
    private function _dataProviderForCRUDIncorrectType()
    {
        return [
            [
                "marginTop"               => "incorrect type",
                "marginRight"             => "incorrect type",
                "marginBottom"            => "incorrect type",
                "marginLeft"              => "incorrect type",
                "paddingTop"              => "incorrect type",
                "paddingRight"            => "incorrect type",
                "paddingBottom"           => "incorrect type",
                "paddingLeft"             => "incorrect type",
                "backgroundColorFrom"     => "incorrect type",
                "backgroundColorTo"       => "incorrect type",
                "gradientDirection"       => "incorrect type",
                "borderTopWidth"          => "incorrect type",
                "borderTopLeftRadius"     => "incorrect type",
                "borderRightWidth"        => "incorrect type",
                "borderTopRightRadius"    => "incorrect type",
                "borderBottomWidth"       => "incorrect type",
                "borderBottomRightRadius" => "incorrect type",
                "borderLeftWidth"         => "incorrect type",
                "borderBottomLeftRadius"  => "incorrect type",
                "borderColor"             => "0,255,255,0.5",
                "borderStyle"             => "incorrect type",
            ],
            [
                "marginTop"               => 0,
                "marginRight"             => 0,
                "marginBottom"            => 0,
                "marginLeft"              => 0,
                "paddingTop"              => 0,
                "paddingRight"            => 0,
                "paddingBottom"           => 0,
                "paddingLeft"             => 0,
                "backgroundColorFrom"     => "",
                "backgroundColorTo"       => "",
                "gradientDirection"       => 0,
                "borderTopWidth"          => 0,
                "borderTopLeftRadius"     => 0,
                "borderRightWidth"        => 0,
                "borderTopRightRadius"    => 0,
                "borderBottomWidth"       => 0,
                "borderBottomRightRadius" => 0,
                "borderLeftWidth"         => 0,
                "borderBottomLeftRadius"  => 0,
                "borderColor"             => "",
                "borderStyle"             => 0,
            ],
            [
                "marginTop"               => "incorrect type",
                "marginRight"             => "incorrect type",
                "marginBottom"            => "incorrect type",
                "marginLeft"              => "incorrect type",
                "paddingTop"              => "incorrect type",
                "paddingRight"            => "incorrect type",
                "paddingBottom"           => "incorrect type",
                "paddingLeft"             => "incorrect type",
                "backgroundColorFrom"     => "incorrect type",
                "backgroundColorTo"       => "incorrect type",
                "gradientDirection"       => "incorrect type",
                "borderTopWidth"          => "incorrect type",
                "borderTopLeftRadius"     => "incorrect type",
                "borderRightWidth"        => "incorrect type",
                "borderTopRightRadius"    => "incorrect type",
                "borderBottomWidth"       => "incorrect type",
                "borderBottomRightRadius" => "incorrect type",
                "borderLeftWidth"         => "incorrect type",
                "borderBottomLeftRadius"  => "incorrect type",
                "borderColor"             => "#cccccc",
                "borderStyle"             => "incorrect type",
            ],
            [
                "marginTop"               => 0,
                "marginRight"             => 0,
                "marginBottom"            => 0,
                "marginLeft"              => 0,
                "paddingTop"              => 0,
                "paddingRight"            => 0,
                "paddingBottom"           => 0,
                "paddingLeft"             => 0,
                "backgroundColorFrom"     => "",
                "backgroundColorTo"       => "",
                "gradientDirection"       => 0,
                "borderTopWidth"          => 0,
                "borderTopLeftRadius"     => 0,
                "borderRightWidth"        => 0,
                "borderTopRightRadius"    => 0,
                "borderBottomWidth"       => 0,
                "borderBottomRightRadius" => 0,
                "borderLeftWidth"         => 0,
                "borderBottomLeftRadius"  => 0,
                "borderColor"             => "",
                "borderStyle"             => 0,
            ]
        ];
    }

    /**
     * Insert: values with incorrect values
     * Update: values with incorrect values
     *
     * @return array
     */
    private function _dataProviderForCRUDIncorrectValue()
    {
        return [
            [
                "marginTop"               => DesignBlockModel::MIN_MARGIN_VALUE - 1,
                "marginRight"             => DesignBlockModel::MIN_MARGIN_VALUE - 1,
                "marginBottom"            => DesignBlockModel::MIN_MARGIN_VALUE - 1,
                "marginLeft"              => DesignBlockModel::MIN_MARGIN_VALUE - 1,
                "paddingTop"              => - 1,
                "paddingRight"            => - 1,
                "paddingBottom"           => - 1,
                "paddingLeft"             => - 1,
                "backgroundColorFrom"     => "#ccc",
                "backgroundColorTo"       => "#cccccc",
                "gradientDirection"       => 99,
                "borderTopWidth"          => - 1,
                "borderTopLeftRadius"     => - 1,
                "borderRightWidth"        => - 1,
                "borderTopRightRadius"    => - 1,
                "borderBottomWidth"       => - 1,
                "borderBottomRightRadius" => - 1,
                "borderLeftWidth"         => - 1,
                "borderBottomLeftRadius"  => - 1,
                "borderColor"             => "0,255,255",
                "borderStyle"             => 99,
            ],
            [
                "marginTop"               => DesignBlockModel::MIN_MARGIN_VALUE,
                "marginRight"             => DesignBlockModel::MIN_MARGIN_VALUE,
                "marginBottom"            => DesignBlockModel::MIN_MARGIN_VALUE,
                "marginLeft"              => DesignBlockModel::MIN_MARGIN_VALUE,
                "paddingTop"              => 0,
                "paddingRight"            => 0,
                "paddingBottom"           => 0,
                "paddingLeft"             => 0,
                "backgroundColorFrom"     => "",
                "backgroundColorTo"       => "",
                "gradientDirection"       => DesignBlockModel::GRADIENT_DIRECTION_HORIZONTAL,
                "borderTopWidth"          => 0,
                "borderTopLeftRadius"     => 0,
                "borderRightWidth"        => 0,
                "borderTopRightRadius"    => 0,
                "borderBottomWidth"       => 0,
                "borderBottomRightRadius" => 0,
                "borderLeftWidth"         => 0,
                "borderBottomLeftRadius"  => 0,
                "borderColor"             => "",
                "borderStyle"             => DesignBlockModel::BORDER_STYLE_NONE,
            ],
            [
                "marginTop"               => DesignBlockModel::MIN_MARGIN_VALUE - 1,
                "marginRight"             => DesignBlockModel::MIN_MARGIN_VALUE - 1,
                "marginBottom"            => DesignBlockModel::MIN_MARGIN_VALUE - 1,
                "marginLeft"              => DesignBlockModel::MIN_MARGIN_VALUE - 1,
                "paddingTop"              => - 1,
                "paddingRight"            => - 1,
                "paddingBottom"           => - 1,
                "paddingLeft"             => - 1,
                "backgroundColorFrom"     => "0,255,255",
                "backgroundColorTo"       => "0,0,255",
                "gradientDirection"       => 111,
                "borderTopWidth"          => -1,
                "borderTopLeftRadius"     => -1,
                "borderRightWidth"        => -1,
                "borderTopRightRadius"    => -1,
                "borderBottomWidth"       => -1,
                "borderBottomRightRadius" => -1,
                "borderLeftWidth"         => -1,
                "borderBottomLeftRadius"  => -1,
                "borderColor"             => "#cccccc",
                "borderStyle"             => 111,
            ],
            [
                "marginTop"               => DesignBlockModel::MIN_MARGIN_VALUE,
                "marginRight"             => DesignBlockModel::MIN_MARGIN_VALUE,
                "marginBottom"            => DesignBlockModel::MIN_MARGIN_VALUE,
                "marginLeft"              => DesignBlockModel::MIN_MARGIN_VALUE,
                "paddingTop"              => 0,
                "paddingRight"            => 0,
                "paddingBottom"           => 0,
                "paddingLeft"             => 0,
                "backgroundColorFrom"     => "",
                "backgroundColorTo"       => "",
                "gradientDirection"       => DesignBlockModel::GRADIENT_DIRECTION_HORIZONTAL,
                "borderTopWidth"          => 0,
                "borderTopLeftRadius"     => 0,
                "borderRightWidth"        => 0,
                "borderTopRightRadius"    => 0,
                "borderBottomWidth"       => 0,
                "borderBottomRightRadius" => 0,
                "borderLeftWidth"         => 0,
                "borderBottomLeftRadius"  => 0,
                "borderColor"             => "",
                "borderStyle"             => DesignBlockModel::BORDER_STYLE_NONE,
            ]
        ];
    }
}