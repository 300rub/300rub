<?php

namespace testS\tests\unit\models;

use testS\models\DesignImageZoomModel;

/**
 * Tests for the model DesignImageZoomModel
 *
 * @package testS\tests\unit\models
 */
class DesignImageZoomModelTest extends AbstractModelTest
{

    /**
     * Gets model name
     *
     * @return DesignImageZoomModel
     */
    protected function getNewModel()
    {
        return new DesignImageZoomModel();
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
                    "designBlockModel"     => [
                        "marginTop" => 0
                    ],
                    "hasScroll"            => false,
                    "thumbsAlignment"      => 0,
                    "descriptionAlignment" => 0,
                    "effect"               => 0,
                ],
                [
                    "designBlockModel"     => "",
                    "hasScroll"            => "",
                    "thumbsAlignment"      => "",
                    "descriptionAlignment" => "",
                    "effect"               => "",
                ],
                [
                    "designBlockModel"     => [
                        "marginTop" => 0
                    ],
                    "hasScroll"            => false,
                    "thumbsAlignment"      => 0,
                    "descriptionAlignment" => 0,
                    "effect"               => 0,
                ]
            ],
            "empty2" => [
                [
                    "designBlockModel"     => null,
                    "hasScroll"            => null,
                    "thumbsAlignment"      => null,
                    "descriptionAlignment" => null,
                    "effect"               => null,
                ],
                [
                    "designBlockModel"     => [
                        "marginTop" => 0
                    ],
                    "hasScroll"            => false,
                    "thumbsAlignment"      => 0,
                    "descriptionAlignment" => 0,
                    "effect"               => 0,
                ],
                [
                    "designBlockModel"     => " ",
                    "hasScroll"            => " ",
                    "thumbsAlignment"      => " ",
                    "descriptionAlignment" => " ",
                    "effect"               => " ",
                ],
                [
                    "designBlockModel"     => [
                        "marginTop" => 0
                    ],
                    "hasScroll"            => false,
                    "thumbsAlignment"      => 0,
                    "descriptionAlignment" => 0,
                    "effect"               => 0,
                ],
            ],
            "empty3" => [
                [
                    "designBlockId" => " ",
                ],
                [
                    "designBlockModel"     => [
                        "marginTop" => 0
                    ],
                    "hasScroll"            => false,
                    "thumbsAlignment"      => 0,
                    "descriptionAlignment" => 0,
                    "effect"               => 0,
                ],
                [
                    "designBlockId" => null,
                ],
                [
                    "designBlockModel"     => [
                        "marginTop" => 0
                    ],
                    "hasScroll"            => false,
                    "thumbsAlignment"      => 0,
                    "descriptionAlignment" => 0,
                    "effect"               => 0,
                ],
            ],
            "empty4" => [
                [
                    "designBlockModel" => [
                        "marginTop" => " "
                    ],
                ],
                [
                    "designBlockModel"     => [
                        "marginTop" => 0
                    ],
                    "hasScroll"            => false,
                    "thumbsAlignment"      => 0,
                    "descriptionAlignment" => 0,
                    "effect"               => 0,
                ],
                [
                    "designBlockModel" => [],
                ],
                [
                    "designBlockModel"     => [
                        "marginTop" => 0
                    ],
                    "hasScroll"            => false,
                    "thumbsAlignment"      => 0,
                    "descriptionAlignment" => 0,
                    "effect"               => 0,
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
                    "designBlockModel"     => [
                        "marginTop"                => 10,
                        "borderBottomWidth"        => 7,
                        "borderColorHover"         => "rgb(0,255,0)",
                        "backgroundColorFromHover" => "rgba(255,0,255,0.5)",
                    ],
                    "hasScroll"            => true,
                    "thumbsAlignment"      => 1,
                    "descriptionAlignment" => 2,
                    "effect"               => 0,
                ],
                [
                    "designBlockModel"     => [
                        "marginTop"                => 10,
                        "borderBottomWidth"        => 7,
                        "borderColorHover"         => "rgb(0,255,0)",
                        "backgroundColorFromHover" => "rgba(255,0,255,0.5)",
                    ],
                    "hasScroll"            => true,
                    "thumbsAlignment"      => 1,
                    "descriptionAlignment" => 2,
                    "effect"               => 0,
                ],
                [
                    "designBlockModel"     => [
                        "marginTop"                => 5,
                        "borderBottomWidth"        => 4,
                        "borderColorHover"         => "rgb(255,0,0)",
                        "backgroundColorFromHover" => "rgba(0,0,255,0.7)",
                    ],
                    "hasScroll"            => false,
                    "thumbsAlignment"      => 2,
                    "descriptionAlignment" => 1,
                    "effect"               => 0,
                ],
                [
                    "designBlockModel"     => [
                        "marginTop"                => 5,
                        "borderBottomWidth"        => 4,
                        "borderColorHover"         => "rgb(255,0,0)",
                        "backgroundColorFromHover" => "rgba(0,0,255,0.7)",
                    ],
                    "hasScroll"            => false,
                    "thumbsAlignment"      => 2,
                    "descriptionAlignment" => 1,
                    "effect"               => 0,
                ],
            ],
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
                    "designBlockModel"     => "incorrect",
                    "hasScroll"            => "incorrect",
                    "thumbsAlignment"      => "incorrect",
                    "descriptionAlignment" => "incorrect",
                    "effect"               => "incorrect",
                ],
                [
                    "designBlockModel"     => [
                        "marginTop" => 0
                    ],
                    "hasScroll"            => false,
                    "thumbsAlignment"      => 0,
                    "descriptionAlignment" => 0,
                    "effect"               => 0,
                ],
                [
                    "hasScroll"            => 999,
                    "thumbsAlignment"      => 999,
                    "descriptionAlignment" => 999,
                    "effect"               => 999,
                ],
                [
                    "hasScroll"            => true,
                    "thumbsAlignment"      => 0,
                    "descriptionAlignment" => 0,
                    "effect"               => 0,
                ],
            ],
            "incorrect2" => [
                [
                    "hasScroll"            => " 1 ",
                    "thumbsAlignment"      => " 2 asd ",
                    "descriptionAlignment" => " asd1 ",
                    "effect"               => "0",
                ],
                [
                    "hasScroll"            => true,
                    "thumbsAlignment"      => 2,
                    "descriptionAlignment" => 0,
                    "effect"               => 0,
                ],
                [
                    "designBlockModel"     => [
                        "marginTop" => " 500 "
                    ],
                    "hasScroll"            => "-1",
                    "thumbsAlignment"      => "-1",
                    "descriptionAlignment" => "-1",
                    "effect"               => "-1",
                ],
                [
                    "designBlockModel"     => [
                        "marginTop" => 500
                    ],
                    "hasScroll"            => false,
                    "thumbsAlignment"      => 0,
                    "descriptionAlignment" => 0,
                    "effect"               => 0,
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
                "designBlockModel"     => [
                    "marginTop"                => 10,
                    "borderBottomWidth"        => 7,
                    "borderColorHover"         => "rgb(0,255,0)",
                    "backgroundColorFromHover" => "rgba(255,0,255,0.5)",
                ],
                "hasScroll"            => true,
                "thumbsAlignment"      => 1,
                "descriptionAlignment" => 2,
                "effect"               => 0,
            ],
            [
                "designBlockModel"     => [
                    "marginTop"                => 10,
                    "borderBottomWidth"        => 7,
                    "borderColorHover"         => "rgb(0,255,0)",
                    "backgroundColorFromHover" => "rgba(255,0,255,0.5)",
                ],
                "hasScroll"            => true,
                "thumbsAlignment"      => 1,
                "descriptionAlignment" => 2,
                "effect"               => 0,
            ]
        );
    }
}