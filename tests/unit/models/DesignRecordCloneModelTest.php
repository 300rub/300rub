<?php

namespace testS\tests\unit\models;

use testS\models\DesignRecordCloneModel;

/**
 * Tests for the model DesignRecordCloneModel
 *
 * @package testS\tests\unit\models
 */
class DesignRecordCloneModelTest extends AbstractModelTest
{

    /**
     * Gets model name
     *
     * @return string
     */
    protected function getNewModel()
    {
        return new DesignRecordCloneModel();
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
                    "instanceDesignBlockModel"    => [
                        "marginTop" => 0
                    ],
                    "titleDesignBlockModel"       => [
                        "marginTop" => 0
                    ],
                    "titleDesignTextModel"        => [
                        "size" => 0
                    ],
                    "dateDesignTextModel"         => [
                        "size" => 0
                    ],
                    "descriptionDesignBlockModel" => [
                        "marginTop" => 0
                    ],
                    "descriptionDesignTextModel"  => [
                        "size" => 0
                    ],
                    "viewType"                    => 0,
                ],
                [
                    "containerDesignBlockModel"   => "",
                    "instanceDesignBlockModel"    => "",
                    "titleDesignBlockModel"       => "",
                    "titleDesignTextModel"        => "",
                    "dateDesignTextModel"         => "",
                    "descriptionDesignBlockModel" => "",
                    "descriptionDesignTextModel"  => "",
                    "viewType"                    => "",
                ],
                [
                    "containerDesignBlockModel"   => [
                        "marginTop" => 0
                    ],
                    "instanceDesignBlockModel"    => [
                        "marginTop" => 0
                    ],
                    "titleDesignBlockModel"       => [
                        "marginTop" => 0
                    ],
                    "titleDesignTextModel"        => [
                        "size" => 0
                    ],
                    "dateDesignTextModel"         => [
                        "size" => 0
                    ],
                    "descriptionDesignBlockModel" => [
                        "marginTop" => 0
                    ],
                    "descriptionDesignTextModel"  => [
                        "size" => 0
                    ],
                    "viewType"                    => 0,
                ],
            ],
            "empty2" => [
                [
                    "containerDesignBlockModel"   => null,
                    "instanceDesignBlockModel"    => null,
                    "titleDesignBlockModel"       => null,
                    "titleDesignTextModel"        => null,
                    "dateDesignTextModel"         => null,
                    "descriptionDesignBlockModel" => null,
                    "descriptionDesignTextModel"  => null,
                    "viewType"                    => null,
                ],
                [
                    "containerDesignBlockModel"   => [
                        "marginTop" => 0
                    ],
                    "instanceDesignBlockModel"    => [
                        "marginTop" => 0
                    ],
                    "titleDesignBlockModel"       => [
                        "marginTop" => 0
                    ],
                    "titleDesignTextModel"        => [
                        "size" => 0
                    ],
                    "dateDesignTextModel"         => [
                        "size" => 0
                    ],
                    "descriptionDesignBlockModel" => [
                        "marginTop" => 0
                    ],
                    "descriptionDesignTextModel"  => [
                        "size" => 0
                    ],
                    "viewType"                    => 0,
                ],
                [
                    "containerDesignBlockModel"   => " ",
                    "instanceDesignBlockModel"    => " ",
                    "titleDesignBlockModel"       => " ",
                    "titleDesignTextModel"        => " ",
                    "dateDesignTextModel"         => " ",
                    "descriptionDesignBlockModel" => " ",
                    "descriptionDesignTextModel"  => " ",
                    "viewType"                    => " ",
                ],
                [
                    "containerDesignBlockModel"   => [
                        "marginTop" => 0
                    ],
                    "instanceDesignBlockModel"    => [
                        "marginTop" => 0
                    ],
                    "titleDesignBlockModel"       => [
                        "marginTop" => 0
                    ],
                    "titleDesignTextModel"        => [
                        "size" => 0
                    ],
                    "dateDesignTextModel"         => [
                        "size" => 0
                    ],
                    "descriptionDesignBlockModel" => [
                        "marginTop" => 0
                    ],
                    "descriptionDesignTextModel"  => [
                        "size" => 0
                    ],
                    "viewType"                    => 0,
                ],
            ],
            "empty3" => [
                [
                    "containerDesignBlockId"   => " ",
                    "instanceDesignBlockId"    => " ",
                    "titleDesignBlockId"       => " ",
                    "titleDesignTextId"        => " ",
                    "dateDesignTextId"         => " ",
                    "descriptionDesignBlockId" => " ",
                    "descriptionDesignTextId"  => " ",
                    "viewType"                 => " ",
                ],
                [
                    "containerDesignBlockModel"   => [
                        "marginTop" => 0
                    ],
                    "instanceDesignBlockModel"    => [
                        "marginTop" => 0
                    ],
                    "titleDesignBlockModel"       => [
                        "marginTop" => 0
                    ],
                    "titleDesignTextModel"        => [
                        "size" => 0
                    ],
                    "dateDesignTextModel"         => [
                        "size" => 0
                    ],
                    "descriptionDesignBlockModel" => [
                        "marginTop" => 0
                    ],
                    "descriptionDesignTextModel"  => [
                        "size" => 0
                    ],
                    "viewType"                    => 0,
                ],
                [
                    "containerDesignBlockId"   => null,
                    "instanceDesignBlockId"    => null,
                    "titleDesignBlockId"       => null,
                    "titleDesignTextId"        => null,
                    "dateDesignTextId"         => null,
                    "descriptionDesignBlockId" => null,
                    "descriptionDesignTextId"  => null,
                    "viewType"                 => null,
                ],
                [
                    "containerDesignBlockModel"   => [
                        "marginTop" => 0
                    ],
                    "instanceDesignBlockModel"    => [
                        "marginTop" => 0
                    ],
                    "titleDesignBlockModel"       => [
                        "marginTop" => 0
                    ],
                    "titleDesignTextModel"        => [
                        "size" => 0
                    ],
                    "dateDesignTextModel"         => [
                        "size" => 0
                    ],
                    "descriptionDesignBlockModel" => [
                        "marginTop" => 0
                    ],
                    "descriptionDesignTextModel"  => [
                        "size" => 0
                    ],
                    "viewType"                    => 0,
                ],
            ],
            "empty4" => [
                [
                    "containerDesignBlockModel"   => [
                        "marginTop" => " "
                    ],
                    "instanceDesignBlockModel"    => [
                        "marginTop" => " "
                    ],
                    "titleDesignBlockModel"       => [
                        "marginTop" => " "
                    ],
                    "titleDesignTextModel"        => [
                        "size" => " "
                    ],
                    "dateDesignTextModel"         => [
                        "size" => " "
                    ],
                    "descriptionDesignBlockModel" => [
                        "marginTop" => " "
                    ],
                    "descriptionDesignTextModel"  => [
                        "size" => " "
                    ],
                    "viewType"                    => " ",
                ],
                [
                    "containerDesignBlockModel"   => [
                        "marginTop" => 0
                    ],
                    "instanceDesignBlockModel"    => [
                        "marginTop" => 0
                    ],
                    "titleDesignBlockModel"       => [
                        "marginTop" => 0
                    ],
                    "titleDesignTextModel"        => [
                        "size" => 0
                    ],
                    "dateDesignTextModel"         => [
                        "size" => 0
                    ],
                    "descriptionDesignBlockModel" => [
                        "marginTop" => 0
                    ],
                    "descriptionDesignTextModel"  => [
                        "size" => 0
                    ],
                    "viewType"                    => 0,
                ],
                [
                    "containerDesignBlockModel"   => [],
                    "instanceDesignBlockModel"    => [],
                    "titleDesignBlockModel"       => [],
                    "titleDesignTextModel"        => [],
                    "dateDesignTextModel"         => [],
                    "descriptionDesignBlockModel" => [],
                    "descriptionDesignTextModel"  => [],
                ],
                [
                    "containerDesignBlockModel"   => [
                        "marginTop" => 0
                    ],
                    "instanceDesignBlockModel"    => [
                        "marginTop" => 0
                    ],
                    "titleDesignBlockModel"       => [
                        "marginTop" => 0
                    ],
                    "titleDesignTextModel"        => [
                        "size" => 0
                    ],
                    "dateDesignTextModel"         => [
                        "size" => 0
                    ],
                    "descriptionDesignBlockModel" => [
                        "marginTop" => 0
                    ],
                    "descriptionDesignTextModel"  => [
                        "size" => 0
                    ],
                    "viewType"                    => 0,
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
                    "instanceDesignBlockModel"    => [
                        "marginTop"                => 10,
                        "borderBottomWidth"        => 7,
                        "borderColorHover"         => "rgb(0,255,0)",
                        "backgroundColorFromHover" => "rgba(255,0,255,0.5)",
                    ],
                    "titleDesignBlockModel"       => [
                        "marginTop"                => 10,
                        "borderBottomWidth"        => 7,
                        "borderColorHover"         => "rgb(0,255,0)",
                        "backgroundColorFromHover" => "rgba(255,0,255,0.5)",
                    ],
                    "titleDesignTextModel"        => [
                        "size" => 20
                    ],
                    "dateDesignTextModel"         => [
                        "size" => 20
                    ],
                    "descriptionDesignBlockModel" => [
                        "marginTop"                => 10,
                        "borderBottomWidth"        => 7,
                        "borderColorHover"         => "rgb(0,255,0)",
                        "backgroundColorFromHover" => "rgba(255,0,255,0.5)",
                    ],
                    "descriptionDesignTextModel"  => [
                        "size" => 20
                    ],
                    "viewType"                    => 1,
                ],
                [
                    "containerDesignBlockModel"   => [
                        "marginTop"                => 10,
                        "borderBottomWidth"        => 7,
                        "borderColorHover"         => "rgb(0,255,0)",
                        "backgroundColorFromHover" => "rgba(255,0,255,0.5)",
                    ],
                    "instanceDesignBlockModel"    => [
                        "marginTop"                => 10,
                        "borderBottomWidth"        => 7,
                        "borderColorHover"         => "rgb(0,255,0)",
                        "backgroundColorFromHover" => "rgba(255,0,255,0.5)",
                    ],
                    "titleDesignBlockModel"       => [
                        "marginTop"                => 10,
                        "borderBottomWidth"        => 7,
                        "borderColorHover"         => "rgb(0,255,0)",
                        "backgroundColorFromHover" => "rgba(255,0,255,0.5)",
                    ],
                    "titleDesignTextModel"        => [
                        "size" => 20
                    ],
                    "dateDesignTextModel"         => [
                        "size" => 20
                    ],
                    "descriptionDesignBlockModel" => [
                        "marginTop"                => 10,
                        "borderBottomWidth"        => 7,
                        "borderColorHover"         => "rgb(0,255,0)",
                        "backgroundColorFromHover" => "rgba(255,0,255,0.5)",
                    ],
                    "descriptionDesignTextModel"  => [
                        "size" => 20
                    ],
                    "viewType"                    => 1,
                ],
                [
                    "containerDesignBlockModel"   => [
                        "marginTop"                => 5,
                        "borderBottomWidth"        => 4,
                        "borderColorHover"         => "rgb(255,0,0)",
                        "backgroundColorFromHover" => "rgba(0,0,255,0.7)",
                    ],
                    "instanceDesignBlockModel"    => [
                        "marginTop"                => 5,
                        "borderBottomWidth"        => 4,
                        "borderColorHover"         => "rgb(255,0,0)",
                        "backgroundColorFromHover" => "rgba(0,0,255,0.7)",
                    ],
                    "titleDesignBlockModel"       => [
                        "marginTop"                => 5,
                        "borderBottomWidth"        => 4,
                        "borderColorHover"         => "rgb(255,0,0)",
                        "backgroundColorFromHover" => "rgba(0,0,255,0.7)",
                    ],
                    "titleDesignTextModel"        => [
                        "size" => 10
                    ],
                    "dateDesignTextModel"         => [
                        "size" => 10
                    ],
                    "descriptionDesignBlockModel" => [
                        "marginTop"                => 5,
                        "borderBottomWidth"        => 4,
                        "borderColorHover"         => "rgb(255,0,0)",
                        "backgroundColorFromHover" => "rgba(0,0,255,0.7)",
                    ],
                    "descriptionDesignTextModel"  => [
                        "size" => 10
                    ],
                    "viewType"                    => 0,
                ],
                [
                    "containerDesignBlockModel"   => [
                        "marginTop"                => 5,
                        "borderBottomWidth"        => 4,
                        "borderColorHover"         => "rgb(255,0,0)",
                        "backgroundColorFromHover" => "rgba(0,0,255,0.7)",
                    ],
                    "instanceDesignBlockModel"    => [
                        "marginTop"                => 5,
                        "borderBottomWidth"        => 4,
                        "borderColorHover"         => "rgb(255,0,0)",
                        "backgroundColorFromHover" => "rgba(0,0,255,0.7)",
                    ],
                    "titleDesignBlockModel"       => [
                        "marginTop"                => 5,
                        "borderBottomWidth"        => 4,
                        "borderColorHover"         => "rgb(255,0,0)",
                        "backgroundColorFromHover" => "rgba(0,0,255,0.7)",
                    ],
                    "titleDesignTextModel"        => [
                        "size" => 10
                    ],
                    "dateDesignTextModel"         => [
                        "size" => 10
                    ],
                    "descriptionDesignBlockModel" => [
                        "marginTop"                => 5,
                        "borderBottomWidth"        => 4,
                        "borderColorHover"         => "rgb(255,0,0)",
                        "backgroundColorFromHover" => "rgba(0,0,255,0.7)",
                    ],
                    "descriptionDesignTextModel"  => [
                        "size" => 10
                    ],
                    "viewType"                    => 0,
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
                    "instanceDesignBlockModel"    => "incorrect",
                    "titleDesignBlockModel"       => "incorrect",
                    "titleDesignTextModel"        => "incorrect",
                    "dateDesignTextModel"         => "incorrect",
                    "descriptionDesignBlockModel" => "incorrect",
                    "descriptionDesignTextModel"  => "incorrect",
                    "viewType"                    => "incorrect",
                ],
                [
                    "containerDesignBlockModel"   => [
                        "marginTop" => 0
                    ],
                    "instanceDesignBlockModel"    => [
                        "marginTop" => 0
                    ],
                    "titleDesignBlockModel"       => [
                        "marginTop" => 0
                    ],
                    "titleDesignTextModel"        => [
                        "size" => 0
                    ],
                    "dateDesignTextModel"         => [
                        "size" => 0
                    ],
                    "descriptionDesignBlockModel" => [
                        "marginTop" => 0
                    ],
                    "descriptionDesignTextModel"  => [
                        "size" => 0
                    ],
                    "viewType"                    => 0,
                ],
                [
                    "viewType" => 999,
                ],
                [
                    "viewType" => 0,
                ],
            ],
            "incorrect2" => [
                [
                    "viewType" => " 1 ",
                ],
                [
                    "viewType" => 1,
                ],
                [
                    "containerDesignBlockModel"   => [
                        "marginTop" => " 500g "
                    ],
                    "instanceDesignBlockModel"    => [
                        "marginTop" => " 500g "
                    ],
                    "titleDesignBlockModel"       => [
                        "marginTop" => " 500g "
                    ],
                    "titleDesignTextModel"        => [
                        "size" => " 500px "
                    ],
                    "dateDesignTextModel"         => [
                        "size" => " 500g "
                    ],
                    "descriptionDesignBlockModel" => [
                        "marginTop" => " 500g "
                    ],
                    "descriptionDesignTextModel"  => [
                        "size" => " 500g "
                    ],
                    "viewType"                    => true,
                ],
                [
                    "containerDesignBlockModel"   => [
                        "marginTop" => 500
                    ],
                    "instanceDesignBlockModel"    => [
                        "marginTop" => 500
                    ],
                    "titleDesignBlockModel"       => [
                        "marginTop" => 500
                    ],
                    "titleDesignTextModel"        => [
                        "size" => 500
                    ],
                    "dateDesignTextModel"         => [
                        "size" => 500
                    ],
                    "descriptionDesignBlockModel" => [
                        "marginTop" => 500
                    ],
                    "descriptionDesignTextModel"  => [
                        "size" => 500
                    ],
                    "viewType"                    => 1,
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
                "instanceDesignBlockModel"    => [
                    "marginTop"                => 10,
                    "borderBottomWidth"        => 7,
                    "borderColorHover"         => "rgb(0,255,0)",
                    "backgroundColorFromHover" => "rgba(255,0,255,0.5)",
                ],
                "titleDesignBlockModel"       => [
                    "marginTop"                => 10,
                    "borderBottomWidth"        => 7,
                    "borderColorHover"         => "rgb(0,255,0)",
                    "backgroundColorFromHover" => "rgba(255,0,255,0.5)",
                ],
                "titleDesignTextModel"        => [
                    "size" => 20
                ],
                "dateDesignTextModel"         => [
                    "size" => 20
                ],
                "descriptionDesignBlockModel" => [
                    "marginTop"                => 10,
                    "borderBottomWidth"        => 7,
                    "borderColorHover"         => "rgb(0,255,0)",
                    "backgroundColorFromHover" => "rgba(255,0,255,0.5)",
                ],
                "descriptionDesignTextModel"  => [
                    "size" => 20
                ],
                "viewType"                    => 1,
            ],
            [
                "containerDesignBlockModel"   => [
                    "marginTop"                => 10,
                    "borderBottomWidth"        => 7,
                    "borderColorHover"         => "rgb(0,255,0)",
                    "backgroundColorFromHover" => "rgba(255,0,255,0.5)",
                ],
                "instanceDesignBlockModel"    => [
                    "marginTop"                => 10,
                    "borderBottomWidth"        => 7,
                    "borderColorHover"         => "rgb(0,255,0)",
                    "backgroundColorFromHover" => "rgba(255,0,255,0.5)",
                ],
                "titleDesignBlockModel"       => [
                    "marginTop"                => 10,
                    "borderBottomWidth"        => 7,
                    "borderColorHover"         => "rgb(0,255,0)",
                    "backgroundColorFromHover" => "rgba(255,0,255,0.5)",
                ],
                "titleDesignTextModel"        => [
                    "size" => 20
                ],
                "dateDesignTextModel"         => [
                    "size" => 20
                ],
                "descriptionDesignBlockModel" => [
                    "marginTop"                => 10,
                    "borderBottomWidth"        => 7,
                    "borderColorHover"         => "rgb(0,255,0)",
                    "backgroundColorFromHover" => "rgba(255,0,255,0.5)",
                ],
                "descriptionDesignTextModel"  => [
                    "size" => 20
                ],
                "viewType"                    => 1,
            ]
        );
    }
}