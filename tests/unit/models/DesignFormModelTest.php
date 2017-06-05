<?php

namespace testS\tests\unit\models;

use testS\models\DesignFormModel;

/**
 * Tests for the model DesignFormModel
 *
 * @package testS\tests\unit\models
 */
class DesignFormModelTest extends AbstractModelTest
{

    /**
     * Gets model name
     *
     * @return DesignFormModel
     */
    protected function getNewModel()
    {
        return new DesignFormModel();
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
                    "lineDesignBlockModel"      => [
                        "marginTop" => 0
                    ],
                    "labelDesignBlockModel"     => [
                        "marginTop" => 0
                    ],
                    "labelDesignTextModel"      => [
                        "size" => 0
                    ],
                    "formDesignBlockModel"      => [
                        "marginTop" => 0
                    ],
                    "formDesignTextModel"       => [
                        "size" => 0
                    ],
                    "submitDesignBlockModel"    => [
                        "marginTop" => 0
                    ],
                    "submitDesignTextModel"     => [
                        "size" => 0
                    ],
                    "submitIconDesignTextModel" => [
                        "size" => 0
                    ],
                    "submitIcon"                => "",
                    "submitIconPosition"        => 0,
                    "submitAlignment"           => 0
                ],
                [
                    "containerDesignBlockModel" => "",
                    "lineDesignBlockModel"      => "",
                    "labelDesignBlockModel"     => "",
                    "labelDesignTextModel"      => "",
                    "formDesignBlockModel"      => "",
                    "formDesignTextModel"       => "",
                    "submitDesignBlockModel"    => "",
                    "submitDesignTextModel"     => "",
                    "submitIconDesignTextModel" => "",
                    "submitIcon"                => "",
                    "submitIconPosition"        => "",
                    "submitAlignment"           => ""
                ],
                [
                    "containerDesignBlockModel" => [
                        "marginTop" => 0
                    ],
                    "lineDesignBlockModel"      => [
                        "marginTop" => 0
                    ],
                    "labelDesignBlockModel"     => [
                        "marginTop" => 0
                    ],
                    "labelDesignTextModel"      => [
                        "size" => 0
                    ],
                    "formDesignBlockModel"      => [
                        "marginTop" => 0
                    ],
                    "formDesignTextModel"       => [
                        "size" => 0
                    ],
                    "submitDesignBlockModel"    => [
                        "marginTop" => 0
                    ],
                    "submitDesignTextModel"     => [
                        "size" => 0
                    ],
                    "submitIconDesignTextModel" => [
                        "size" => 0
                    ],
                    "submitIcon"                => "",
                    "submitIconPosition"        => 0,
                    "submitAlignment"           => 0
                ],
            ],
            "empty2" => [
                [
                    "containerDesignBlockModel" => null,
                    "lineDesignBlockModel"      => null,
                    "labelDesignBlockModel"     => null,
                    "labelDesignTextModel"      => null,
                    "formDesignBlockModel"      => null,
                    "formDesignTextModel"       => null,
                    "submitDesignBlockModel"    => null,
                    "submitDesignTextModel"     => null,
                    "submitIconDesignTextModel" => null,
                    "submitIcon"                => null,
                    "submitIconPosition"        => null,
                    "submitAlignment"           => null,
                ],
                [
                    "containerDesignBlockModel" => [
                        "marginTop" => 0
                    ],
                    "lineDesignBlockModel"      => [
                        "marginTop" => 0
                    ],
                    "labelDesignBlockModel"     => [
                        "marginTop" => 0
                    ],
                    "labelDesignTextModel"      => [
                        "size" => 0
                    ],
                    "formDesignBlockModel"      => [
                        "marginTop" => 0
                    ],
                    "formDesignTextModel"       => [
                        "size" => 0
                    ],
                    "submitDesignBlockModel"    => [
                        "marginTop" => 0
                    ],
                    "submitDesignTextModel"     => [
                        "size" => 0
                    ],
                    "submitIconDesignTextModel" => [
                        "size" => 0
                    ],
                    "submitIcon"                => "",
                    "submitIconPosition"        => 0,
                    "submitAlignment"           => 0
                ],
                [
                    "containerDesignBlockModel" => " ",
                    "lineDesignBlockModel"      => " ",
                    "labelDesignBlockModel"     => " ",
                    "labelDesignTextModel"      => " ",
                    "formDesignBlockModel"      => " ",
                    "formDesignTextModel"       => " ",
                    "submitDesignBlockModel"    => " ",
                    "submitDesignTextModel"     => " ",
                    "submitIconDesignTextModel" => " ",
                    "submitIcon"                => " ",
                    "submitIconPosition"        => " ",
                    "submitAlignment"           => " ",
                ],
                [
                    "containerDesignBlockModel" => [
                        "marginTop" => 0
                    ],
                    "lineDesignBlockModel"      => [
                        "marginTop" => 0
                    ],
                    "labelDesignBlockModel"     => [
                        "marginTop" => 0
                    ],
                    "labelDesignTextModel"      => [
                        "size" => 0
                    ],
                    "formDesignBlockModel"      => [
                        "marginTop" => 0
                    ],
                    "formDesignTextModel"       => [
                        "size" => 0
                    ],
                    "submitDesignBlockModel"    => [
                        "marginTop" => 0
                    ],
                    "submitDesignTextModel"     => [
                        "size" => 0
                    ],
                    "submitIconDesignTextModel" => [
                        "size" => 0
                    ],
                    "submitIcon"                => "",
                    "submitIconPosition"        => 0,
                    "submitAlignment"           => 0
                ],
            ],
            "empty3" => [
                [
                    "containerDesignBlockId" => " ",
                    "lineDesignBlockId"      => " ",
                    "labelDesignBlockId"     => " ",
                    "labelDesignTextId"      => " ",
                    "formDesignBlockId"      => " ",
                    "formDesignTextId"       => " ",
                    "submitDesignBlockId"    => " ",
                    "submitDesignTextId"     => " ",
                    "submitIconDesignTextId" => " ",
                ],
                [
                    "containerDesignBlockModel" => [
                        "marginTop" => 0
                    ],
                    "lineDesignBlockModel"      => [
                        "marginTop" => 0
                    ],
                    "labelDesignBlockModel"     => [
                        "marginTop" => 0
                    ],
                    "labelDesignTextModel"      => [
                        "size" => 0
                    ],
                    "formDesignBlockModel"      => [
                        "marginTop" => 0
                    ],
                    "formDesignTextModel"       => [
                        "size" => 0
                    ],
                    "submitDesignBlockModel"    => [
                        "marginTop" => 0
                    ],
                    "submitDesignTextModel"     => [
                        "size" => 0
                    ],
                    "submitIconDesignTextModel" => [
                        "size" => 0
                    ],
                    "submitIcon"                => "",
                    "submitIconPosition"        => 0,
                    "submitAlignment"           => 0
                ],
                [
                    "containerDesignBlockId" => null,
                    "lineDesignBlockId"      => null,
                    "labelDesignBlockId"     => null,
                    "labelDesignTextId"      => null,
                    "formDesignBlockId"      => null,
                    "formDesignTextId"       => null,
                    "submitDesignBlockId"    => null,
                    "submitDesignTextId"     => null,
                    "submitIconDesignTextId" => null,
                ],
                [
                    "containerDesignBlockModel" => [
                        "marginTop" => 0
                    ],
                    "lineDesignBlockModel"      => [
                        "marginTop" => 0
                    ],
                    "labelDesignBlockModel"     => [
                        "marginTop" => 0
                    ],
                    "labelDesignTextModel"      => [
                        "size" => 0
                    ],
                    "formDesignBlockModel"      => [
                        "marginTop" => 0
                    ],
                    "formDesignTextModel"       => [
                        "size" => 0
                    ],
                    "submitDesignBlockModel"    => [
                        "marginTop" => 0
                    ],
                    "submitDesignTextModel"     => [
                        "size" => 0
                    ],
                    "submitIconDesignTextModel" => [
                        "size" => 0
                    ],
                    "submitIcon"                => "",
                    "submitIconPosition"        => 0,
                    "submitAlignment"           => 0
                ],
            ],
            "empty4" => [
                [
                    "containerDesignBlockModel" => [
                        "marginTop" => " "
                    ],
                    "lineDesignBlockModel"      => [
                        "marginTop" => " "
                    ],
                    "labelDesignBlockModel"     => [
                        "marginTop" => " "
                    ],
                    "labelDesignTextModel"      => [
                        "size" => " "
                    ],
                    "formDesignBlockModel"      => [
                        "marginTop" => " "
                    ],
                    "formDesignTextModel"       => [
                        "size" => " "
                    ],
                    "submitDesignBlockModel"    => [
                        "marginTop" => " "
                    ],
                    "submitDesignTextModel"     => [
                        "size" => " "
                    ],
                    "submitIconDesignTextModel" => [
                        "size" => " "
                    ],
                ],
                [
                    "containerDesignBlockModel" => [
                        "marginTop" => 0
                    ],
                    "lineDesignBlockModel"      => [
                        "marginTop" => 0
                    ],
                    "labelDesignBlockModel"     => [
                        "marginTop" => 0
                    ],
                    "labelDesignTextModel"      => [
                        "size" => 0
                    ],
                    "formDesignBlockModel"      => [
                        "marginTop" => 0
                    ],
                    "formDesignTextModel"       => [
                        "size" => 0
                    ],
                    "submitDesignBlockModel"    => [
                        "marginTop" => 0
                    ],
                    "submitDesignTextModel"     => [
                        "size" => 0
                    ],
                    "submitIconDesignTextModel" => [
                        "size" => 0
                    ],
                    "submitIcon"                => "",
                    "submitIconPosition"        => 0,
                    "submitAlignment"           => 0
                ],
                [
                    "containerDesignBlockModel" => [],
                    "lineDesignBlockModel"      => [],
                    "labelDesignBlockModel"     => [],
                    "labelDesignTextModel"      => [],
                    "formDesignBlockModel"      => [],
                    "formDesignTextModel"       => [],
                    "submitDesignBlockModel"    => [],
                    "submitDesignTextModel"     => [],
                    "submitIconDesignTextModel" => [],
                ],
                [
                    "containerDesignBlockModel" => [
                        "marginTop" => 0
                    ],
                    "lineDesignBlockModel"      => [
                        "marginTop" => 0
                    ],
                    "labelDesignBlockModel"     => [
                        "marginTop" => 0
                    ],
                    "labelDesignTextModel"      => [
                        "size" => 0
                    ],
                    "formDesignBlockModel"      => [
                        "marginTop" => 0
                    ],
                    "formDesignTextModel"       => [
                        "size" => 0
                    ],
                    "submitDesignBlockModel"    => [
                        "marginTop" => 0
                    ],
                    "submitDesignTextModel"     => [
                        "size" => 0
                    ],
                    "submitIconDesignTextModel" => [
                        "size" => 0
                    ],
                    "submitIcon"                => "",
                    "submitIconPosition"        => 0,
                    "submitAlignment"           => 0
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
                    "lineDesignBlockModel"      => [
                        "marginTop"                => 10,
                        "borderBottomWidth"        => 7,
                        "borderColorHover"         => "rgb(0,255,0)",
                        "backgroundColorFromHover" => "rgba(255,0,255,0.5)",
                    ],
                    "labelDesignBlockModel"     => [
                        "marginTop"                => 10,
                        "borderBottomWidth"        => 7,
                        "borderColorHover"         => "rgb(0,255,0)",
                        "backgroundColorFromHover" => "rgba(255,0,255,0.5)",
                    ],
                    "labelDesignTextModel"      => [
                        "size" => 10
                    ],
                    "formDesignBlockModel"      => [
                        "marginTop"                => 10,
                        "borderBottomWidth"        => 7,
                        "borderColorHover"         => "rgb(0,255,0)",
                        "backgroundColorFromHover" => "rgba(255,0,255,0.5)",
                    ],
                    "formDesignTextModel"       => [
                        "size" => 10
                    ],
                    "submitDesignBlockModel"    => [
                        "marginTop"                => 10,
                        "borderBottomWidth"        => 7,
                        "borderColorHover"         => "rgb(0,255,0)",
                        "backgroundColorFromHover" => "rgba(255,0,255,0.5)",
                    ],
                    "submitDesignTextModel"     => [
                        "size" => 10
                    ],
                    "submitIconDesignTextModel" => [
                        "size" => 10
                    ],
                    "submitIcon"                => "fa-lock",
                    "submitIconPosition"        => 1,
                    "submitAlignment"           => 1
                ],
                [
                    "containerDesignBlockModel" => [
                        "marginTop"                => 10,
                        "borderBottomWidth"        => 7,
                        "borderColorHover"         => "rgb(0,255,0)",
                        "backgroundColorFromHover" => "rgba(255,0,255,0.5)",
                    ],
                    "lineDesignBlockModel"      => [
                        "marginTop"                => 10,
                        "borderBottomWidth"        => 7,
                        "borderColorHover"         => "rgb(0,255,0)",
                        "backgroundColorFromHover" => "rgba(255,0,255,0.5)",
                    ],
                    "labelDesignBlockModel"     => [
                        "marginTop"                => 10,
                        "borderBottomWidth"        => 7,
                        "borderColorHover"         => "rgb(0,255,0)",
                        "backgroundColorFromHover" => "rgba(255,0,255,0.5)",
                    ],
                    "labelDesignTextModel"      => [
                        "size" => 10
                    ],
                    "formDesignBlockModel"      => [
                        "marginTop"                => 10,
                        "borderBottomWidth"        => 7,
                        "borderColorHover"         => "rgb(0,255,0)",
                        "backgroundColorFromHover" => "rgba(255,0,255,0.5)",
                    ],
                    "formDesignTextModel"       => [
                        "size" => 10
                    ],
                    "submitDesignBlockModel"    => [
                        "marginTop"                => 10,
                        "borderBottomWidth"        => 7,
                        "borderColorHover"         => "rgb(0,255,0)",
                        "backgroundColorFromHover" => "rgba(255,0,255,0.5)",
                    ],
                    "submitDesignTextModel"     => [
                        "size" => 10
                    ],
                    "submitIconDesignTextModel" => [
                        "size" => 10
                    ],
                    "submitIcon"                => "fa-lock",
                    "submitIconPosition"        => 1,
                    "submitAlignment"           => 1
                ],
                [
                    "containerDesignBlockModel" => [
                        "marginTop"                => 5,
                        "borderBottomWidth"        => 4,
                        "borderColorHover"         => "rgb(255,0,0)",
                        "backgroundColorFromHover" => "rgba(0,0,255,0.7)",
                    ],
                    "lineDesignBlockModel"      => [
                        "marginTop"                => 5,
                        "borderBottomWidth"        => 4,
                        "borderColorHover"         => "rgb(255,0,0)",
                        "backgroundColorFromHover" => "rgba(0,0,255,0.7)",
                    ],
                    "labelDesignBlockModel"     => [
                        "marginTop"                => 5,
                        "borderBottomWidth"        => 4,
                        "borderColorHover"         => "rgb(255,0,0)",
                        "backgroundColorFromHover" => "rgba(0,0,255,0.7)",
                    ],
                    "labelDesignTextModel"      => [
                        "size" => 20
                    ],
                    "formDesignBlockModel"      => [
                        "marginTop"                => 5,
                        "borderBottomWidth"        => 4,
                        "borderColorHover"         => "rgb(255,0,0)",
                        "backgroundColorFromHover" => "rgba(0,0,255,0.7)",
                    ],
                    "formDesignTextModel"       => [
                        "size" => 20
                    ],
                    "submitDesignBlockModel"    => [
                        "marginTop"                => 5,
                        "borderBottomWidth"        => 4,
                        "borderColorHover"         => "rgb(255,0,0)",
                        "backgroundColorFromHover" => "rgba(0,0,255,0.7)",
                    ],
                    "submitDesignTextModel"     => [
                        "size" => 20
                    ],
                    "submitIconDesignTextModel" => [
                        "size" => 20
                    ],
                    "submitIcon"                => "fa-user",
                    "submitIconPosition"        => 2,
                    "submitAlignment"           => 2
                ],
                [
                    "containerDesignBlockModel" => [
                        "marginTop"                => 5,
                        "borderBottomWidth"        => 4,
                        "borderColorHover"         => "rgb(255,0,0)",
                        "backgroundColorFromHover" => "rgba(0,0,255,0.7)",
                    ],
                    "lineDesignBlockModel"      => [
                        "marginTop"                => 5,
                        "borderBottomWidth"        => 4,
                        "borderColorHover"         => "rgb(255,0,0)",
                        "backgroundColorFromHover" => "rgba(0,0,255,0.7)",
                    ],
                    "labelDesignBlockModel"     => [
                        "marginTop"                => 5,
                        "borderBottomWidth"        => 4,
                        "borderColorHover"         => "rgb(255,0,0)",
                        "backgroundColorFromHover" => "rgba(0,0,255,0.7)",
                    ],
                    "labelDesignTextModel"      => [
                        "size" => 20
                    ],
                    "formDesignBlockModel"      => [
                        "marginTop"                => 5,
                        "borderBottomWidth"        => 4,
                        "borderColorHover"         => "rgb(255,0,0)",
                        "backgroundColorFromHover" => "rgba(0,0,255,0.7)",
                    ],
                    "formDesignTextModel"       => [
                        "size" => 20
                    ],
                    "submitDesignBlockModel"    => [
                        "marginTop"                => 5,
                        "borderBottomWidth"        => 4,
                        "borderColorHover"         => "rgb(255,0,0)",
                        "backgroundColorFromHover" => "rgba(0,0,255,0.7)",
                    ],
                    "submitDesignTextModel"     => [
                        "size" => 20
                    ],
                    "submitIconDesignTextModel" => [
                        "size" => 20
                    ],
                    "submitIcon"                => "fa-user",
                    "submitIconPosition"        => 2,
                    "submitAlignment"           => 2
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
                    "lineDesignBlockModel"      => "incorrect",
                    "labelDesignBlockModel"     => "incorrect",
                    "labelDesignTextModel"      => "incorrect",
                    "formDesignBlockModel"      => "incorrect",
                    "formDesignTextModel"       => "incorrect",
                    "submitDesignBlockModel"    => "incorrect",
                    "submitDesignTextModel"     => "incorrect",
                    "submitIconDesignTextModel" => "incorrect",
                    "submitIcon"                => 123,
                    "submitIconPosition"        => "incorrect",
                    "submitAlignment"           => "incorrect",
                ],
                [
                    "containerDesignBlockModel" => [
                        "marginTop" => 0
                    ],
                    "lineDesignBlockModel"      => [
                        "marginTop" => 0
                    ],
                    "labelDesignBlockModel"     => [
                        "marginTop" => 0
                    ],
                    "labelDesignTextModel"      => [
                        "size" => 0
                    ],
                    "formDesignBlockModel"      => [
                        "marginTop" => 0
                    ],
                    "formDesignTextModel"       => [
                        "size" => 0
                    ],
                    "submitDesignBlockModel"    => [
                        "marginTop" => 0
                    ],
                    "submitDesignTextModel"     => [
                        "size" => 0
                    ],
                    "submitIconDesignTextModel" => [
                        "size" => 0
                    ],
                    "submitIcon"                => "123",
                    "submitIconPosition"        => 0,
                    "submitAlignment"           => 0
                ],
                [
                    "submitIconPosition" => 999,
                    "submitAlignment"   => 999
                ],
                [
                    "submitIconPosition"        => 0,
                    "submitAlignment"           => 0
                ],
            ],
            "incorrect2" => [
                [
                    "submitIconPosition"      => " 1 ",
                    "submitAlignment" => "1asdads",
                ],
                [
                    "submitIconPosition"      => 1,
                    "submitAlignment" => 1,
                ],
                [
                    "containerDesignBlockModel" => [
                        "marginTop" => " 500 "
                    ],
                    "submitIconPosition"                  => true,
                    "submitAlignment"             => false,
                ],
                [
                    "containerDesignBlockModel" => [
                        "marginTop" => 500
                    ],
                    "submitIconPosition"                  => 1,
                    "submitAlignment"             => 0,
                ],
            ],
            "incorrect3" => [
                [
                    "submitIcon"      => $this->generateStringWithLength(51),
                ],
                [
                    "submitIcon"      => ["maxLength"],
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
                "containerDesignBlockModel" => [
                    "marginTop"                => 10,
                    "borderBottomWidth"        => 7,
                    "borderColorHover"         => "rgb(0,255,0)",
                    "backgroundColorFromHover" => "rgba(255,0,255,0.5)",
                ],
                "lineDesignBlockModel"      => [
                    "marginTop"                => 10,
                    "borderBottomWidth"        => 7,
                    "borderColorHover"         => "rgb(0,255,0)",
                    "backgroundColorFromHover" => "rgba(255,0,255,0.5)",
                ],
                "labelDesignBlockModel"     => [
                    "marginTop"                => 10,
                    "borderBottomWidth"        => 7,
                    "borderColorHover"         => "rgb(0,255,0)",
                    "backgroundColorFromHover" => "rgba(255,0,255,0.5)",
                ],
                "labelDesignTextModel"      => [
                    "size" => 10
                ],
                "formDesignBlockModel"      => [
                    "marginTop"                => 10,
                    "borderBottomWidth"        => 7,
                    "borderColorHover"         => "rgb(0,255,0)",
                    "backgroundColorFromHover" => "rgba(255,0,255,0.5)",
                ],
                "formDesignTextModel"       => [
                    "size" => 10
                ],
                "submitDesignBlockModel"    => [
                    "marginTop"                => 10,
                    "borderBottomWidth"        => 7,
                    "borderColorHover"         => "rgb(0,255,0)",
                    "backgroundColorFromHover" => "rgba(255,0,255,0.5)",
                ],
                "submitDesignTextModel"     => [
                    "size" => 10
                ],
                "submitIconDesignTextModel" => [
                    "size" => 10
                ],
                "submitIcon"                => "fa-lock",
                "submitIconPosition"        => 1,
                "submitAlignment"           => 1
            ],
            [
                "containerDesignBlockModel" => [
                    "marginTop"                => 10,
                    "borderBottomWidth"        => 7,
                    "borderColorHover"         => "rgb(0,255,0)",
                    "backgroundColorFromHover" => "rgba(255,0,255,0.5)",
                ],
                "lineDesignBlockModel"      => [
                    "marginTop"                => 10,
                    "borderBottomWidth"        => 7,
                    "borderColorHover"         => "rgb(0,255,0)",
                    "backgroundColorFromHover" => "rgba(255,0,255,0.5)",
                ],
                "labelDesignBlockModel"     => [
                    "marginTop"                => 10,
                    "borderBottomWidth"        => 7,
                    "borderColorHover"         => "rgb(0,255,0)",
                    "backgroundColorFromHover" => "rgba(255,0,255,0.5)",
                ],
                "labelDesignTextModel"      => [
                    "size" => 10
                ],
                "formDesignBlockModel"      => [
                    "marginTop"                => 10,
                    "borderBottomWidth"        => 7,
                    "borderColorHover"         => "rgb(0,255,0)",
                    "backgroundColorFromHover" => "rgba(255,0,255,0.5)",
                ],
                "formDesignTextModel"       => [
                    "size" => 10
                ],
                "submitDesignBlockModel"    => [
                    "marginTop"                => 10,
                    "borderBottomWidth"        => 7,
                    "borderColorHover"         => "rgb(0,255,0)",
                    "backgroundColorFromHover" => "rgba(255,0,255,0.5)",
                ],
                "submitDesignTextModel"     => [
                    "size" => 10
                ],
                "submitIconDesignTextModel" => [
                    "size" => 10
                ],
                "submitIcon"                => "fa-lock",
                "submitIconPosition"        => 1,
                "submitAlignment"           => 1
            ]
        );
    }
}