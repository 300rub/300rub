<?php

namespace testS\tests\unit\models;

use testS\models\DesignImageSliderModel;

/**
 * Tests for the model DesignImageSliderModel
 *
 * @package testS\tests\unit\models
 */
class DesignImageSliderModelTest extends AbstractModelTest
{

    /**
     * Gets model name
     *
     * @return DesignImageSliderModel
     */
    protected function getNewModel()
    {
        return new DesignImageSliderModel();
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
                    "containerDesignBlockModel"   => [
                        "marginTop" => 0
                    ],
                    "navigationDesignBlockModel"  => [
                        "marginTop" => 0
                    ],
                    "descriptionDesignBlockModel" => [
                        "marginTop" => 0
                    ],
                    "effect"                      => 0,
                    "hasAutoPlay"                 => false,
                    "playSpeed"                   => 0,
                    "navigationAlignment"         => 0,
                    "descriptionAlignment"        => 0,
                ],
                [
                    "containerDesignBlockModel"   => "",
                    "navigationDesignBlockModel"  => "",
                    "descriptionDesignBlockModel" => "",
                    "effect"                      => "",
                    "hasAutoPlay"                 => "",
                    "playSpeed"                   => "",
                    "navigationAlignment"         => "",
                    "descriptionAlignment"        => "",
                ],
                [
                    "containerDesignBlockModel"   => [
                        "marginTop" => 0
                    ],
                    "navigationDesignBlockModel"  => [
                        "marginTop" => 0
                    ],
                    "descriptionDesignBlockModel" => [
                        "marginTop" => 0
                    ],
                    "effect"                      => 0,
                    "hasAutoPlay"                 => false,
                    "playSpeed"                   => 0,
                    "navigationAlignment"         => 0,
                    "descriptionAlignment"        => 0,
                ],
            ],
            "empty2" => [
                [
                    "containerDesignBlockModel"   => null,
                    "navigationDesignBlockModel"  => null,
                    "descriptionDesignBlockModel" => null,
                    "effect"                      => null,
                    "hasAutoPlay"                 => null,
                    "playSpeed"                   => null,
                    "navigationAlignment"         => null,
                    "descriptionAlignment"        => null,
                ],
                [
                    "containerDesignBlockModel"   => [
                        "marginTop" => 0
                    ],
                    "navigationDesignBlockModel"  => [
                        "marginTop" => 0
                    ],
                    "descriptionDesignBlockModel" => [
                        "marginTop" => 0
                    ],
                    "effect"                      => 0,
                    "hasAutoPlay"                 => false,
                    "playSpeed"                   => 0,
                    "navigationAlignment"         => 0,
                    "descriptionAlignment"        => 0,
                ],
                [
                    "containerDesignBlockModel"   => " ",
                    "navigationDesignBlockModel"  => " ",
                    "descriptionDesignBlockModel" => " ",
                    "effect"                      => " ",
                    "hasAutoPlay"                 => " ",
                    "playSpeed"                   => " ",
                    "navigationAlignment"         => " ",
                    "descriptionAlignment"        => " ",
                ],
                [
                    "containerDesignBlockModel"   => [
                        "marginTop" => 0
                    ],
                    "navigationDesignBlockModel"  => [
                        "marginTop" => 0
                    ],
                    "descriptionDesignBlockModel" => [
                        "marginTop" => 0
                    ],
                    "effect"                      => 0,
                    "hasAutoPlay"                 => false,
                    "playSpeed"                   => 0,
                    "navigationAlignment"         => 0,
                    "descriptionAlignment"        => 0,
                ],
            ],
            "empty3" => [
                [
                    "containerDesignBlockId"   => " ",
                    "navigationDesignBlockId"  => " ",
                    "descriptionDesignBlockId" => " ",
                ],
                [
                    "containerDesignBlockModel"   => [
                        "marginTop" => 0
                    ],
                    "navigationDesignBlockModel"  => [
                        "marginTop" => 0
                    ],
                    "descriptionDesignBlockModel" => [
                        "marginTop" => 0
                    ],
                    "effect"                      => 0,
                    "hasAutoPlay"                 => false,
                    "playSpeed"                   => 0,
                    "navigationAlignment"         => 0,
                    "descriptionAlignment"        => 0,
                ],
                [
                    "containerDesignBlockId"   => null,
                    "navigationDesignBlockId"  => null,
                    "descriptionDesignBlockId" => null,
                ],
                [
                    "containerDesignBlockModel"   => [
                        "marginTop" => 0
                    ],
                    "navigationDesignBlockModel"  => [
                        "marginTop" => 0
                    ],
                    "descriptionDesignBlockModel" => [
                        "marginTop" => 0
                    ],
                    "effect"                      => 0,
                    "hasAutoPlay"                 => false,
                    "playSpeed"                   => 0,
                    "navigationAlignment"         => 0,
                    "descriptionAlignment"        => 0,
                ],
            ],
            "empty4" => [
                [
                    "containerDesignBlockModel"   => [
                        "marginTop" => " "
                    ],
                    "navigationDesignBlockModel"  => [
                        "marginTop" => " "
                    ],
                    "descriptionDesignBlockModel" => [
                        "marginTop" => " "
                    ],
                ],
                [
                    "containerDesignBlockModel"   => [
                        "marginTop" => 0
                    ],
                    "navigationDesignBlockModel"  => [
                        "marginTop" => 0
                    ],
                    "descriptionDesignBlockModel" => [
                        "marginTop" => 0
                    ],
                    "effect"                      => 0,
                    "hasAutoPlay"                 => false,
                    "playSpeed"                   => 0,
                    "navigationAlignment"         => 0,
                    "descriptionAlignment"        => 0,
                ],
                [
                    "containerDesignBlockModel"   => [],
                    "navigationDesignBlockModel"  => [],
                    "descriptionDesignBlockModel" => [],
                ],
                [
                    "containerDesignBlockModel"   => [
                        "marginTop" => 0
                    ],
                    "navigationDesignBlockModel"  => [
                        "marginTop" => 0
                    ],
                    "descriptionDesignBlockModel" => [
                        "marginTop" => 0
                    ],
                    "effect"                      => 0,
                    "hasAutoPlay"                 => false,
                    "playSpeed"                   => 0,
                    "navigationAlignment"         => 0,
                    "descriptionAlignment"        => 0,
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
                    "containerDesignBlockModel"   => [
                        "marginTop"                => 10,
                        "borderBottomWidth"        => 7,
                        "borderColorHover"         => "rgb(0,255,0)",
                        "backgroundColorFromHover" => "rgba(255,0,255,0.5)",
                    ],
                    "navigationDesignBlockModel"  => [
                        "marginTop"                => 10,
                        "borderBottomWidth"        => 7,
                        "borderColorHover"         => "rgb(0,255,0)",
                        "backgroundColorFromHover" => "rgba(255,0,255,0.5)",
                    ],
                    "descriptionDesignBlockModel" => [
                        "marginTop"                => 10,
                        "borderBottomWidth"        => 7,
                        "borderColorHover"         => "rgb(0,255,0)",
                        "backgroundColorFromHover" => "rgba(255,0,255,0.5)",
                    ],
                    "effect"                      => 0,
                    "hasAutoPlay"                 => true,
                    "playSpeed"                   => 10,
                    "navigationAlignment"         => 1,
                    "descriptionAlignment"        => 2,
                ],
                [
                    "containerDesignBlockModel"   => [
                        "marginTop"                => 10,
                        "borderBottomWidth"        => 7,
                        "borderColorHover"         => "rgb(0,255,0)",
                        "backgroundColorFromHover" => "rgba(255,0,255,0.5)",
                    ],
                    "navigationDesignBlockModel"  => [
                        "marginTop"                => 10,
                        "borderBottomWidth"        => 7,
                        "borderColorHover"         => "rgb(0,255,0)",
                        "backgroundColorFromHover" => "rgba(255,0,255,0.5)",
                    ],
                    "descriptionDesignBlockModel" => [
                        "marginTop"                => 10,
                        "borderBottomWidth"        => 7,
                        "borderColorHover"         => "rgb(0,255,0)",
                        "backgroundColorFromHover" => "rgba(255,0,255,0.5)",
                    ],
                    "effect"                      => 0,
                    "hasAutoPlay"                 => true,
                    "playSpeed"                   => 10,
                    "navigationAlignment"         => 1,
                    "descriptionAlignment"        => 2,
                ],
                [
                    "containerDesignBlockModel"   => [
                        "marginTop"                => 5,
                        "borderBottomWidth"        => 4,
                        "borderColorHover"         => "rgb(255,0,0)",
                        "backgroundColorFromHover" => "rgba(0,0,255,0.7)",
                    ],
                    "navigationDesignBlockModel"  => [
                        "marginTop"                => 5,
                        "borderBottomWidth"        => 4,
                        "borderColorHover"         => "rgb(255,0,0)",
                        "backgroundColorFromHover" => "rgba(0,0,255,0.7)",
                    ],
                    "descriptionDesignBlockModel" => [
                        "marginTop"                => 5,
                        "borderBottomWidth"        => 4,
                        "borderColorHover"         => "rgb(255,0,0)",
                        "backgroundColorFromHover" => "rgba(0,0,255,0.7)",
                    ],
                    "effect"                      => 0,
                    "hasAutoPlay"                 => false,
                    "playSpeed"                   => 5,
                    "navigationAlignment"         => 2,
                    "descriptionAlignment"        => 1,
                ],
                [
                    "containerDesignBlockModel"   => [
                        "marginTop"                => 5,
                        "borderBottomWidth"        => 4,
                        "borderColorHover"         => "rgb(255,0,0)",
                        "backgroundColorFromHover" => "rgba(0,0,255,0.7)",
                    ],
                    "navigationDesignBlockModel"  => [
                        "marginTop"                => 5,
                        "borderBottomWidth"        => 4,
                        "borderColorHover"         => "rgb(255,0,0)",
                        "backgroundColorFromHover" => "rgba(0,0,255,0.7)",
                    ],
                    "descriptionDesignBlockModel" => [
                        "marginTop"                => 5,
                        "borderBottomWidth"        => 4,
                        "borderColorHover"         => "rgb(255,0,0)",
                        "backgroundColorFromHover" => "rgba(0,0,255,0.7)",
                    ],
                    "effect"                      => 0,
                    "hasAutoPlay"                 => false,
                    "playSpeed"                   => 5,
                    "navigationAlignment"         => 2,
                    "descriptionAlignment"        => 1,
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
                    "containerDesignBlockModel"   => null,
                    "navigationDesignBlockModel"  => null,
                    "descriptionDesignBlockModel" => null,
                    "effect"                      => null,
                    "hasAutoPlay"                 => null,
                    "playSpeed"                   => null,
                    "navigationAlignment"         => null,
                    "descriptionAlignment"        => null,
                ],
                [
                    "containerDesignBlockModel"   => [
                        "marginTop" => 0
                    ],
                    "navigationDesignBlockModel"  => [
                        "marginTop" => 0
                    ],
                    "descriptionDesignBlockModel" => [
                        "marginTop" => 0
                    ],
                    "effect"                      => 0,
                    "hasAutoPlay"                 => false,
                    "playSpeed"                   => 0,
                    "navigationAlignment"         => 0,
                    "descriptionAlignment"        => 0,
                ],
                [
                    "effect"               => 999,
                    "hasAutoPlay"          => 999,
                    "playSpeed"            => -50,
                    "navigationAlignment"  => 999,
                    "descriptionAlignment" => 999,
                ],
                [
                    "effect"               => 0,
                    "hasAutoPlay"          => true,
                    "playSpeed"            => 0,
                    "navigationAlignment"  => 0,
                    "descriptionAlignment" => 0,
                ],
            ],
            "incorrect2" => [
                [
                    "effect"               => " 0 ",
                    "hasAutoPlay"          => " 1 ",
                    "playSpeed"            => " 2 ",
                    "navigationAlignment"  => " 2 ",
                    "descriptionAlignment" => " 1 ",
                ],
                [
                    "effect"               => 0,
                    "hasAutoPlay"          => true,
                    "playSpeed"            => 2,
                    "navigationAlignment"  => 2,
                    "descriptionAlignment" => 1,
                ],
                [
                    "containerDesignBlockModel" => [
                        "marginTop" => " 500 "
                    ],
                    "effect"                    => "-1",
                    "hasAutoPlay"               => "-1",
                    "playSpeed"                 => "-1",
                    "navigationAlignment"       => "-1",
                    "descriptionAlignment"      => "-1",
                ],
                [
                    "containerDesignBlockModel" => [
                        "marginTop" => 500
                    ],
                    "effect"                    => 0,
                    "hasAutoPlay"               => false,
                    "playSpeed"                 => 0,
                    "navigationAlignment"       => 0,
                    "descriptionAlignment"      => 0,
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
                "containerDesignBlockModel"   => [
                    "marginTop"                => 10,
                    "borderBottomWidth"        => 7,
                    "borderColorHover"         => "rgb(0,255,0)",
                    "backgroundColorFromHover" => "rgba(255,0,255,0.5)",
                ],
                "navigationDesignBlockModel"  => [
                    "marginTop"                => 10,
                    "borderBottomWidth"        => 7,
                    "borderColorHover"         => "rgb(0,255,0)",
                    "backgroundColorFromHover" => "rgba(255,0,255,0.5)",
                ],
                "descriptionDesignBlockModel" => [
                    "marginTop"                => 10,
                    "borderBottomWidth"        => 7,
                    "borderColorHover"         => "rgb(0,255,0)",
                    "backgroundColorFromHover" => "rgba(255,0,255,0.5)",
                ],
                "effect"                      => 0,
                "hasAutoPlay"                 => true,
                "playSpeed"                   => 10,
                "navigationAlignment"         => 1,
                "descriptionAlignment"        => 2,
            ],
            [
                "containerDesignBlockModel"   => [
                    "marginTop"                => 10,
                    "borderBottomWidth"        => 7,
                    "borderColorHover"         => "rgb(0,255,0)",
                    "backgroundColorFromHover" => "rgba(255,0,255,0.5)",
                ],
                "navigationDesignBlockModel"  => [
                    "marginTop"                => 10,
                    "borderBottomWidth"        => 7,
                    "borderColorHover"         => "rgb(0,255,0)",
                    "backgroundColorFromHover" => "rgba(255,0,255,0.5)",
                ],
                "descriptionDesignBlockModel" => [
                    "marginTop"                => 10,
                    "borderBottomWidth"        => 7,
                    "borderColorHover"         => "rgb(0,255,0)",
                    "backgroundColorFromHover" => "rgba(255,0,255,0.5)",
                ],
                "effect"                      => 0,
                "hasAutoPlay"                 => true,
                "playSpeed"                   => 10,
                "navigationAlignment"         => 1,
                "descriptionAlignment"        => 2,
            ]
        );
    }
}