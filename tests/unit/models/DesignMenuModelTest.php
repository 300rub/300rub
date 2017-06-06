<?php

namespace testS\tests\unit\models;

use testS\models\DesignMenuModel;

/**
 * Tests for the model DesignMenuModel
 *
 * @package testS\tests\unit\models
 */
class DesignMenuModelTest extends AbstractModelTest
{

    /**
     * Gets model name
     *
     * @return DesignMenuModel
     */
    protected function getNewModel()
    {
        return new DesignMenuModel();
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
                    "firstLevelDesignBlockModel"  => [
                        "marginTop" => 0
                    ],
                    "firstLevelDesignTextModel"   => [
                        "size" => 0
                    ],
                    "secondLevelDesignBlockModel" => [
                        "marginTop" => 0
                    ],
                    "secondLevelDesignTextModel"  => [
                        "size" => 0
                    ],
                    "lastLevelDesignBlockModel"   => [
                        "marginTop" => 0
                    ],
                    "lastLevelDesignTextModel"    => [
                        "size" => 0
                    ],
                ],
                [
                    "containerDesignBlockModel"   => "",
                    "firstLevelDesignBlockModel"  => "",
                    "firstLevelDesignTextModel"   => "",
                    "secondLevelDesignBlockModel" => "",
                    "secondLevelDesignTextModel"  => "",
                    "lastLevelDesignBlockModel"   => "",
                    "lastLevelDesignTextModel"    => "",
                ],
                [
                    "containerDesignBlockModel"   => [
                        "marginTop" => 0
                    ],
                    "firstLevelDesignBlockModel"  => [
                        "marginTop" => 0
                    ],
                    "firstLevelDesignTextModel"   => [
                        "size" => 0
                    ],
                    "secondLevelDesignBlockModel" => [
                        "marginTop" => 0
                    ],
                    "secondLevelDesignTextModel"  => [
                        "size" => 0
                    ],
                    "lastLevelDesignBlockModel"   => [
                        "marginTop" => 0
                    ],
                    "lastLevelDesignTextModel"    => [
                        "size" => 0
                    ],
                ],
            ],
            "empty2" => [
                [
                    "containerDesignBlockModel"   => null,
                    "firstLevelDesignBlockModel"  => null,
                    "firstLevelDesignTextModel"   => null,
                    "secondLevelDesignBlockModel" => null,
                    "secondLevelDesignTextModel"  => null,
                    "lastLevelDesignBlockModel"   => null,
                    "lastLevelDesignTextModel"    => null,
                ],
                [
                    "containerDesignBlockModel"   => [
                        "marginTop" => 0
                    ],
                    "firstLevelDesignBlockModel"  => [
                        "marginTop" => 0
                    ],
                    "firstLevelDesignTextModel"   => [
                        "size" => 0
                    ],
                    "secondLevelDesignBlockModel" => [
                        "marginTop" => 0
                    ],
                    "secondLevelDesignTextModel"  => [
                        "size" => 0
                    ],
                    "lastLevelDesignBlockModel"   => [
                        "marginTop" => 0
                    ],
                    "lastLevelDesignTextModel"    => [
                        "size" => 0
                    ],
                ],
                [
                    "containerDesignBlockModel"   => " ",
                    "firstLevelDesignBlockModel"  => " ",
                    "firstLevelDesignTextModel"   => " ",
                    "secondLevelDesignBlockModel" => " ",
                    "secondLevelDesignTextModel"  => " ",
                    "lastLevelDesignBlockModel"   => " ",
                    "lastLevelDesignTextModel"    => " ",
                ],
                [
                    "containerDesignBlockModel"   => [
                        "marginTop" => 0
                    ],
                    "firstLevelDesignBlockModel"  => [
                        "marginTop" => 0
                    ],
                    "firstLevelDesignTextModel"   => [
                        "size" => 0
                    ],
                    "secondLevelDesignBlockModel" => [
                        "marginTop" => 0
                    ],
                    "secondLevelDesignTextModel"  => [
                        "size" => 0
                    ],
                    "lastLevelDesignBlockModel"   => [
                        "marginTop" => 0
                    ],
                    "lastLevelDesignTextModel"    => [
                        "size" => 0
                    ],
                ],
            ],
            "empty3" => [
                [
                    "containerDesignBlockId"   => " ",
                    "firstLevelDesignBlockId"  => " ",
                    "firstLevelDesignTextId"   => " ",
                    "secondLevelDesignBlockId" => " ",
                    "secondLevelDesignTextId"  => " ",
                    "lastLevelDesignBlockId"   => " ",
                    "lastLevelDesignTextId"    => " ",
                ],
                [
                    "containerDesignBlockModel"   => [
                        "marginTop" => 0
                    ],
                    "firstLevelDesignBlockModel"  => [
                        "marginTop" => 0
                    ],
                    "firstLevelDesignTextModel"   => [
                        "size" => 0
                    ],
                    "secondLevelDesignBlockModel" => [
                        "marginTop" => 0
                    ],
                    "secondLevelDesignTextModel"  => [
                        "size" => 0
                    ],
                    "lastLevelDesignBlockModel"   => [
                        "marginTop" => 0
                    ],
                    "lastLevelDesignTextModel"    => [
                        "size" => 0
                    ],
                ],
                [
                    "containerDesignBlockId"   => null,
                    "firstLevelDesignBlockId"  => null,
                    "firstLevelDesignTextId"   => null,
                    "secondLevelDesignBlockId" => null,
                    "secondLevelDesignTextId"  => null,
                    "lastLevelDesignBlockId"   => null,
                    "lastLevelDesignTextId"    => null,
                ],
                [
                    "containerDesignBlockModel"   => [
                        "marginTop" => 0
                    ],
                    "firstLevelDesignBlockModel"  => [
                        "marginTop" => 0
                    ],
                    "firstLevelDesignTextModel"   => [
                        "size" => 0
                    ],
                    "secondLevelDesignBlockModel" => [
                        "marginTop" => 0
                    ],
                    "secondLevelDesignTextModel"  => [
                        "size" => 0
                    ],
                    "lastLevelDesignBlockModel"   => [
                        "marginTop" => 0
                    ],
                    "lastLevelDesignTextModel"    => [
                        "size" => 0
                    ],
                ],
            ],
            "empty4" => [
                [
                    "containerDesignBlockModel"   => [
                        "marginTop" => " "
                    ],
                    "firstLevelDesignBlockModel"  => [
                        "marginTop" => " "
                    ],
                    "firstLevelDesignTextModel"   => [
                        "size" => " "
                    ],
                    "secondLevelDesignBlockModel" => [
                        "marginTop" => " "
                    ],
                    "secondLevelDesignTextModel"  => [
                        "size" => " "
                    ],
                    "lastLevelDesignBlockModel"   => [
                        "marginTop" => " "
                    ],
                    "lastLevelDesignTextModel"    => [
                        "size" => " "
                    ],
                ],
                [
                    "containerDesignBlockModel"   => [
                        "marginTop" => 0
                    ],
                    "firstLevelDesignBlockModel"  => [
                        "marginTop" => 0
                    ],
                    "firstLevelDesignTextModel"   => [
                        "size" => 0
                    ],
                    "secondLevelDesignBlockModel" => [
                        "marginTop" => 0
                    ],
                    "secondLevelDesignTextModel"  => [
                        "size" => 0
                    ],
                    "lastLevelDesignBlockModel"   => [
                        "marginTop" => 0
                    ],
                    "lastLevelDesignTextModel"    => [
                        "size" => 0
                    ],
                ],
                [
                    "containerDesignBlockModel"   => [],
                    "firstLevelDesignBlockModel"  => [],
                    "firstLevelDesignTextModel"   => [],
                    "secondLevelDesignBlockModel" => [],
                    "secondLevelDesignTextModel"  => [],
                    "lastLevelDesignBlockModel"   => [],
                    "lastLevelDesignTextModel"    => [],
                ],
                [
                    "containerDesignBlockModel"   => [
                        "marginTop" => 0
                    ],
                    "firstLevelDesignBlockModel"  => [
                        "marginTop" => 0
                    ],
                    "firstLevelDesignTextModel"   => [
                        "size" => 0
                    ],
                    "secondLevelDesignBlockModel" => [
                        "marginTop" => 0
                    ],
                    "secondLevelDesignTextModel"  => [
                        "size" => 0
                    ],
                    "lastLevelDesignBlockModel"   => [
                        "marginTop" => 0
                    ],
                    "lastLevelDesignTextModel"    => [
                        "size" => 0
                    ],
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
                    "firstLevelDesignBlockModel"  => [
                        "marginTop"                => 10,
                        "borderBottomWidth"        => 7,
                        "borderColorHover"         => "rgb(0,255,0)",
                        "backgroundColorFromHover" => "rgba(255,0,255,0.5)",
                    ],
                    "firstLevelDesignTextModel"   => [
                        "size" => 10
                    ],
                    "secondLevelDesignBlockModel" => [
                        "marginTop"                => 10,
                        "borderBottomWidth"        => 7,
                        "borderColorHover"         => "rgb(0,255,0)",
                        "backgroundColorFromHover" => "rgba(255,0,255,0.5)",
                    ],
                    "secondLevelDesignTextModel"  => [
                        "size" => 10
                    ],
                    "lastLevelDesignBlockModel"   => [
                        "marginTop"                => 10,
                        "borderBottomWidth"        => 7,
                        "borderColorHover"         => "rgb(0,255,0)",
                        "backgroundColorFromHover" => "rgba(255,0,255,0.5)",
                    ],
                    "lastLevelDesignTextModel"    => [
                        "size" => 10
                    ],
                ],
                [
                    "containerDesignBlockModel"   => [
                        "marginTop"                => 10,
                        "borderBottomWidth"        => 7,
                        "borderColorHover"         => "rgb(0,255,0)",
                        "backgroundColorFromHover" => "rgba(255,0,255,0.5)",
                    ],
                    "firstLevelDesignBlockModel"  => [
                        "marginTop"                => 10,
                        "borderBottomWidth"        => 7,
                        "borderColorHover"         => "rgb(0,255,0)",
                        "backgroundColorFromHover" => "rgba(255,0,255,0.5)",
                    ],
                    "firstLevelDesignTextModel"   => [
                        "size" => 10
                    ],
                    "secondLevelDesignBlockModel" => [
                        "marginTop"                => 10,
                        "borderBottomWidth"        => 7,
                        "borderColorHover"         => "rgb(0,255,0)",
                        "backgroundColorFromHover" => "rgba(255,0,255,0.5)",
                    ],
                    "secondLevelDesignTextModel"  => [
                        "size" => 10
                    ],
                    "lastLevelDesignBlockModel"   => [
                        "marginTop"                => 10,
                        "borderBottomWidth"        => 7,
                        "borderColorHover"         => "rgb(0,255,0)",
                        "backgroundColorFromHover" => "rgba(255,0,255,0.5)",
                    ],
                    "lastLevelDesignTextModel"    => [
                        "size" => 10
                    ],
                ],
                [
                    "containerDesignBlockModel"   => [
                        "marginTop"                => 5,
                        "borderBottomWidth"        => 4,
                        "borderColorHover"         => "rgb(255,0,0)",
                        "backgroundColorFromHover" => "rgba(0,0,255,0.7)",
                    ],
                    "firstLevelDesignBlockModel"  => [
                        "marginTop"                => 5,
                        "borderBottomWidth"        => 4,
                        "borderColorHover"         => "rgb(255,0,0)",
                        "backgroundColorFromHover" => "rgba(0,0,255,0.7)",
                    ],
                    "firstLevelDesignTextModel"   => [
                        "size" => 20
                    ],
                    "secondLevelDesignBlockModel" => [
                        "marginTop"                => 5,
                        "borderBottomWidth"        => 4,
                        "borderColorHover"         => "rgb(255,0,0)",
                        "backgroundColorFromHover" => "rgba(0,0,255,0.7)",
                    ],
                    "secondLevelDesignTextModel"  => [
                        "size" => 20
                    ],
                    "lastLevelDesignBlockModel"   => [
                        "marginTop"                => 5,
                        "borderBottomWidth"        => 4,
                        "borderColorHover"         => "rgb(255,0,0)",
                        "backgroundColorFromHover" => "rgba(0,0,255,0.7)",
                    ],
                    "lastLevelDesignTextModel"    => [
                        "size" => 20
                    ],
                ],
                [
                    "containerDesignBlockModel"   => [
                        "marginTop"                => 5,
                        "borderBottomWidth"        => 4,
                        "borderColorHover"         => "rgb(255,0,0)",
                        "backgroundColorFromHover" => "rgba(0,0,255,0.7)",
                    ],
                    "firstLevelDesignBlockModel"  => [
                        "marginTop"                => 5,
                        "borderBottomWidth"        => 4,
                        "borderColorHover"         => "rgb(255,0,0)",
                        "backgroundColorFromHover" => "rgba(0,0,255,0.7)",
                    ],
                    "firstLevelDesignTextModel"   => [
                        "size" => 20
                    ],
                    "secondLevelDesignBlockModel" => [
                        "marginTop"                => 5,
                        "borderBottomWidth"        => 4,
                        "borderColorHover"         => "rgb(255,0,0)",
                        "backgroundColorFromHover" => "rgba(0,0,255,0.7)",
                    ],
                    "secondLevelDesignTextModel"  => [
                        "size" => 20
                    ],
                    "lastLevelDesignBlockModel"   => [
                        "marginTop"                => 5,
                        "borderBottomWidth"        => 4,
                        "borderColorHover"         => "rgb(255,0,0)",
                        "backgroundColorFromHover" => "rgba(0,0,255,0.7)",
                    ],
                    "lastLevelDesignTextModel"    => [
                        "size" => 20
                    ],
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
                    "containerDesignBlockModel"   => "incorrect",
                    "firstLevelDesignBlockModel"  => "incorrect",
                    "firstLevelDesignTextModel"   => "incorrect",
                    "secondLevelDesignBlockModel" => "incorrect",
                    "secondLevelDesignTextModel"  => "incorrect",
                    "lastLevelDesignBlockModel"   => "incorrect",
                    "lastLevelDesignTextModel"    => "incorrect",
                ],
                [
                    "containerDesignBlockModel"   => [
                        "marginTop" => 0
                    ],
                    "firstLevelDesignBlockModel"  => [
                        "marginTop" => 0
                    ],
                    "firstLevelDesignTextModel"   => [
                        "size" => 0
                    ],
                    "secondLevelDesignBlockModel" => [
                        "marginTop" => 0
                    ],
                    "secondLevelDesignTextModel"  => [
                        "size" => 0
                    ],
                    "lastLevelDesignBlockModel"   => [
                        "marginTop" => 0
                    ],
                    "lastLevelDesignTextModel"    => [
                        "size" => 0
                    ],
                ],
                [
                    "containerDesignBlockModel"   => [
                        "marginTop" => " 500 "
                    ],
                    "firstLevelDesignBlockModel"  => [
                        "marginTop" => " 500 "
                    ],
                    "firstLevelDesignTextModel"   => [
                        "size" => " 500 "
                    ],
                    "secondLevelDesignBlockModel" => [
                        "marginTop" => " 500 "
                    ],
                    "secondLevelDesignTextModel"  => [
                        "size" => " 500 "
                    ],
                    "lastLevelDesignBlockModel"   => [
                        "marginTop" => " 500 "
                    ],
                    "lastLevelDesignTextModel"    => [
                        "size" => " 500 "
                    ],
                ],
                [
                    "containerDesignBlockModel"   => [
                        "marginTop" => 500
                    ],
                    "firstLevelDesignBlockModel"  => [
                        "marginTop" => 500
                    ],
                    "firstLevelDesignTextModel"   => [
                        "size" => 500
                    ],
                    "secondLevelDesignBlockModel" => [
                        "marginTop" => 500
                    ],
                    "secondLevelDesignTextModel"  => [
                        "size" => 500
                    ],
                    "lastLevelDesignBlockModel"   => [
                        "marginTop" => 500
                    ],
                    "lastLevelDesignTextModel"    => [
                        "size" => 500
                    ],
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
                "firstLevelDesignBlockModel"  => [
                    "marginTop"                => 10,
                    "borderBottomWidth"        => 7,
                    "borderColorHover"         => "rgb(0,255,0)",
                    "backgroundColorFromHover" => "rgba(255,0,255,0.5)",
                ],
                "firstLevelDesignTextModel"   => [
                    "size" => 10
                ],
                "secondLevelDesignBlockModel" => [
                    "marginTop"                => 10,
                    "borderBottomWidth"        => 7,
                    "borderColorHover"         => "rgb(0,255,0)",
                    "backgroundColorFromHover" => "rgba(255,0,255,0.5)",
                ],
                "secondLevelDesignTextModel"  => [
                    "size" => 10
                ],
                "lastLevelDesignBlockModel"   => [
                    "marginTop"                => 10,
                    "borderBottomWidth"        => 7,
                    "borderColorHover"         => "rgb(0,255,0)",
                    "backgroundColorFromHover" => "rgba(255,0,255,0.5)",
                ],
                "lastLevelDesignTextModel"    => [
                    "size" => 10
                ],
            ],
            [
                "containerDesignBlockModel"   => [
                    "marginTop"                => 10,
                    "borderBottomWidth"        => 7,
                    "borderColorHover"         => "rgb(0,255,0)",
                    "backgroundColorFromHover" => "rgba(255,0,255,0.5)",
                ],
                "firstLevelDesignBlockModel"  => [
                    "marginTop"                => 10,
                    "borderBottomWidth"        => 7,
                    "borderColorHover"         => "rgb(0,255,0)",
                    "backgroundColorFromHover" => "rgba(255,0,255,0.5)",
                ],
                "firstLevelDesignTextModel"   => [
                    "size" => 10
                ],
                "secondLevelDesignBlockModel" => [
                    "marginTop"                => 10,
                    "borderBottomWidth"        => 7,
                    "borderColorHover"         => "rgb(0,255,0)",
                    "backgroundColorFromHover" => "rgba(255,0,255,0.5)",
                ],
                "secondLevelDesignTextModel"  => [
                    "size" => 10
                ],
                "lastLevelDesignBlockModel"   => [
                    "marginTop"                => 10,
                    "borderBottomWidth"        => 7,
                    "borderColorHover"         => "rgb(0,255,0)",
                    "backgroundColorFromHover" => "rgba(255,0,255,0.5)",
                ],
                "lastLevelDesignTextModel"    => [
                    "size" => 10
                ],
            ]
        );
    }
}