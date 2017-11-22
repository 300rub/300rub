<?php

namespace testS\tests\unit\models;

use testS\models\DesignImageSimpleModel;

/**
 * Tests for the model DesignImageSimpleModel
 *
 * @package testS\tests\unit\models
 */
class DesignImageSimpleModelTest extends AbstractModelTest
{

    /**
     * Gets model name
     *
     * @return DesignImageSimpleModel
     */
    protected function getNewModel()
    {
        return new DesignImageSimpleModel();
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
                    "imageDesignBlockModel"     => [
                        "marginTop" => 0
                    ],
                    "alignment"                 => 0
                ],
                [
                    "containerDesignBlockModel" => "",
                    "imageDesignBlockModel"     => "",
                    "alignment"                 => "",
                ],
                [
                    "containerDesignBlockModel" => [
                        "marginTop" => 0
                    ],
                    "imageDesignBlockModel"     => [
                        "marginTop" => 0
                    ],
                    "alignment"                 => 0
                ],
            ],
            "empty2" => [
                [
                    "containerDesignBlockModel" => null,
                    "imageDesignBlockModel"     => null,
                    "alignment"                 => null,
                ],
                [
                    "containerDesignBlockModel" => [
                        "marginTop" => 0
                    ],
                    "imageDesignBlockModel"     => [
                        "marginTop" => 0
                    ],
                    "alignment"                 => 0
                ],
                [
                    "containerDesignBlockModel" => " ",
                    "imageDesignBlockModel"     => " ",
                    "alignment"                 => " ",
                ],
                [
                    "containerDesignBlockModel" => [
                        "marginTop" => 0
                    ],
                    "imageDesignBlockModel"     => [
                        "marginTop" => 0
                    ],
                    "alignment"                 => 0
                ],
            ],
            "empty3" => [
                [
                    "containerDesignBlockId" => " ",
                    "imageDesignBlockId"     => " ",
                    "alignment"              => " ",
                ],
                [
                    "containerDesignBlockModel" => [
                        "marginTop" => 0
                    ],
                    "imageDesignBlockModel"     => [
                        "marginTop" => 0
                    ],
                    "alignment"                 => 0
                ],
                [
                    "containerDesignBlockId" => null,
                    "imageDesignBlockId"     => null,
                    "alignment"              => null,
                ],
                [
                    "containerDesignBlockModel" => [
                        "marginTop" => 0
                    ],
                    "imageDesignBlockModel"     => [
                        "marginTop" => 0
                    ],
                    "alignment"                 => 0
                ],
            ],
            "empty4" => [
                [
                    "containerDesignBlockModel" => [
                        "marginTop" => " "
                    ],
                    "imageDesignBlockModel"     => [
                        "marginTop" => " "
                    ],
                ],
                [
                    "containerDesignBlockModel" => [
                        "marginTop" => 0
                    ],
                    "imageDesignBlockModel"     => [
                        "marginTop" => 0
                    ],
                    "alignment"                 => 0
                ],
                [
                    "containerDesignBlockModel" => [],
                    "imageDesignBlockModel"     => [],
                ],
                [
                    "containerDesignBlockModel" => [
                        "marginTop" => 0
                    ],
                    "imageDesignBlockModel"     => [
                        "marginTop" => 0
                    ],
                    "alignment"                 => 0
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
                    "imageDesignBlockModel"     => [
                        "marginTop"                => 10,
                        "borderBottomWidth"        => 7,
                        "borderColorHover"         => "rgb(0,255,0)",
                        "backgroundColorFromHover" => "rgba(255,0,255,0.5)",
                    ],
                    "alignment"                 => 1
                ],
                [
                    "containerDesignBlockModel" => [
                        "marginTop"                => 10,
                        "borderBottomWidth"        => 7,
                        "borderColorHover"         => "rgb(0,255,0)",
                        "backgroundColorFromHover" => "rgba(255,0,255,0.5)",
                    ],
                    "imageDesignBlockModel"     => [
                        "marginTop"                => 10,
                        "borderBottomWidth"        => 7,
                        "borderColorHover"         => "rgb(0,255,0)",
                        "backgroundColorFromHover" => "rgba(255,0,255,0.5)",
                    ],
                    "alignment"                 => 1
                ],
                [
                    "containerDesignBlockModel" => [
                        "marginTop"                => 5,
                        "borderBottomWidth"        => 4,
                        "borderColorHover"         => "rgb(255,0,0)",
                        "backgroundColorFromHover" => "rgba(0,0,255,0.7)",
                    ],
                    "imageDesignBlockModel"     => [
                        "marginTop"                => 5,
                        "borderBottomWidth"        => 4,
                        "borderColorHover"         => "rgb(255,0,0)",
                        "backgroundColorFromHover" => "rgba(0,0,255,0.7)",
                    ],
                    "alignment"                 => 2
                ],
                [
                    "containerDesignBlockModel" => [
                        "marginTop"                => 5,
                        "borderBottomWidth"        => 4,
                        "borderColorHover"         => "rgb(255,0,0)",
                        "backgroundColorFromHover" => "rgba(0,0,255,0.7)",
                    ],
                    "imageDesignBlockModel"     => [
                        "marginTop"                => 5,
                        "borderBottomWidth"        => 4,
                        "borderColorHover"         => "rgb(255,0,0)",
                        "backgroundColorFromHover" => "rgba(0,0,255,0.7)",
                    ],
                    "alignment"                 => 2
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
                    "imageDesignBlockModel"     => "incorrect",
                    "alignment"                 => "incorrect",
                ],
                [
                    "containerDesignBlockModel" => [
                        "marginTop" => 0
                    ],
                    "imageDesignBlockModel"     => [
                        "marginTop" => 0
                    ],
                    "alignment"                 => 0
                ],
                [
                    "alignment" => 999,
                ],
                [
                    "alignment" => 0,
                ],
            ],
            "incorrect2" => [
                [
                    "alignment" => " 1 ",
                ],
                [
                    "alignment" => 1,
                ],
                [
                    "containerDesignBlockModel" => [
                        "marginTop" => " 500 "
                    ],
                    "alignment"                 => true,
                ],
                [
                    "containerDesignBlockModel" => [
                        "marginTop" => 500
                    ],
                    "alignment"                 => 1,
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
                "imageDesignBlockModel"     => [
                    "marginTop"                => 10,
                    "borderBottomWidth"        => 7,
                    "borderColorHover"         => "rgb(0,255,0)",
                    "backgroundColorFromHover" => "rgba(255,0,255,0.5)",
                ],
                "alignment"                 => 1
            ],
            [
                "containerDesignBlockModel" => [
                    "marginTop"                => 10,
                    "borderBottomWidth"        => 7,
                    "borderColorHover"         => "rgb(0,255,0)",
                    "backgroundColorFromHover" => "rgba(255,0,255,0.5)",
                ],
                "imageDesignBlockModel"     => [
                    "marginTop"                => 10,
                    "borderBottomWidth"        => 7,
                    "borderColorHover"         => "rgb(0,255,0)",
                    "backgroundColorFromHover" => "rgba(255,0,255,0.5)",
                ],
                "alignment"                 => 1
            ]
        );
    }
}