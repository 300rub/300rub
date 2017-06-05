<?php

namespace testS\tests\unit\models;

use testS\models\DesignFieldModel;

/**
 * Tests for the model DesignFieldModel
 *
 * @package testS\tests\unit\models
 */
class DesignFieldModelTest extends AbstractModelTest
{

    /**
     * Gets model name
     *
     * @return DesignFieldModel
     */
    protected function getNewModel()
    {
        return new DesignFieldModel();
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
                    "shortCardContainerDesignBlockModel" => [
                        "marginTop" => 0
                    ],
                    "shortCardLabelDesignBlockModel"     => [
                        "marginTop" => 0
                    ],
                    "shortCardLabelDesignTextModel"      => [
                        "size" => 0
                    ],
                    "shortCardValueDesignBlockModel"     => [
                        "marginTop" => 0
                    ],
                    "shortCardValueDesignTextModel"      => [
                        "size" => 0
                    ],
                    "fullCardContainerDesignBlockModel"  => [
                        "marginTop" => 0
                    ],
                    "fullCardLabelDesignBlockModel"      => [
                        "marginTop" => 0
                    ],
                    "fullCardLabelDesignTextModel"       => [
                        "size" => 0
                    ],
                    "fullCardValueDesignBlockModel"      => [
                        "marginTop" => 0
                    ],
                    "fullCardValueDesignTextModel"       => [
                        "size" => 0
                    ],
                ],
                [
                    "shortCardContainerDesignBlockModel" => "",
                    "shortCardLabelDesignBlockModel"     => "",
                    "shortCardLabelDesignTextModel"      => "",
                    "shortCardValueDesignBlockModel"     => "",
                    "shortCardValueDesignTextModel"      => "",
                    "fullCardContainerDesignBlockModel"  => "",
                    "fullCardLabelDesignBlockModel"      => "",
                    "fullCardLabelDesignTextModel"       => "",
                    "fullCardValueDesignBlockModel"      => "",
                    "fullCardValueDesignTextModel"       => "",
                ],
                [
                    "shortCardContainerDesignBlockModel" => [
                        "marginTop" => 0
                    ],
                    "shortCardLabelDesignBlockModel"     => [
                        "marginTop" => 0
                    ],
                    "shortCardLabelDesignTextModel"      => [
                        "size" => 0
                    ],
                    "shortCardValueDesignBlockModel"     => [
                        "marginTop" => 0
                    ],
                    "shortCardValueDesignTextModel"      => [
                        "size" => 0
                    ],
                    "fullCardContainerDesignBlockModel"  => [
                        "marginTop" => 0
                    ],
                    "fullCardLabelDesignBlockModel"      => [
                        "marginTop" => 0
                    ],
                    "fullCardLabelDesignTextModel"       => [
                        "size" => 0
                    ],
                    "fullCardValueDesignBlockModel"      => [
                        "marginTop" => 0
                    ],
                    "fullCardValueDesignTextModel"       => [
                        "size" => 0
                    ],
                ],
            ],
            "empty2" => [
                [
                    "shortCardContainerDesignBlockModel" => null,
                    "shortCardLabelDesignBlockModel"     => null,
                    "shortCardLabelDesignTextModel"      => null,
                    "shortCardValueDesignBlockModel"     => null,
                    "shortCardValueDesignTextModel"      => null,
                    "fullCardContainerDesignBlockModel"  => null,
                    "fullCardLabelDesignBlockModel"      => null,
                    "fullCardLabelDesignTextModel"       => null,
                    "fullCardValueDesignBlockModel"      => null,
                    "fullCardValueDesignTextModel"       => null,
                ],
                [
                    "shortCardContainerDesignBlockModel" => [
                        "marginTop" => 0
                    ],
                    "shortCardLabelDesignBlockModel"     => [
                        "marginTop" => 0
                    ],
                    "shortCardLabelDesignTextModel"      => [
                        "size" => 0
                    ],
                    "shortCardValueDesignBlockModel"     => [
                        "marginTop" => 0
                    ],
                    "shortCardValueDesignTextModel"      => [
                        "size" => 0
                    ],
                    "fullCardContainerDesignBlockModel"  => [
                        "marginTop" => 0
                    ],
                    "fullCardLabelDesignBlockModel"      => [
                        "marginTop" => 0
                    ],
                    "fullCardLabelDesignTextModel"       => [
                        "size" => 0
                    ],
                    "fullCardValueDesignBlockModel"      => [
                        "marginTop" => 0
                    ],
                    "fullCardValueDesignTextModel"       => [
                        "size" => 0
                    ],
                ],
                [
                    "shortCardContainerDesignBlockModel" => " ",
                    "shortCardLabelDesignBlockModel"     => " ",
                    "shortCardLabelDesignTextModel"      => " ",
                    "shortCardValueDesignBlockModel"     => " ",
                    "shortCardValueDesignTextModel"      => " ",
                    "fullCardContainerDesignBlockModel"  => " ",
                    "fullCardLabelDesignBlockModel"      => " ",
                    "fullCardLabelDesignTextModel"       => " ",
                    "fullCardValueDesignBlockModel"      => " ",
                    "fullCardValueDesignTextModel"       => " ",
                ],
                [
                    "shortCardContainerDesignBlockModel" => [
                        "marginTop" => 0
                    ],
                    "shortCardLabelDesignBlockModel"     => [
                        "marginTop" => 0
                    ],
                    "shortCardLabelDesignTextModel"      => [
                        "size" => 0
                    ],
                    "shortCardValueDesignBlockModel"     => [
                        "marginTop" => 0
                    ],
                    "shortCardValueDesignTextModel"      => [
                        "size" => 0
                    ],
                    "fullCardContainerDesignBlockModel"  => [
                        "marginTop" => 0
                    ],
                    "fullCardLabelDesignBlockModel"      => [
                        "marginTop" => 0
                    ],
                    "fullCardLabelDesignTextModel"       => [
                        "size" => 0
                    ],
                    "fullCardValueDesignBlockModel"      => [
                        "marginTop" => 0
                    ],
                    "fullCardValueDesignTextModel"       => [
                        "size" => 0
                    ],
                ],
            ],
            "empty3" => [
                [
                    "shortCardContainerDesignBlockId" => " ",
                    "shortCardLabelDesignBlockId"     => " ",
                    "shortCardLabelDesignTextId"      => " ",
                    "shortCardValueDesignBlockId"     => " ",
                    "shortCardValueDesignTextId"      => " ",
                    "fullCardContainerDesignBlockId"  => " ",
                    "fullCardLabelDesignBlockId"      => " ",
                    "fullCardLabelDesignTextId"       => " ",
                    "fullCardValueDesignBlockId"      => " ",
                    "fullCardValueDesignTextId"       => " ",
                ],
                [
                    "shortCardContainerDesignBlockModel" => [
                        "marginTop" => 0
                    ],
                    "shortCardLabelDesignBlockModel"     => [
                        "marginTop" => 0
                    ],
                    "shortCardLabelDesignTextModel"      => [
                        "size" => 0
                    ],
                    "shortCardValueDesignBlockModel"     => [
                        "marginTop" => 0
                    ],
                    "shortCardValueDesignTextModel"      => [
                        "size" => 0
                    ],
                    "fullCardContainerDesignBlockModel"  => [
                        "marginTop" => 0
                    ],
                    "fullCardLabelDesignBlockModel"      => [
                        "marginTop" => 0
                    ],
                    "fullCardLabelDesignTextModel"       => [
                        "size" => 0
                    ],
                    "fullCardValueDesignBlockModel"      => [
                        "marginTop" => 0
                    ],
                    "fullCardValueDesignTextModel"       => [
                        "size" => 0
                    ],
                ],
                [
                    "shortCardContainerDesignBlockId" => null,
                    "shortCardLabelDesignBlockId"     => null,
                    "shortCardLabelDesignTextId"      => null,
                    "shortCardValueDesignBlockId"     => null,
                    "shortCardValueDesignTextId"      => null,
                    "fullCardContainerDesignBlockId"  => null,
                    "fullCardLabelDesignBlockId"      => null,
                    "fullCardLabelDesignTextId"       => null,
                    "fullCardValueDesignBlockId"      => null,
                    "fullCardValueDesignTextId"       => null,
                ],
                [
                    "shortCardContainerDesignBlockModel" => [
                        "marginTop" => 0
                    ],
                    "shortCardLabelDesignBlockModel"     => [
                        "marginTop" => 0
                    ],
                    "shortCardLabelDesignTextModel"      => [
                        "size" => 0
                    ],
                    "shortCardValueDesignBlockModel"     => [
                        "marginTop" => 0
                    ],
                    "shortCardValueDesignTextModel"      => [
                        "size" => 0
                    ],
                    "fullCardContainerDesignBlockModel"  => [
                        "marginTop" => 0
                    ],
                    "fullCardLabelDesignBlockModel"      => [
                        "marginTop" => 0
                    ],
                    "fullCardLabelDesignTextModel"       => [
                        "size" => 0
                    ],
                    "fullCardValueDesignBlockModel"      => [
                        "marginTop" => 0
                    ],
                    "fullCardValueDesignTextModel"       => [
                        "size" => 0
                    ],
                ],
            ],
            "empty4" => [
                [
                    "shortCardContainerDesignBlockModel" => [
                        "marginTop" => " "
                    ],
                    "shortCardLabelDesignBlockModel"     => [
                        "marginTop" => " "
                    ],
                    "shortCardLabelDesignTextModel"      => [
                        "size" => " "
                    ],
                    "shortCardValueDesignBlockModel"     => [
                        "marginTop" => " "
                    ],
                    "shortCardValueDesignTextModel"      => [
                        "size" => " "
                    ],
                    "fullCardContainerDesignBlockModel"  => [
                        "marginTop" => " "
                    ],
                    "fullCardLabelDesignBlockModel"      => [
                        "marginTop" => " "
                    ],
                    "fullCardLabelDesignTextModel"       => [
                        "size" => " "
                    ],
                    "fullCardValueDesignBlockModel"      => [
                        "marginTop" => " "
                    ],
                    "fullCardValueDesignTextModel"       => [
                        "size" => " "
                    ],
                ],
                [
                    "shortCardContainerDesignBlockModel" => [
                        "marginTop" => 0
                    ],
                    "shortCardLabelDesignBlockModel"     => [
                        "marginTop" => 0
                    ],
                    "shortCardLabelDesignTextModel"      => [
                        "size" => 0
                    ],
                    "shortCardValueDesignBlockModel"     => [
                        "marginTop" => 0
                    ],
                    "shortCardValueDesignTextModel"      => [
                        "size" => 0
                    ],
                    "fullCardContainerDesignBlockModel"  => [
                        "marginTop" => 0
                    ],
                    "fullCardLabelDesignBlockModel"      => [
                        "marginTop" => 0
                    ],
                    "fullCardLabelDesignTextModel"       => [
                        "size" => 0
                    ],
                    "fullCardValueDesignBlockModel"      => [
                        "marginTop" => 0
                    ],
                    "fullCardValueDesignTextModel"       => [
                        "size" => 0
                    ],
                ],
                [
                    "shortCardContainerDesignBlockModel" => [],
                    "shortCardLabelDesignBlockModel"     => [],
                    "shortCardLabelDesignTextModel"      => [],
                    "shortCardValueDesignBlockModel"     => [],
                    "shortCardValueDesignTextModel"      => [],
                    "fullCardContainerDesignBlockModel"  => [],
                    "fullCardLabelDesignBlockModel"      => [],
                    "fullCardLabelDesignTextModel"       => [],
                    "fullCardValueDesignBlockModel"      => [],
                    "fullCardValueDesignTextModel"       => [],
                ],
                [
                    "shortCardContainerDesignBlockModel" => [
                        "marginTop" => 0
                    ],
                    "shortCardLabelDesignBlockModel"     => [
                        "marginTop" => 0
                    ],
                    "shortCardLabelDesignTextModel"      => [
                        "size" => 0
                    ],
                    "shortCardValueDesignBlockModel"     => [
                        "marginTop" => 0
                    ],
                    "shortCardValueDesignTextModel"      => [
                        "size" => 0
                    ],
                    "fullCardContainerDesignBlockModel"  => [
                        "marginTop" => 0
                    ],
                    "fullCardLabelDesignBlockModel"      => [
                        "marginTop" => 0
                    ],
                    "fullCardLabelDesignTextModel"       => [
                        "size" => 0
                    ],
                    "fullCardValueDesignBlockModel"      => [
                        "marginTop" => 0
                    ],
                    "fullCardValueDesignTextModel"       => [
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
                    "shortCardContainerDesignBlockModel" => [
                        "marginTop"                => 10,
                        "borderBottomWidth"        => 7,
                        "borderColorHover"         => "rgb(0,255,0)",
                        "backgroundColorFromHover" => "rgba(255,0,255,0.5)",
                    ],
                    "shortCardLabelDesignBlockModel"     => [
                        "marginTop"                => 10,
                        "borderBottomWidth"        => 7,
                        "borderColorHover"         => "rgb(0,255,0)",
                        "backgroundColorFromHover" => "rgba(255,0,255,0.5)",
                    ],
                    "shortCardLabelDesignTextModel"      => [
                        "size" => 10
                    ],
                    "shortCardValueDesignBlockModel"     => [
                        "marginTop"                => 10,
                        "borderBottomWidth"        => 7,
                        "borderColorHover"         => "rgb(0,255,0)",
                        "backgroundColorFromHover" => "rgba(255,0,255,0.5)",
                    ],
                    "shortCardValueDesignTextModel"      => [
                        "size" => 10
                    ],
                    "fullCardContainerDesignBlockModel"  => [
                        "marginTop"                => 10,
                        "borderBottomWidth"        => 7,
                        "borderColorHover"         => "rgb(0,255,0)",
                        "backgroundColorFromHover" => "rgba(255,0,255,0.5)",
                    ],
                    "fullCardLabelDesignBlockModel"      => [
                        "marginTop"                => 10,
                        "borderBottomWidth"        => 7,
                        "borderColorHover"         => "rgb(0,255,0)",
                        "backgroundColorFromHover" => "rgba(255,0,255,0.5)",
                    ],
                    "fullCardLabelDesignTextModel"       => [
                        "size" => 10
                    ],
                    "fullCardValueDesignBlockModel"      => [
                        "marginTop"                => 10,
                        "borderBottomWidth"        => 7,
                        "borderColorHover"         => "rgb(0,255,0)",
                        "backgroundColorFromHover" => "rgba(255,0,255,0.5)",
                    ],
                    "fullCardValueDesignTextModel"       => [
                        "size" => 10
                    ],
                ],
                [
                    "shortCardContainerDesignBlockModel" => [
                        "marginTop"                => 10,
                        "borderBottomWidth"        => 7,
                        "borderColorHover"         => "rgb(0,255,0)",
                        "backgroundColorFromHover" => "rgba(255,0,255,0.5)",
                    ],
                    "shortCardLabelDesignBlockModel"     => [
                        "marginTop"                => 10,
                        "borderBottomWidth"        => 7,
                        "borderColorHover"         => "rgb(0,255,0)",
                        "backgroundColorFromHover" => "rgba(255,0,255,0.5)",
                    ],
                    "shortCardLabelDesignTextModel"      => [
                        "size" => 10
                    ],
                    "shortCardValueDesignBlockModel"     => [
                        "marginTop"                => 10,
                        "borderBottomWidth"        => 7,
                        "borderColorHover"         => "rgb(0,255,0)",
                        "backgroundColorFromHover" => "rgba(255,0,255,0.5)",
                    ],
                    "shortCardValueDesignTextModel"      => [
                        "size" => 10
                    ],
                    "fullCardContainerDesignBlockModel"  => [
                        "marginTop"                => 10,
                        "borderBottomWidth"        => 7,
                        "borderColorHover"         => "rgb(0,255,0)",
                        "backgroundColorFromHover" => "rgba(255,0,255,0.5)",
                    ],
                    "fullCardLabelDesignBlockModel"      => [
                        "marginTop"                => 10,
                        "borderBottomWidth"        => 7,
                        "borderColorHover"         => "rgb(0,255,0)",
                        "backgroundColorFromHover" => "rgba(255,0,255,0.5)",
                    ],
                    "fullCardLabelDesignTextModel"       => [
                        "size" => 10
                    ],
                    "fullCardValueDesignBlockModel"      => [
                        "marginTop"                => 10,
                        "borderBottomWidth"        => 7,
                        "borderColorHover"         => "rgb(0,255,0)",
                        "backgroundColorFromHover" => "rgba(255,0,255,0.5)",
                    ],
                    "fullCardValueDesignTextModel"       => [
                        "size" => 10
                    ],
                ],
                [
                    "shortCardContainerDesignBlockModel" => [
                        "marginTop"                => 20,
                        "borderBottomWidth"        => 70,
                        "borderColorHover"         => "rgb(255,255,0)",
                        "backgroundColorFromHover" => "rgba(0,0,255,0.5)",
                    ],
                    "shortCardLabelDesignBlockModel"     => [
                        "marginTop"                => 20,
                        "borderBottomWidth"        => 70,
                        "borderColorHover"         => "rgb(255,255,0)",
                        "backgroundColorFromHover" => "rgba(0,0,255,0.5)",
                    ],
                    "shortCardLabelDesignTextModel"      => [
                        "size" => 30
                    ],
                    "shortCardValueDesignBlockModel"     => [
                        "marginTop"                => 20,
                        "borderBottomWidth"        => 70,
                        "borderColorHover"         => "rgb(255,255,0)",
                        "backgroundColorFromHover" => "rgba(0,0,255,0.5)",
                    ],
                    "shortCardValueDesignTextModel"      => [
                        "size" => 30
                    ],
                    "fullCardContainerDesignBlockModel"  => [
                        "marginTop"                => 20,
                        "borderBottomWidth"        => 70,
                        "borderColorHover"         => "rgb(255,255,0)",
                        "backgroundColorFromHover" => "rgba(0,0,255,0.5)",
                    ],
                    "fullCardLabelDesignBlockModel"      => [
                        "marginTop"                => 20,
                        "borderBottomWidth"        => 70,
                        "borderColorHover"         => "rgb(255,255,0)",
                        "backgroundColorFromHover" => "rgba(0,0,255,0.5)",
                    ],
                    "fullCardLabelDesignTextModel"       => [
                        "size" => 30
                    ],
                    "fullCardValueDesignBlockModel"      => [
                        "marginTop"                => 20,
                        "borderBottomWidth"        => 70,
                        "borderColorHover"         => "rgb(255,255,0)",
                        "backgroundColorFromHover" => "rgba(0,0,255,0.5)",
                    ],
                    "fullCardValueDesignTextModel"       => [
                        "size" => 30
                    ],
                ],
                [
                    "shortCardContainerDesignBlockModel" => [
                        "marginTop"                => 20,
                        "borderBottomWidth"        => 70,
                        "borderColorHover"         => "rgb(255,255,0)",
                        "backgroundColorFromHover" => "rgba(0,0,255,0.5)",
                    ],
                    "shortCardLabelDesignBlockModel"     => [
                        "marginTop"                => 20,
                        "borderBottomWidth"        => 70,
                        "borderColorHover"         => "rgb(255,255,0)",
                        "backgroundColorFromHover" => "rgba(0,0,255,0.5)",
                    ],
                    "shortCardLabelDesignTextModel"      => [
                        "size" => 30
                    ],
                    "shortCardValueDesignBlockModel"     => [
                        "marginTop"                => 20,
                        "borderBottomWidth"        => 70,
                        "borderColorHover"         => "rgb(255,255,0)",
                        "backgroundColorFromHover" => "rgba(0,0,255,0.5)",
                    ],
                    "shortCardValueDesignTextModel"      => [
                        "size" => 30
                    ],
                    "fullCardContainerDesignBlockModel"  => [
                        "marginTop"                => 20,
                        "borderBottomWidth"        => 70,
                        "borderColorHover"         => "rgb(255,255,0)",
                        "backgroundColorFromHover" => "rgba(0,0,255,0.5)",
                    ],
                    "fullCardLabelDesignBlockModel"      => [
                        "marginTop"                => 20,
                        "borderBottomWidth"        => 70,
                        "borderColorHover"         => "rgb(255,255,0)",
                        "backgroundColorFromHover" => "rgba(0,0,255,0.5)",
                    ],
                    "fullCardLabelDesignTextModel"       => [
                        "size" => 30
                    ],
                    "fullCardValueDesignBlockModel"      => [
                        "marginTop"                => 20,
                        "borderBottomWidth"        => 70,
                        "borderColorHover"         => "rgb(255,255,0)",
                        "backgroundColorFromHover" => "rgba(0,0,255,0.5)",
                    ],
                    "fullCardValueDesignTextModel"       => [
                        "size" => 30
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
                    "shortCardContainerDesignBlockModel" => "incorrect",
                    "shortCardLabelDesignBlockModel"     => "incorrect",
                    "shortCardLabelDesignTextModel"      => "incorrect",
                    "shortCardValueDesignBlockModel"     => "incorrect",
                    "shortCardValueDesignTextModel"      => "incorrect",
                    "fullCardContainerDesignBlockModel"  => "incorrect",
                    "fullCardLabelDesignBlockModel"      => "incorrect",
                    "fullCardLabelDesignTextModel"       => "incorrect",
                    "fullCardValueDesignBlockModel"      => "incorrect",
                    "fullCardValueDesignTextModel"       => "incorrect",
                ],
                [
                    "shortCardContainerDesignBlockModel" => [
                        "marginTop" => 0
                    ],
                    "shortCardLabelDesignBlockModel"     => [
                        "marginTop" => 0
                    ],
                    "shortCardLabelDesignTextModel"      => [
                        "size" => 0
                    ],
                    "shortCardValueDesignBlockModel"     => [
                        "marginTop" => 0
                    ],
                    "shortCardValueDesignTextModel"      => [
                        "size" => 0
                    ],
                    "fullCardContainerDesignBlockModel"  => [
                        "marginTop" => 0
                    ],
                    "fullCardLabelDesignBlockModel"      => [
                        "marginTop" => 0
                    ],
                    "fullCardLabelDesignTextModel"       => [
                        "size" => 0
                    ],
                    "fullCardValueDesignBlockModel"      => [
                        "marginTop" => 0
                    ],
                    "fullCardValueDesignTextModel"       => [
                        "size" => 0
                    ],
                ],
                [
                    "shortCardContainerDesignBlockModel" => [
                        "marginTop" => " 100 "
                    ],
                ],
                [
                    "shortCardContainerDesignBlockModel" => [
                        "marginTop" => 100
                    ],
                    "shortCardLabelDesignBlockModel"     => [
                        "marginTop" => 0
                    ],
                    "shortCardLabelDesignTextModel"      => [
                        "size" => 0
                    ],
                    "shortCardValueDesignBlockModel"     => [
                        "marginTop" => 0
                    ],
                    "shortCardValueDesignTextModel"      => [
                        "size" => 0
                    ],
                    "fullCardContainerDesignBlockModel"  => [
                        "marginTop" => 0
                    ],
                    "fullCardLabelDesignBlockModel"      => [
                        "marginTop" => 0
                    ],
                    "fullCardLabelDesignTextModel"       => [
                        "size" => 0
                    ],
                    "fullCardValueDesignBlockModel"      => [
                        "marginTop" => 0
                    ],
                    "fullCardValueDesignTextModel"       => [
                        "size" => 0
                    ],
                ],
            ],
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
                "shortCardContainerDesignBlockModel" => [
                    "marginTop"                => 10,
                    "borderBottomWidth"        => 7,
                    "borderColorHover"         => "rgb(0,255,0)",
                    "backgroundColorFromHover" => "rgba(255,0,255,0.5)",
                ],
                "shortCardLabelDesignBlockModel"     => [
                    "marginTop"                => 10,
                    "borderBottomWidth"        => 7,
                    "borderColorHover"         => "rgb(0,255,0)",
                    "backgroundColorFromHover" => "rgba(255,0,255,0.5)",
                ],
                "shortCardLabelDesignTextModel"      => [
                    "size" => 10
                ],
                "shortCardValueDesignBlockModel"     => [
                    "marginTop"                => 10,
                    "borderBottomWidth"        => 7,
                    "borderColorHover"         => "rgb(0,255,0)",
                    "backgroundColorFromHover" => "rgba(255,0,255,0.5)",
                ],
                "shortCardValueDesignTextModel"      => [
                    "size" => 10
                ],
                "fullCardContainerDesignBlockModel"  => [
                    "marginTop"                => 10,
                    "borderBottomWidth"        => 7,
                    "borderColorHover"         => "rgb(0,255,0)",
                    "backgroundColorFromHover" => "rgba(255,0,255,0.5)",
                ],
                "fullCardLabelDesignBlockModel"      => [
                    "marginTop"                => 10,
                    "borderBottomWidth"        => 7,
                    "borderColorHover"         => "rgb(0,255,0)",
                    "backgroundColorFromHover" => "rgba(255,0,255,0.5)",
                ],
                "fullCardLabelDesignTextModel"       => [
                    "size" => 10
                ],
                "fullCardValueDesignBlockModel"      => [
                    "marginTop"                => 10,
                    "borderBottomWidth"        => 7,
                    "borderColorHover"         => "rgb(0,255,0)",
                    "backgroundColorFromHover" => "rgba(255,0,255,0.5)",
                ],
                "fullCardValueDesignTextModel"       => [
                    "size" => 10
                ],
            ],
            [
                "shortCardContainerDesignBlockModel" => [
                    "marginTop"                => 10,
                    "borderBottomWidth"        => 7,
                    "borderColorHover"         => "rgb(0,255,0)",
                    "backgroundColorFromHover" => "rgba(255,0,255,0.5)",
                ],
                "shortCardLabelDesignBlockModel"     => [
                    "marginTop"                => 10,
                    "borderBottomWidth"        => 7,
                    "borderColorHover"         => "rgb(0,255,0)",
                    "backgroundColorFromHover" => "rgba(255,0,255,0.5)",
                ],
                "shortCardLabelDesignTextModel"      => [
                    "size" => 10
                ],
                "shortCardValueDesignBlockModel"     => [
                    "marginTop"                => 10,
                    "borderBottomWidth"        => 7,
                    "borderColorHover"         => "rgb(0,255,0)",
                    "backgroundColorFromHover" => "rgba(255,0,255,0.5)",
                ],
                "shortCardValueDesignTextModel"      => [
                    "size" => 10
                ],
                "fullCardContainerDesignBlockModel"  => [
                    "marginTop"                => 10,
                    "borderBottomWidth"        => 7,
                    "borderColorHover"         => "rgb(0,255,0)",
                    "backgroundColorFromHover" => "rgba(255,0,255,0.5)",
                ],
                "fullCardLabelDesignBlockModel"      => [
                    "marginTop"                => 10,
                    "borderBottomWidth"        => 7,
                    "borderColorHover"         => "rgb(0,255,0)",
                    "backgroundColorFromHover" => "rgba(255,0,255,0.5)",
                ],
                "fullCardLabelDesignTextModel"       => [
                    "size" => 10
                ],
                "fullCardValueDesignBlockModel"      => [
                    "marginTop"                => 10,
                    "borderBottomWidth"        => 7,
                    "borderColorHover"         => "rgb(0,255,0)",
                    "backgroundColorFromHover" => "rgba(255,0,255,0.5)",
                ],
                "fullCardValueDesignTextModel"       => [
                    "size" => 10
                ],
            ]
        );
    }
}