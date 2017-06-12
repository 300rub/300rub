<?php

namespace testS\tests\unit\models;

use testS\models\TabModel;

/**
 * Tests for the model TabModel
 *
 * @package testS\tests\unit\models
 */
class TabModelTest extends AbstractModelTest
{

    /**
     * Gets model name
     *
     * @return TabModel
     */
    protected function getNewModel()
    {
        return new TabModel();
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
                    "designTabsModel" => [
                        "containerDesignBlockModel" => [
                            "marginTop" => 0
                        ],
                        "tabDesignBlockModel"       => [
                            "marginTop" => 0
                        ],
                        "tabDesignTextModel"        => [
                            "size" => 0
                        ],
                        "contentDesignBlockModel"   => [
                            "marginTop" => 0
                        ],
                    ],
                    "textModel"       => [
                        "designTextModel"  => [
                            "size" => 0
                        ],
                        "designBlockModel" => [
                            "marginTop" => 0
                        ],
                        "type"             => 0,
                        "hasEditor"        => false,
                    ],
                    "isShowEmpty"     => false,
                    "isLazyLoad"      => false,
                ],
                [
                    "designTabsModel" => [
                        "containerDesignBlockModel" => "",
                        "tabDesignBlockModel"       => "",
                        "tabDesignTextModel"        => "",
                        "contentDesignBlockModel"   => "",
                    ],
                    "textModel"       => [
                        "designTextModel"  => "",
                        "designBlockModel" => "",
                        "type"             => "",
                        "hasEditor"        => "",
                    ],
                ],
                [
                    "designTabsModel" => [
                        "containerDesignBlockModel" => [
                            "marginTop" => 0
                        ],
                        "tabDesignBlockModel"       => [
                            "marginTop" => 0
                        ],
                        "tabDesignTextModel"        => [
                            "size" => 0
                        ],
                        "contentDesignBlockModel"   => [
                            "marginTop" => 0
                        ],
                    ],
                    "textModel"       => [
                        "designTextModel"  => [
                            "size" => 0
                        ],
                        "designBlockModel" => [
                            "marginTop" => 0
                        ],
                        "type"             => 0,
                        "hasEditor"        => false,
                    ],
                    "isShowEmpty"     => false,
                    "isLazyLoad"      => false,
                ],
            ],
            "empty2" => [
                [
                    "designTabsModel" => "",
                    "textModel"       => "",
                    "isShowEmpty"     => "",
                    "isLazyLoad"      => "",
                ],
                [
                    "designTabsModel" => [
                        "containerDesignBlockModel" => [
                            "marginTop" => 0
                        ],
                        "tabDesignBlockModel"       => [
                            "marginTop" => 0
                        ],
                        "tabDesignTextModel"        => [
                            "size" => 0
                        ],
                        "contentDesignBlockModel"   => [
                            "marginTop" => 0
                        ],
                    ],
                    "textModel"       => [
                        "designTextModel"  => [
                            "size" => 0
                        ],
                        "designBlockModel" => [
                            "marginTop" => 0
                        ],
                        "type"             => 0,
                        "hasEditor"        => false,
                    ],
                    "isShowEmpty"     => false,
                    "isLazyLoad"      => false,
                ]
            ],
            "empty3" => [
                [
                    "designTabsModel" => null,
                    "textModel"       => null,
                    "isShowEmpty"     => null,
                    "isLazyLoad"      => null,
                ],
                [
                    "designTabsModel" => [
                        "containerDesignBlockModel" => [
                            "marginTop" => 0
                        ],
                        "tabDesignBlockModel"       => [
                            "marginTop" => 0
                        ],
                        "tabDesignTextModel"        => [
                            "size" => 0
                        ],
                        "contentDesignBlockModel"   => [
                            "marginTop" => 0
                        ],
                    ],
                    "textModel"       => [
                        "designTextModel"  => [
                            "size" => 0
                        ],
                        "designBlockModel" => [
                            "marginTop" => 0
                        ],
                        "type"             => 0,
                        "hasEditor"        => false,
                    ],
                    "isShowEmpty"     => false,
                    "isLazyLoad"      => false,
                ],
                [
                    "designTabsModel" => [
                        "containerDesignBlockModel" => null,
                        "tabDesignBlockModel"       => null,
                        "tabDesignTextModel"        => null,
                        "contentDesignBlockModel"   => null,
                    ],
                    "textModel"       => [
                        "designTextModel"  => null,
                        "designBlockModel" => null,
                        "type"             => null,
                        "hasEditor"        => null,
                    ],
                    "isShowEmpty"     => null,
                    "isLazyLoad"      => null,
                ],
                [
                    "designTabsModel" => [
                        "containerDesignBlockModel" => [
                            "marginTop" => 0
                        ],
                        "tabDesignBlockModel"       => [
                            "marginTop" => 0
                        ],
                        "tabDesignTextModel"        => [
                            "size" => 0
                        ],
                        "contentDesignBlockModel"   => [
                            "marginTop" => 0
                        ],
                    ],
                    "textModel"       => [
                        "designTextModel"  => [
                            "size" => 0
                        ],
                        "designBlockModel" => [
                            "marginTop" => 0
                        ],
                        "type"             => 0,
                        "hasEditor"        => false,
                    ],
                    "isShowEmpty"     => false,
                    "isLazyLoad"      => false,
                ],
            ],
            "empty4" => [
                [
                    "designTabsModel" => [
                        "containerDesignBlockModel" => [
                            "marginTop" => " "
                        ],
                        "tabDesignBlockModel"       => [
                            "marginTop" => " "
                        ],
                        "tabDesignTextModel"        => [
                            "size" => " "
                        ],
                        "contentDesignBlockModel"   => [
                            "marginTop" => " "
                        ],
                    ],
                    "textModel"       => [
                        "designTextModel"  => [
                            "size" => " "
                        ],
                        "designBlockModel" => [
                            "marginTop" => " "
                        ],
                        "type"             => " ",
                        "hasEditor"        => " ",
                    ],
                ],
                [
                    "designTabsModel" => [
                        "containerDesignBlockModel" => [
                            "marginTop" => 0
                        ],
                        "tabDesignBlockModel"       => [
                            "marginTop" => 0
                        ],
                        "tabDesignTextModel"        => [
                            "size" => 0
                        ],
                        "contentDesignBlockModel"   => [
                            "marginTop" => 0
                        ],
                    ],
                    "textModel"       => [
                        "designTextModel"  => [
                            "size" => 0
                        ],
                        "designBlockModel" => [
                            "marginTop" => 0
                        ],
                        "type"             => 0,
                        "hasEditor"        => false,
                    ],
                    "isShowEmpty"     => false,
                    "isLazyLoad"      => false,
                ],
                [
                    "designTabsId" => " ",
                    "textId"       => " "
                ],
                [
                    "designTabsModel" => [
                        "containerDesignBlockModel" => [
                            "marginTop" => 0
                        ],
                        "tabDesignBlockModel"       => [
                            "marginTop" => 0
                        ],
                        "tabDesignTextModel"        => [
                            "size" => 0
                        ],
                        "contentDesignBlockModel"   => [
                            "marginTop" => 0
                        ],
                    ],
                    "textModel"       => [
                        "designTextModel"  => [
                            "size" => 0
                        ],
                        "designBlockModel" => [
                            "marginTop" => 0
                        ],
                        "type"             => 0,
                        "hasEditor"        => false,
                    ],
                    "isShowEmpty"     => false,
                    "isLazyLoad"      => false,
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
                    "designTabsModel" => [
                        "containerDesignBlockModel" => [
                            "marginTop"                => 10,
                            "borderBottomWidth"        => 7,
                            "borderColorHover"         => "rgb(0,255,0)",
                            "backgroundColorFromHover" => "rgba(255,0,255,0.5)",
                        ],
                        "tabDesignBlockModel"       => [
                            "marginTop"                => 10,
                            "borderBottomWidth"        => 7,
                            "borderColorHover"         => "rgb(0,255,0)",
                            "backgroundColorFromHover" => "rgba(255,0,255,0.5)",
                        ],
                        "tabDesignTextModel"        => [
                            "size" => 20
                        ],
                        "contentDesignBlockModel"   => [
                            "marginTop"                => 10,
                            "borderBottomWidth"        => 7,
                            "borderColorHover"         => "rgb(0,255,0)",
                            "backgroundColorFromHover" => "rgba(255,0,255,0.5)",
                        ],
                    ],
                    "textModel"       => [
                        "designTextModel"  => [
                            "size" => 10
                        ],
                        "designBlockModel" => [
                            "marginTop"                => 10,
                            "borderBottomWidth"        => 7,
                            "borderColorHover"         => "rgb(0,255,0)",
                            "backgroundColorFromHover" => "rgba(255,0,255,0.5)",
                        ],
                        "type"             => 1,
                        "hasEditor"        => true,
                    ],
                    "isShowEmpty"     => true,
                    "isLazyLoad"      => true,
                ],
                [
                    "designTabsModel" => [
                        "containerDesignBlockModel" => [
                            "marginTop"                => 10,
                            "borderBottomWidth"        => 7,
                            "borderColorHover"         => "rgb(0,255,0)",
                            "backgroundColorFromHover" => "rgba(255,0,255,0.5)",
                        ],
                        "tabDesignBlockModel"       => [
                            "marginTop"                => 10,
                            "borderBottomWidth"        => 7,
                            "borderColorHover"         => "rgb(0,255,0)",
                            "backgroundColorFromHover" => "rgba(255,0,255,0.5)",
                        ],
                        "tabDesignTextModel"        => [
                            "size" => 20
                        ],
                        "contentDesignBlockModel"   => [
                            "marginTop"                => 10,
                            "borderBottomWidth"        => 7,
                            "borderColorHover"         => "rgb(0,255,0)",
                            "backgroundColorFromHover" => "rgba(255,0,255,0.5)",
                        ],
                    ],
                    "textModel"       => [
                        "designTextModel"  => [
                            "size" => 10
                        ],
                        "designBlockModel" => [
                            "marginTop"                => 10,
                            "borderBottomWidth"        => 7,
                            "borderColorHover"         => "rgb(0,255,0)",
                            "backgroundColorFromHover" => "rgba(255,0,255,0.5)",
                        ],
                        "type"             => 1,
                        "hasEditor"        => true,
                    ],
                    "isShowEmpty"     => true,
                    "isLazyLoad"      => true,
                ],
                [
                    "designTabsModel" => [
                        "containerDesignBlockModel" => [
                            "marginTop"                => 20,
                            "borderBottomWidth"        => 70,
                            "borderColorHover"         => "rgb(255,255,0)",
                            "backgroundColorFromHover" => "rgba(0,0,255,0.5)",
                        ],
                        "tabDesignBlockModel"       => [
                            "marginTop"                => 20,
                            "borderBottomWidth"        => 70,
                            "borderColorHover"         => "rgb(255,255,0)",
                            "backgroundColorFromHover" => "rgba(0,0,255,0.5)",
                        ],
                        "tabDesignTextModel"        => [
                            "size" => 30
                        ],
                        "contentDesignBlockModel"   => [
                            "marginTop"                => 20,
                            "borderBottomWidth"        => 70,
                            "borderColorHover"         => "rgb(255,255,0)",
                            "backgroundColorFromHover" => "rgba(0,0,255,0.5)",
                        ],
                    ],
                    "textModel"       => [
                        "designTextModel"  => [
                            "size" => 30
                        ],
                        "designBlockModel" => [
                            "marginTop"                => 20,
                            "borderBottomWidth"        => 70,
                            "borderColorHover"         => "rgb(255,255,0)",
                            "backgroundColorFromHover" => "rgba(0,0,255,0.5)",
                        ],
                        "type"             => 0,
                        "hasEditor"        => false,
                    ],
                    "isShowEmpty"     => false,
                    "isLazyLoad"      => false,
                ],
                [
                    "designTabsModel" => [
                        "containerDesignBlockModel" => [
                            "marginTop"                => 20,
                            "borderBottomWidth"        => 70,
                            "borderColorHover"         => "rgb(255,255,0)",
                            "backgroundColorFromHover" => "rgba(0,0,255,0.5)",
                        ],
                        "tabDesignBlockModel"       => [
                            "marginTop"                => 20,
                            "borderBottomWidth"        => 70,
                            "borderColorHover"         => "rgb(255,255,0)",
                            "backgroundColorFromHover" => "rgba(0,0,255,0.5)",
                        ],
                        "tabDesignTextModel"        => [
                            "size" => 30
                        ],
                        "contentDesignBlockModel"   => [
                            "marginTop"                => 20,
                            "borderBottomWidth"        => 70,
                            "borderColorHover"         => "rgb(255,255,0)",
                            "backgroundColorFromHover" => "rgba(0,0,255,0.5)",
                        ],
                    ],
                    "textModel"       => [
                        "designTextModel"  => [
                            "size" => 30
                        ],
                        "designBlockModel" => [
                            "marginTop"                => 20,
                            "borderBottomWidth"        => 70,
                            "borderColorHover"         => "rgb(255,255,0)",
                            "backgroundColorFromHover" => "rgba(0,0,255,0.5)",
                        ],
                        "type"             => 0,
                        "hasEditor"        => false,
                    ],
                    "isShowEmpty"     => false,
                    "isLazyLoad"      => false,
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
        return [
            "incorrect1" => [
                [
                    "designTabsModel" => "incorrect",
                    "textModel"       => "incorrect",
                    "isShowEmpty"     => "incorrect",
                    "isLazyLoad"      => "incorrect",
                ],
                [
                    "designTabsModel" => [
                        "containerDesignBlockModel" => [
                            "marginTop" => 0
                        ],
                        "tabDesignBlockModel"       => [
                            "marginTop" => 0
                        ],
                        "tabDesignTextModel"        => [
                            "size" => 0
                        ],
                        "contentDesignBlockModel"   => [
                            "marginTop" => 0
                        ],
                    ],
                    "textModel"       => [
                        "designTextModel"  => [
                            "size" => 0
                        ],
                        "designBlockModel" => [
                            "marginTop" => 0
                        ],
                        "type"             => 0,
                        "hasEditor"        => false,
                    ],
                    "isShowEmpty"     => false,
                    "isLazyLoad"      => false,
                ],
                [
                    "designTabsModel" => [
                        "containerDesignBlockModel" => "incorrect",
                        "tabDesignBlockModel"       => "incorrect",
                        "tabDesignTextModel"        => "incorrect",
                        "contentDesignBlockModel"   => "incorrect",
                    ],
                    "textModel"       => [
                        "designTextModel"  => "incorrect",
                        "designBlockModel" => "incorrect",
                        "type"             => "incorrect",
                        "hasEditor"        => "incorrect",
                    ],
                ],
                [
                    "designTabsModel" => [
                        "containerDesignBlockModel" => [
                            "marginTop" => 0
                        ],
                        "tabDesignBlockModel"       => [
                            "marginTop" => 0
                        ],
                        "tabDesignTextModel"        => [
                            "size" => 0
                        ],
                        "contentDesignBlockModel"   => [
                            "marginTop" => 0
                        ],
                    ],
                    "textModel"       => [
                        "designTextModel"  => [
                            "size" => 0
                        ],
                        "designBlockModel" => [
                            "marginTop" => 0
                        ],
                        "type"             => 0,
                        "hasEditor"        => false,
                    ],
                    "isShowEmpty"     => false,
                    "isLazyLoad"      => false,
                ],
            ],
            "incorrect2" => [
                [
                    "designTabsModel" => [
                        "containerDesignBlockModel" => [
                            "marginTop" => "incorrect",
                        ],
                        "tabDesignBlockModel"       => [
                            "marginTop" => "incorrect",
                        ],
                        "tabDesignTextModel"        => [
                            "size" => "incorrect",
                        ],
                        "contentDesignBlockModel"   => [
                            "marginTop" => "incorrect",
                        ],
                    ],
                    "textModel"       => [
                        "designTextModel"  => [
                            "size" => "incorrect",
                        ],
                        "designBlockModel" => [
                            "marginTop" => "incorrect",
                        ],
                    ],
                ],
                [
                    "designTabsModel" => [
                        "containerDesignBlockModel" => [
                            "marginTop" => 0
                        ],
                        "tabDesignBlockModel"       => [
                            "marginTop" => 0
                        ],
                        "tabDesignTextModel"        => [
                            "size" => 0
                        ],
                        "contentDesignBlockModel"   => [
                            "marginTop" => 0
                        ],
                    ],
                    "textModel"       => [
                        "designTextModel"  => [
                            "size" => 0
                        ],
                        "designBlockModel" => [
                            "marginTop" => 0
                        ],
                        "type"             => 0,
                        "hasEditor"        => false,
                    ],
                    "isShowEmpty"     => false,
                    "isLazyLoad"      => false,
                ],
                [
                    "textModel"       => [
                        "type"             => 9999,
                        "hasEditor"        => 9999,
                    ],
                    "isShowEmpty"     => 999,
                    "isLazyLoad"      => 999,
                ],
                [
                    "designTabsModel" => [
                        "containerDesignBlockModel" => [
                            "marginTop" => 0
                        ],
                        "tabDesignBlockModel"       => [
                            "marginTop" => 0
                        ],
                        "tabDesignTextModel"        => [
                            "size" => 0
                        ],
                        "contentDesignBlockModel"   => [
                            "marginTop" => 0
                        ],
                    ],
                    "textModel"       => [
                        "designTextModel"  => [
                            "size" => 0
                        ],
                        "designBlockModel" => [
                            "marginTop" => 0
                        ],
                        "type"             => 0,
                        "hasEditor"        => true,
                    ],
                    "isShowEmpty"     => true,
                    "isLazyLoad"      => true,
                ],
            ]
        ];
    }

    /**
     * Data provider for CRUD. Duplicate
     *
     * @return array
     */
    public function testDuplicate()
    {
        $this->duplicate(
            [
                "designTabsModel" => [
                    "containerDesignBlockModel" => [
                        "marginTop"                => 10,
                        "borderBottomWidth"        => 7,
                        "borderColorHover"         => "rgb(0,255,0)",
                        "backgroundColorFromHover" => "rgba(255,0,255,0.5)",
                    ],
                    "tabDesignBlockModel"       => [
                        "marginTop"                => 10,
                        "borderBottomWidth"        => 7,
                        "borderColorHover"         => "rgb(0,255,0)",
                        "backgroundColorFromHover" => "rgba(255,0,255,0.5)",
                    ],
                    "tabDesignTextModel"        => [
                        "size" => 20
                    ],
                    "contentDesignBlockModel"   => [
                        "marginTop"                => 10,
                        "borderBottomWidth"        => 7,
                        "borderColorHover"         => "rgb(0,255,0)",
                        "backgroundColorFromHover" => "rgba(255,0,255,0.5)",
                    ],
                ],
                "textModel"       => [
                    "designTextModel"  => [
                        "size" => 10
                    ],
                    "designBlockModel" => [
                        "marginTop"                => 10,
                        "borderBottomWidth"        => 7,
                        "borderColorHover"         => "rgb(0,255,0)",
                        "backgroundColorFromHover" => "rgba(255,0,255,0.5)",
                    ],
                    "type"             => 1,
                    "hasEditor"        => true,
                ],
                "isShowEmpty"     => true,
                "isLazyLoad"      => true,
            ],
            [
                "designTabsModel" => [
                    "containerDesignBlockModel" => [
                        "marginTop"                => 10,
                        "borderBottomWidth"        => 7,
                        "borderColorHover"         => "rgb(0,255,0)",
                        "backgroundColorFromHover" => "rgba(255,0,255,0.5)",
                    ],
                    "tabDesignBlockModel"       => [
                        "marginTop"                => 10,
                        "borderBottomWidth"        => 7,
                        "borderColorHover"         => "rgb(0,255,0)",
                        "backgroundColorFromHover" => "rgba(255,0,255,0.5)",
                    ],
                    "tabDesignTextModel"        => [
                        "size" => 20
                    ],
                    "contentDesignBlockModel"   => [
                        "marginTop"                => 10,
                        "borderBottomWidth"        => 7,
                        "borderColorHover"         => "rgb(0,255,0)",
                        "backgroundColorFromHover" => "rgba(255,0,255,0.5)",
                    ],
                ],
                "textModel"       => [
                    "designTextModel"  => [
                        "size" => 10
                    ],
                    "designBlockModel" => [
                        "marginTop"                => 10,
                        "borderBottomWidth"        => 7,
                        "borderColorHover"         => "rgb(0,255,0)",
                        "backgroundColorFromHover" => "rgba(255,0,255,0.5)",
                    ],
                    "type"             => 1,
                    "hasEditor"        => true,
                ],
                "isShowEmpty"     => true,
                "isLazyLoad"      => true,
            ]
        );
    }
}