<?php

namespace testS\tests\unit\models;

use testS\models\DesignTabModel;

/**
 * Tests for the model DesignTabModel
 *
 * @package testS\tests\unit\models
 */
class DesignTabModelTest extends AbstractModelTest
{

    /**
     * Gets model name
     *
     * @return DesignTabModel
     */
    protected function getNewModel()
    {
        return new DesignTabModel();
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
                [
                    "containerDesignBlockModel" => "",
                    "tabDesignBlockModel"       => "",
                    "tabDesignTextModel"        => "",
                    "contentDesignBlockModel"   => "",
                ],
                [
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
            ],
            "empty2" => [
                [
                    "containerDesignBlockModel" => null,
                    "tabDesignBlockModel"       => null,
                    "tabDesignTextModel"        => null,
                    "contentDesignBlockModel"   => null,
                ],
                [
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
                [
                    "containerDesignBlockModel" => " ",
                    "tabDesignBlockModel"       => " ",
                    "tabDesignTextModel"        => " ",
                    "contentDesignBlockModel"   => " ",
                ],
                [
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
            ],
            "empty3" => [
                [
                    "containerDesignBlockId" => " ",
                    "tabDesignBlockId"       => " ",
                    "tabDesignTextId"        => " ",
                    "contentDesignBlockId"   => " ",
                ],
                [
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
                [
                    "containerDesignBlockId" => null,
                    "tabDesignBlockId"       => null,
                    "tabDesignTextId"        => null,
                    "contentDesignBlockId"   => null,
                ],
                [
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
            ],
            "empty4" => [
                [
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
                [
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
                [
                    "containerDesignBlockModel" => [],
                    "tabDesignBlockModel"       => [],
                    "tabDesignTextModel"        => [],
                    "contentDesignBlockModel"   => [],
                ],
                [
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
                        "size" => 10
                    ],
                    "contentDesignBlockModel"   => [
                        "marginTop"                => 10,
                        "borderBottomWidth"        => 7,
                        "borderColorHover"         => "rgb(0,255,0)",
                        "backgroundColorFromHover" => "rgba(255,0,255,0.5)",
                    ],
                ],
                [
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
                        "size" => 10
                    ],
                    "contentDesignBlockModel"   => [
                        "marginTop"                => 10,
                        "borderBottomWidth"        => 7,
                        "borderColorHover"         => "rgb(0,255,0)",
                        "backgroundColorFromHover" => "rgba(255,0,255,0.5)",
                    ],
                ],
                [
                    "containerDesignBlockModel" => [
                        "marginTop"                => 5,
                        "borderBottomWidth"        => 4,
                        "borderColorHover"         => "rgb(255,0,0)",
                        "backgroundColorFromHover" => "rgba(0,0,255,0.7)",
                    ],
                    "tabDesignBlockModel"       => [
                        "marginTop"                => 5,
                        "borderBottomWidth"        => 4,
                        "borderColorHover"         => "rgb(255,0,0)",
                        "backgroundColorFromHover" => "rgba(0,0,255,0.7)",
                    ],
                    "tabDesignTextModel"        => [
                        "size" => 20
                    ],
                    "contentDesignBlockModel"   => [
                        "marginTop"                => 5,
                        "borderBottomWidth"        => 4,
                        "borderColorHover"         => "rgb(255,0,0)",
                        "backgroundColorFromHover" => "rgba(0,0,255,0.7)",
                    ],
                ],
                [
                    "containerDesignBlockModel" => [
                        "marginTop"                => 5,
                        "borderBottomWidth"        => 4,
                        "borderColorHover"         => "rgb(255,0,0)",
                        "backgroundColorFromHover" => "rgba(0,0,255,0.7)",
                    ],
                    "tabDesignBlockModel"       => [
                        "marginTop"                => 5,
                        "borderBottomWidth"        => 4,
                        "borderColorHover"         => "rgb(255,0,0)",
                        "backgroundColorFromHover" => "rgba(0,0,255,0.7)",
                    ],
                    "tabDesignTextModel"        => [
                        "size" => 20
                    ],
                    "contentDesignBlockModel"   => [
                        "marginTop"                => 5,
                        "borderBottomWidth"        => 4,
                        "borderColorHover"         => "rgb(255,0,0)",
                        "backgroundColorFromHover" => "rgba(0,0,255,0.7)",
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
                    "containerDesignBlockModel" => "incorrect",
                    "tabDesignBlockModel"       => "incorrect",
                    "tabDesignTextModel"        => "incorrect",
                    "contentDesignBlockModel"   => "incorrect",
                ],
                [
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
                [
                    "containerDesignBlockModel" => [
                        "marginTop" => " 500 "
                    ],
                    "tabDesignBlockModel"       => [
                        "marginTop" => " 500 "
                    ],
                    "tabDesignTextModel"        => [
                        "size" => " 500 "
                    ],
                    "contentDesignBlockModel"   => [
                        "marginTop" => " 500 "
                    ],
                ],
                [
                    "containerDesignBlockModel" => [
                        "marginTop" => 500
                    ],
                    "tabDesignBlockModel"       => [
                        "marginTop" => 500
                    ],
                    "tabDesignTextModel"        => [
                        "size" => 500
                    ],
                    "contentDesignBlockModel"   => [
                        "marginTop" => 500
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
                    "size" => 10
                ],
                "contentDesignBlockModel"   => [
                    "marginTop"                => 10,
                    "borderBottomWidth"        => 7,
                    "borderColorHover"         => "rgb(0,255,0)",
                    "backgroundColorFromHover" => "rgba(255,0,255,0.5)",
                ],
            ],
            [
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
                    "size" => 10
                ],
                "contentDesignBlockModel"   => [
                    "marginTop"                => 10,
                    "borderBottomWidth"        => 7,
                    "borderColorHover"         => "rgb(0,255,0)",
                    "backgroundColorFromHover" => "rgba(255,0,255,0.5)",
                ],
            ]
        );
    }
}