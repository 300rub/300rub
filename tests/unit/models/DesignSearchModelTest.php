<?php

namespace testS\tests\unit\models;

use testS\models\DesignSearchModel;

/**
 * Tests for the model DesignSearchModel
 *
 * @package testS\tests\unit\models
 */
class DesignSearchModelTest extends AbstractModelTest
{

    /**
     * Gets model name
     *
     * @return DesignSearchModel
     */
    protected function getNewModel()
    {
        return new DesignSearchModel();
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
                    "containerDesignBlockModel"      => [
                        "marginTop" => 0
                    ],
                    "titleDesignBlockModel"          => [
                        "marginTop" => 0
                    ],
                    "titleDesignTextModel"           => [
                        "size" => 0
                    ],
                    "descriptionDesignBlockModel"    => [
                        "marginTop" => 0
                    ],
                    "descriptionDesignTextModel"     => [
                        "size" => 0
                    ],
                    "paginationDesignBlockModel"     => [
                        "marginTop" => 0
                    ],
                    "paginationItemDesignBlockModel" => [
                        "marginTop" => 0
                    ],
                    "paginationItemDesignTextModel"  => [
                        "size" => 0
                    ],
                ],
                [
                    "containerDesignBlockModel"      => "",
                    "titleDesignBlockModel"          => "",
                    "titleDesignTextModel"           => "",
                    "descriptionDesignBlockModel"    => "",
                    "descriptionDesignTextModel"     => "",
                    "paginationDesignBlockModel"     => "",
                    "paginationItemDesignBlockModel" => "",
                    "paginationItemDesignTextModel"  => "",
                ],
                [
                    "containerDesignBlockModel"      => [
                        "marginTop" => 0
                    ],
                    "titleDesignBlockModel"          => [
                        "marginTop" => 0
                    ],
                    "titleDesignTextModel"           => [
                        "size" => 0
                    ],
                    "descriptionDesignBlockModel"    => [
                        "marginTop" => 0
                    ],
                    "descriptionDesignTextModel"     => [
                        "size" => 0
                    ],
                    "paginationDesignBlockModel"     => [
                        "marginTop" => 0
                    ],
                    "paginationItemDesignBlockModel" => [
                        "marginTop" => 0
                    ],
                    "paginationItemDesignTextModel"  => [
                        "size" => 0
                    ],
                ],
            ],
            "empty2" => [
                [
                    "containerDesignBlockModel"      => null,
                    "titleDesignBlockModel"          => null,
                    "titleDesignTextModel"           => null,
                    "descriptionDesignBlockModel"    => null,
                    "descriptionDesignTextModel"     => null,
                    "paginationDesignBlockModel"     => null,
                    "paginationItemDesignBlockModel" => null,
                    "paginationItemDesignTextModel"  => null,
                ],
                [
                    "containerDesignBlockModel"      => [
                        "marginTop" => 0
                    ],
                    "titleDesignBlockModel"          => [
                        "marginTop" => 0
                    ],
                    "titleDesignTextModel"           => [
                        "size" => 0
                    ],
                    "descriptionDesignBlockModel"    => [
                        "marginTop" => 0
                    ],
                    "descriptionDesignTextModel"     => [
                        "size" => 0
                    ],
                    "paginationDesignBlockModel"     => [
                        "marginTop" => 0
                    ],
                    "paginationItemDesignBlockModel" => [
                        "marginTop" => 0
                    ],
                    "paginationItemDesignTextModel"  => [
                        "size" => 0
                    ],
                ],
                [
                    "containerDesignBlockModel"      => " ",
                    "titleDesignBlockModel"          => " ",
                    "titleDesignTextModel"           => " ",
                    "descriptionDesignBlockModel"    => " ",
                    "descriptionDesignTextModel"     => " ",
                    "paginationDesignBlockModel"     => " ",
                    "paginationItemDesignBlockModel" => " ",
                    "paginationItemDesignTextModel"  => " ",
                ],
                [
                    "containerDesignBlockModel"      => [
                        "marginTop" => 0
                    ],
                    "titleDesignBlockModel"          => [
                        "marginTop" => 0
                    ],
                    "titleDesignTextModel"           => [
                        "size" => 0
                    ],
                    "descriptionDesignBlockModel"    => [
                        "marginTop" => 0
                    ],
                    "descriptionDesignTextModel"     => [
                        "size" => 0
                    ],
                    "paginationDesignBlockModel"     => [
                        "marginTop" => 0
                    ],
                    "paginationItemDesignBlockModel" => [
                        "marginTop" => 0
                    ],
                    "paginationItemDesignTextModel"  => [
                        "size" => 0
                    ],
                ],
            ],
            "empty3" => [
                [
                    "containerDesignBlockId"      => " ",
                    "titleDesignBlockId"          => " ",
                    "titleDesignTextId"           => " ",
                    "descriptionDesignBlockId"    => " ",
                    "descriptionDesignTextId"     => " ",
                    "paginationDesignBlockId"     => " ",
                    "paginationItemDesignBlockId" => " ",
                    "paginationItemDesignTextId"  => " ",
                ],
                [
                    "containerDesignBlockModel"      => [
                        "marginTop" => 0
                    ],
                    "titleDesignBlockModel"          => [
                        "marginTop" => 0
                    ],
                    "titleDesignTextModel"           => [
                        "size" => 0
                    ],
                    "descriptionDesignBlockModel"    => [
                        "marginTop" => 0
                    ],
                    "descriptionDesignTextModel"     => [
                        "size" => 0
                    ],
                    "paginationDesignBlockModel"     => [
                        "marginTop" => 0
                    ],
                    "paginationItemDesignBlockModel" => [
                        "marginTop" => 0
                    ],
                    "paginationItemDesignTextModel"  => [
                        "size" => 0
                    ],
                ],
                [
                    "containerDesignBlockId"      => null,
                    "titleDesignBlockId"          => null,
                    "titleDesignTextId"           => null,
                    "descriptionDesignBlockId"    => null,
                    "descriptionDesignTextId"     => null,
                    "paginationDesignBlockId"     => null,
                    "paginationItemDesignBlockId" => null,
                    "paginationItemDesignTextId"  => null,
                ],
                [
                    "containerDesignBlockModel"      => [
                        "marginTop" => 0
                    ],
                    "titleDesignBlockModel"          => [
                        "marginTop" => 0
                    ],
                    "titleDesignTextModel"           => [
                        "size" => 0
                    ],
                    "descriptionDesignBlockModel"    => [
                        "marginTop" => 0
                    ],
                    "descriptionDesignTextModel"     => [
                        "size" => 0
                    ],
                    "paginationDesignBlockModel"     => [
                        "marginTop" => 0
                    ],
                    "paginationItemDesignBlockModel" => [
                        "marginTop" => 0
                    ],
                    "paginationItemDesignTextModel"  => [
                        "size" => 0
                    ],
                ],
            ],
            "empty4" => [
                [
                    "containerDesignBlockModel"      => [
                        "marginTop" => " "
                    ],
                    "titleDesignBlockModel"          => [
                        "marginTop" => " "
                    ],
                    "titleDesignTextModel"           => [
                        "size" => " "
                    ],
                    "descriptionDesignBlockModel"    => [
                        "marginTop" => " "
                    ],
                    "descriptionDesignTextModel"     => [
                        "size" => " "
                    ],
                    "paginationDesignBlockModel"     => [
                        "marginTop" => " "
                    ],
                    "paginationItemDesignBlockModel" => [
                        "marginTop" => " "
                    ],
                    "paginationItemDesignTextModel"  => [
                        "size" => " "
                    ],
                ],
                [
                    "containerDesignBlockModel"      => [
                        "marginTop" => 0
                    ],
                    "titleDesignBlockModel"          => [
                        "marginTop" => 0
                    ],
                    "titleDesignTextModel"           => [
                        "size" => 0
                    ],
                    "descriptionDesignBlockModel"    => [
                        "marginTop" => 0
                    ],
                    "descriptionDesignTextModel"     => [
                        "size" => 0
                    ],
                    "paginationDesignBlockModel"     => [
                        "marginTop" => 0
                    ],
                    "paginationItemDesignBlockModel" => [
                        "marginTop" => 0
                    ],
                    "paginationItemDesignTextModel"  => [
                        "size" => 0
                    ],
                ],
                [
                    "containerDesignBlockModel"      => [],
                    "titleDesignBlockModel"          => [],
                    "titleDesignTextModel"           => [],
                    "descriptionDesignBlockModel"    => [],
                    "descriptionDesignTextModel"     => [],
                    "paginationDesignBlockModel"     => [],
                    "paginationItemDesignBlockModel" => [],
                    "paginationItemDesignTextModel"  => [],
                ],
                [
                    "containerDesignBlockModel"      => [
                        "marginTop" => 0
                    ],
                    "titleDesignBlockModel"          => [
                        "marginTop" => 0
                    ],
                    "titleDesignTextModel"           => [
                        "size" => 0
                    ],
                    "descriptionDesignBlockModel"    => [
                        "marginTop" => 0
                    ],
                    "descriptionDesignTextModel"     => [
                        "size" => 0
                    ],
                    "paginationDesignBlockModel"     => [
                        "marginTop" => 0
                    ],
                    "paginationItemDesignBlockModel" => [
                        "marginTop" => 0
                    ],
                    "paginationItemDesignTextModel"  => [
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
                    "containerDesignBlockModel"      => [
                        "marginTop"                => 10,
                        "borderBottomWidth"        => 7,
                        "borderColorHover"         => "rgb(0,255,0)",
                        "backgroundColorFromHover" => "rgba(255,0,255,0.5)",
                    ],
                    "titleDesignBlockModel"          => [
                        "marginTop"                => 10,
                        "borderBottomWidth"        => 7,
                        "borderColorHover"         => "rgb(0,255,0)",
                        "backgroundColorFromHover" => "rgba(255,0,255,0.5)",
                    ],
                    "titleDesignTextModel"           => [
                        "size" => 10
                    ],
                    "descriptionDesignBlockModel"    => [
                        "marginTop"                => 10,
                        "borderBottomWidth"        => 7,
                        "borderColorHover"         => "rgb(0,255,0)",
                        "backgroundColorFromHover" => "rgba(255,0,255,0.5)",
                    ],
                    "descriptionDesignTextModel"     => [
                        "size" => 10
                    ],
                    "paginationDesignBlockModel"     => [
                        "marginTop"                => 10,
                        "borderBottomWidth"        => 7,
                        "borderColorHover"         => "rgb(0,255,0)",
                        "backgroundColorFromHover" => "rgba(255,0,255,0.5)",
                    ],
                    "paginationItemDesignBlockModel" => [
                        "marginTop"                => 10,
                        "borderBottomWidth"        => 7,
                        "borderColorHover"         => "rgb(0,255,0)",
                        "backgroundColorFromHover" => "rgba(255,0,255,0.5)",
                    ],
                    "paginationItemDesignTextModel"  => [
                        "size" => 10
                    ],
                ],
                [
                    "containerDesignBlockModel"      => [
                        "marginTop"                => 10,
                        "borderBottomWidth"        => 7,
                        "borderColorHover"         => "rgb(0,255,0)",
                        "backgroundColorFromHover" => "rgba(255,0,255,0.5)",
                    ],
                    "titleDesignBlockModel"          => [
                        "marginTop"                => 10,
                        "borderBottomWidth"        => 7,
                        "borderColorHover"         => "rgb(0,255,0)",
                        "backgroundColorFromHover" => "rgba(255,0,255,0.5)",
                    ],
                    "titleDesignTextModel"           => [
                        "size" => 10
                    ],
                    "descriptionDesignBlockModel"    => [
                        "marginTop"                => 10,
                        "borderBottomWidth"        => 7,
                        "borderColorHover"         => "rgb(0,255,0)",
                        "backgroundColorFromHover" => "rgba(255,0,255,0.5)",
                    ],
                    "descriptionDesignTextModel"     => [
                        "size" => 10
                    ],
                    "paginationDesignBlockModel"     => [
                        "marginTop"                => 10,
                        "borderBottomWidth"        => 7,
                        "borderColorHover"         => "rgb(0,255,0)",
                        "backgroundColorFromHover" => "rgba(255,0,255,0.5)",
                    ],
                    "paginationItemDesignBlockModel" => [
                        "marginTop"                => 10,
                        "borderBottomWidth"        => 7,
                        "borderColorHover"         => "rgb(0,255,0)",
                        "backgroundColorFromHover" => "rgba(255,0,255,0.5)",
                    ],
                    "paginationItemDesignTextModel"  => [
                        "size" => 10
                    ],
                ],
                [
                    "containerDesignBlockModel"      => [
                        "marginTop"                => 5,
                        "borderBottomWidth"        => 4,
                        "borderColorHover"         => "rgb(255,0,0)",
                        "backgroundColorFromHover" => "rgba(0,0,255,0.7)",
                    ],
                    "titleDesignBlockModel"          => [
                        "marginTop"                => 5,
                        "borderBottomWidth"        => 4,
                        "borderColorHover"         => "rgb(255,0,0)",
                        "backgroundColorFromHover" => "rgba(0,0,255,0.7)",
                    ],
                    "titleDesignTextModel"           => [
                        "size" => 20
                    ],
                    "descriptionDesignBlockModel"    => [
                        "marginTop"                => 5,
                        "borderBottomWidth"        => 4,
                        "borderColorHover"         => "rgb(255,0,0)",
                        "backgroundColorFromHover" => "rgba(0,0,255,0.7)",
                    ],
                    "descriptionDesignTextModel"     => [
                        "size" => 20
                    ],
                    "paginationDesignBlockModel"     => [
                        "marginTop"                => 5,
                        "borderBottomWidth"        => 4,
                        "borderColorHover"         => "rgb(255,0,0)",
                        "backgroundColorFromHover" => "rgba(0,0,255,0.7)",
                    ],
                    "paginationItemDesignBlockModel" => [
                        "marginTop"                => 5,
                        "borderBottomWidth"        => 4,
                        "borderColorHover"         => "rgb(255,0,0)",
                        "backgroundColorFromHover" => "rgba(0,0,255,0.7)",
                    ],
                    "paginationItemDesignTextModel"  => [
                        "size" => 20
                    ],
                ],
                [
                    "containerDesignBlockModel"      => [
                        "marginTop"                => 5,
                        "borderBottomWidth"        => 4,
                        "borderColorHover"         => "rgb(255,0,0)",
                        "backgroundColorFromHover" => "rgba(0,0,255,0.7)",
                    ],
                    "titleDesignBlockModel"          => [
                        "marginTop"                => 5,
                        "borderBottomWidth"        => 4,
                        "borderColorHover"         => "rgb(255,0,0)",
                        "backgroundColorFromHover" => "rgba(0,0,255,0.7)",
                    ],
                    "titleDesignTextModel"           => [
                        "size" => 20
                    ],
                    "descriptionDesignBlockModel"    => [
                        "marginTop"                => 5,
                        "borderBottomWidth"        => 4,
                        "borderColorHover"         => "rgb(255,0,0)",
                        "backgroundColorFromHover" => "rgba(0,0,255,0.7)",
                    ],
                    "descriptionDesignTextModel"     => [
                        "size" => 20
                    ],
                    "paginationDesignBlockModel"     => [
                        "marginTop"                => 5,
                        "borderBottomWidth"        => 4,
                        "borderColorHover"         => "rgb(255,0,0)",
                        "backgroundColorFromHover" => "rgba(0,0,255,0.7)",
                    ],
                    "paginationItemDesignBlockModel" => [
                        "marginTop"                => 5,
                        "borderBottomWidth"        => 4,
                        "borderColorHover"         => "rgb(255,0,0)",
                        "backgroundColorFromHover" => "rgba(0,0,255,0.7)",
                    ],
                    "paginationItemDesignTextModel"  => [
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
                    "containerDesignBlockModel"      => "incorrect",
                    "titleDesignBlockModel"          => "incorrect",
                    "titleDesignTextModel"           => "incorrect",
                    "descriptionDesignBlockModel"    => "incorrect",
                    "descriptionDesignTextModel"     => "incorrect",
                    "paginationDesignBlockModel"     => "incorrect",
                    "paginationItemDesignBlockModel" => "incorrect",
                    "paginationItemDesignTextModel"  => "incorrect",
                ],
                [
                    "containerDesignBlockModel"      => [
                        "marginTop" => 0
                    ],
                    "titleDesignBlockModel"          => [
                        "marginTop" => 0
                    ],
                    "titleDesignTextModel"           => [
                        "size" => 0
                    ],
                    "descriptionDesignBlockModel"    => [
                        "marginTop" => 0
                    ],
                    "descriptionDesignTextModel"     => [
                        "size" => 0
                    ],
                    "paginationDesignBlockModel"     => [
                        "marginTop" => 0
                    ],
                    "paginationItemDesignBlockModel" => [
                        "marginTop" => 0
                    ],
                    "paginationItemDesignTextModel"  => [
                        "size" => 0
                    ],
                ],
                [
                    "containerDesignBlockModel"      => [
                        "marginTop" => " 500d "
                    ],
                    "titleDesignBlockModel"          => [
                        "marginTop" => "500d "
                    ],
                    "titleDesignTextModel"           => [
                        "size" => "500d "
                    ],
                    "descriptionDesignBlockModel"    => [
                        "marginTop" => "500d "
                    ],
                    "descriptionDesignTextModel"     => [
                        "size" => "500d "
                    ],
                    "paginationDesignBlockModel"     => [
                        "marginTop" => "500d "
                    ],
                    "paginationItemDesignBlockModel" => [
                        "marginTop" => "500d "
                    ],
                    "paginationItemDesignTextModel"  => [
                        "size" => "500d "
                    ],
                ],
                [
                    "containerDesignBlockModel"      => [
                        "marginTop" => 500
                    ],
                    "titleDesignBlockModel"          => [
                        "marginTop" => 500
                    ],
                    "titleDesignTextModel"           => [
                        "size" => 500
                    ],
                    "descriptionDesignBlockModel"    => [
                        "marginTop" => 500
                    ],
                    "descriptionDesignTextModel"     => [
                        "size" => 500
                    ],
                    "paginationDesignBlockModel"     => [
                        "marginTop" => 500
                    ],
                    "paginationItemDesignBlockModel" => [
                        "marginTop" => 500
                    ],
                    "paginationItemDesignTextModel"  => [
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
                "containerDesignBlockModel"      => [
                    "marginTop"                => 10,
                    "borderBottomWidth"        => 7,
                    "borderColorHover"         => "rgb(0,255,0)",
                    "backgroundColorFromHover" => "rgba(255,0,255,0.5)",
                ],
                "titleDesignBlockModel"          => [
                    "marginTop"                => 10,
                    "borderBottomWidth"        => 7,
                    "borderColorHover"         => "rgb(0,255,0)",
                    "backgroundColorFromHover" => "rgba(255,0,255,0.5)",
                ],
                "titleDesignTextModel"           => [
                    "size" => 10
                ],
                "descriptionDesignBlockModel"    => [
                    "marginTop"                => 10,
                    "borderBottomWidth"        => 7,
                    "borderColorHover"         => "rgb(0,255,0)",
                    "backgroundColorFromHover" => "rgba(255,0,255,0.5)",
                ],
                "descriptionDesignTextModel"     => [
                    "size" => 10
                ],
                "paginationDesignBlockModel"     => [
                    "marginTop"                => 10,
                    "borderBottomWidth"        => 7,
                    "borderColorHover"         => "rgb(0,255,0)",
                    "backgroundColorFromHover" => "rgba(255,0,255,0.5)",
                ],
                "paginationItemDesignBlockModel" => [
                    "marginTop"                => 10,
                    "borderBottomWidth"        => 7,
                    "borderColorHover"         => "rgb(0,255,0)",
                    "backgroundColorFromHover" => "rgba(255,0,255,0.5)",
                ],
                "paginationItemDesignTextModel"  => [
                    "size" => 10
                ],
            ],
            [
                "containerDesignBlockModel"      => [
                    "marginTop"                => 10,
                    "borderBottomWidth"        => 7,
                    "borderColorHover"         => "rgb(0,255,0)",
                    "backgroundColorFromHover" => "rgba(255,0,255,0.5)",
                ],
                "titleDesignBlockModel"          => [
                    "marginTop"                => 10,
                    "borderBottomWidth"        => 7,
                    "borderColorHover"         => "rgb(0,255,0)",
                    "backgroundColorFromHover" => "rgba(255,0,255,0.5)",
                ],
                "titleDesignTextModel"           => [
                    "size" => 10
                ],
                "descriptionDesignBlockModel"    => [
                    "marginTop"                => 10,
                    "borderBottomWidth"        => 7,
                    "borderColorHover"         => "rgb(0,255,0)",
                    "backgroundColorFromHover" => "rgba(255,0,255,0.5)",
                ],
                "descriptionDesignTextModel"     => [
                    "size" => 10
                ],
                "paginationDesignBlockModel"     => [
                    "marginTop"                => 10,
                    "borderBottomWidth"        => 7,
                    "borderColorHover"         => "rgb(0,255,0)",
                    "backgroundColorFromHover" => "rgba(255,0,255,0.5)",
                ],
                "paginationItemDesignBlockModel" => [
                    "marginTop"                => 10,
                    "borderBottomWidth"        => 7,
                    "borderColorHover"         => "rgb(0,255,0)",
                    "backgroundColorFromHover" => "rgba(255,0,255,0.5)",
                ],
                "paginationItemDesignTextModel"  => [
                    "size" => 10
                ],
            ]
        );
    }
}