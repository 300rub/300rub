<?php

namespace testS\tests\unit\models;

use testS\models\SiteMapModel;

/**
 * Tests for the model SiteMapModel
 *
 * @package testS\tests\unit\models
 */
class SiteMapModelTest extends AbstractModelTest
{

    /**
     * Gets model name
     *
     * @return SiteMapModel
     */
    protected function getNewModel()
    {
        return new SiteMapModel();
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
                    "itemDesignBlockModel"      => [
                        "marginTop" => 0
                    ],
                    "itemDesignTextModel"       => [
                        "size" => 0
                    ],
                    "style"                     => 0,
                ],
                [
                    "containerDesignBlockModel" => "",
                    "itemDesignBlockModel"      => "",
                    "itemDesignTextModel"       => "",
                    "style"                     => "",
                ],
                [
                    "containerDesignBlockModel" => [
                        "marginTop" => 0
                    ],
                    "itemDesignBlockModel"      => [
                        "marginTop" => 0
                    ],
                    "itemDesignTextModel"       => [
                        "size" => 0
                    ],
                    "style"                     => 0,
                ],
            ],
            "empty2" => [
                [
                    "containerDesignBlockModel" => null,
                    "itemDesignBlockModel"      => null,
                    "itemDesignTextModel"       => null,
                    "style"                     => null,
                ],
                [
                    "containerDesignBlockModel" => [
                        "marginTop" => 0
                    ],
                    "itemDesignBlockModel"      => [
                        "marginTop" => 0
                    ],
                    "itemDesignTextModel"       => [
                        "size" => 0
                    ],
                    "style"                     => 0,
                ],
                [
                    "containerDesignBlockModel" => " ",
                    "itemDesignBlockModel"      => " ",
                    "itemDesignTextModel"       => " ",
                    "style"                     => " ",
                ],
                [
                    "containerDesignBlockModel" => [
                        "marginTop" => 0
                    ],
                    "itemDesignBlockModel"      => [
                        "marginTop" => 0
                    ],
                    "itemDesignTextModel"       => [
                        "size" => 0
                    ],
                    "style"                     => 0,
                ],
            ],
            "empty3" => [
                [
                    "containerDesignBlockId" => " ",
                    "itemDesignBlockId"      => " ",
                    "itemDesignTextId"       => " ",
                    "style"                  => " ",
                ],
                [
                    "containerDesignBlockModel" => [
                        "marginTop" => 0
                    ],
                    "itemDesignBlockModel"      => [
                        "marginTop" => 0
                    ],
                    "itemDesignTextModel"       => [
                        "size" => 0
                    ],
                    "style"                     => 0,
                ],
                [
                    "containerDesignBlockId" => null,
                    "itemDesignBlockId"      => null,
                    "itemDesignTextId"       => null,
                    "style"                  => null,
                ],
                [
                    "containerDesignBlockModel" => [
                        "marginTop" => 0
                    ],
                    "itemDesignBlockModel"      => [
                        "marginTop" => 0
                    ],
                    "itemDesignTextModel"       => [
                        "size" => 0
                    ],
                    "style"                     => 0,
                ],
            ],
            "empty4" => [
                [
                    "containerDesignBlockModel" => [
                        "marginTop" => " "
                    ],
                    "itemDesignBlockModel"      => [
                        "marginTop" => " "
                    ],
                    "itemDesignTextModel"       => [
                        "size" => " "
                    ],
                ],
                [
                    "containerDesignBlockModel" => [
                        "marginTop" => 0
                    ],
                    "itemDesignBlockModel"      => [
                        "marginTop" => 0
                    ],
                    "itemDesignTextModel"       => [
                        "size" => 0
                    ],
                    "style"                     => 0,
                ],
                [
                    "containerDesignBlockModel" => [],
                    "itemDesignBlockModel"      => [],
                    "itemDesignTextModel"       => [],
                ],
                [
                    "containerDesignBlockModel" => [
                        "marginTop" => 0
                    ],
                    "itemDesignBlockModel"      => [
                        "marginTop" => 0
                    ],
                    "itemDesignTextModel"       => [
                        "size" => 0
                    ],
                    "style"                     => 0,
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
                    "itemDesignBlockModel"      => [
                        "marginTop"                => 10,
                        "borderBottomWidth"        => 7,
                        "borderColorHover"         => "rgb(0,255,0)",
                        "backgroundColorFromHover" => "rgba(255,0,255,0.5)",
                    ],
                    "itemDesignTextModel"       => [
                        "size" => 20
                    ],
                    "style"                     => 1
                ],
                [
                    "containerDesignBlockModel" => [
                        "marginTop"                => 10,
                        "borderBottomWidth"        => 7,
                        "borderColorHover"         => "rgb(0,255,0)",
                        "backgroundColorFromHover" => "rgba(255,0,255,0.5)",
                    ],
                    "itemDesignBlockModel"      => [
                        "marginTop"                => 10,
                        "borderBottomWidth"        => 7,
                        "borderColorHover"         => "rgb(0,255,0)",
                        "backgroundColorFromHover" => "rgba(255,0,255,0.5)",
                    ],
                    "itemDesignTextModel"       => [
                        "size" => 20
                    ],
                    "style"                     => 1
                ],
                [
                    "containerDesignBlockModel" => [
                        "marginTop"                => 5,
                        "borderBottomWidth"        => 4,
                        "borderColorHover"         => "rgb(255,0,0)",
                        "backgroundColorFromHover" => "rgba(0,0,255,0.7)",
                    ],
                    "itemDesignBlockModel"      => [
                        "marginTop"                => 5,
                        "borderBottomWidth"        => 4,
                        "borderColorHover"         => "rgb(255,0,0)",
                        "backgroundColorFromHover" => "rgba(0,0,255,0.7)",
                    ],
                    "itemDesignTextModel"       => [
                        "size" => 30
                    ],
                    "style"                     => 0
                ],
                [
                    "containerDesignBlockModel" => [
                        "marginTop"                => 5,
                        "borderBottomWidth"        => 4,
                        "borderColorHover"         => "rgb(255,0,0)",
                        "backgroundColorFromHover" => "rgba(0,0,255,0.7)",
                    ],
                    "itemDesignBlockModel"      => [
                        "marginTop"                => 5,
                        "borderBottomWidth"        => 4,
                        "borderColorHover"         => "rgb(255,0,0)",
                        "backgroundColorFromHover" => "rgba(0,0,255,0.7)",
                    ],
                    "itemDesignTextModel"       => [
                        "size" => 30
                    ],
                    "style"                     => 0
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
                    "itemDesignBlockModel"      => "incorrect",
                    "itemDesignTextModel"       => "incorrect",
                    "style"                     => "incorrect",
                ],
                [
                    "containerDesignBlockModel" => [
                        "marginTop" => 0
                    ],
                    "itemDesignBlockModel"      => [
                        "marginTop" => 0
                    ],
                    "itemDesignTextModel"       => [
                        "size" => 0
                    ],
                    "style"                     => 0
                ],
                [
                    "style" => 999,
                ],
                [
                    "style" => 0,
                ],
            ],
            "incorrect2" => [
                [
                    "style" => " 1 ",
                ],
                [
                    "style" => 1,
                ],
                [
                    "containerDesignBlockModel" => [
                        "marginTop" => " 500 "
                    ],
                    "style"                     => true,
                ],
                [
                    "containerDesignBlockModel" => [
                        "marginTop" => 500
                    ],
                    "style"                     => 1,
                ],
            ],
            "incorrect3" => [
                [
                    "containerDesignBlockId" => 99999,
                ],
                [],
                [],
                [],
                self::EXCEPTION_MODEL
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
                "itemDesignBlockModel"      => [
                    "marginTop"                => 10,
                    "borderBottomWidth"        => 7,
                    "borderColorHover"         => "rgb(0,255,0)",
                    "backgroundColorFromHover" => "rgba(255,0,255,0.5)",
                ],
                "itemDesignTextModel"       => [
                    "size" => 20
                ],
                "style"                     => 1
            ],
            [
                "containerDesignBlockModel" => [
                    "marginTop"                => 10,
                    "borderBottomWidth"        => 7,
                    "borderColorHover"         => "rgb(0,255,0)",
                    "backgroundColorFromHover" => "rgba(255,0,255,0.5)",
                ],
                "itemDesignBlockModel"      => [
                    "marginTop"                => 10,
                    "borderBottomWidth"        => 7,
                    "borderColorHover"         => "rgb(0,255,0)",
                    "backgroundColorFromHover" => "rgba(255,0,255,0.5)",
                ],
                "itemDesignTextModel"       => [
                    "size" => 20
                ],
                "style"                     => 1
            ]
        );
    }
}