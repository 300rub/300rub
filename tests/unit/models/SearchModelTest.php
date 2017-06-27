<?php

namespace testS\tests\unit\models;

use testS\models\SearchModel;

/**
 * Tests for the model SearchModel
 *
 * @package testS\tests\unit\models
 */
class SearchModelTest extends AbstractModelTest
{

    /**
     * Gets model name
     *
     * @return SearchModel
     */
    protected function getNewModel()
    {
        return new SearchModel();
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
                    "formModel"         => [
                        "designFormModel" => [
                            "containerDesignBlockModel" => [
                                "marginTop" => 0
                            ],
                            "lineDesignBlockModel"      => [
                                "marginTop" => 0
                            ],
                            "submitIcon"                => "",
                            "submitIconPosition"        => 0,
                            "submitAlignment"           => 0
                        ],
                        "hasLabel"        => false,
                        "successText"     => ""
                    ],
                    "searchDesignModel" => [
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
            ],
            "empty2" => [
                [
                    "formModelId"    => 0,
                    "searchDesignId" => 0,
                ],
                [
                    "formModel"         => [
                        "designFormModel" => [
                            "containerDesignBlockModel" => [
                                "marginTop" => 0
                            ],
                            "lineDesignBlockModel"      => [
                                "marginTop" => 0
                            ],
                            "submitIcon"                => "",
                            "submitIconPosition"        => 0,
                            "submitAlignment"           => 0
                        ],
                        "hasLabel"        => false,
                        "successText"     => ""
                    ],
                    "searchDesignModel" => [
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
                    "formModel"         => [
                        "designFormModel" => [
                            "containerDesignBlockModel" => [
                                "marginTop" => 400
                            ],
                            "lineDesignBlockModel"      => [
                                "marginTop" => 500
                            ],
                            "submitIcon"                => "fa-lock",
                            "submitIconPosition"        => 1,
                            "submitAlignment"           => 1
                        ],
                        "hasLabel"        => true,
                        "successText"     => "Thanks!"
                    ],
                    "searchDesignModel" => [
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
                ],
                [
                    "formModel"         => [
                        "designFormModel" => [
                            "containerDesignBlockModel" => [
                                "marginTop" => 400
                            ],
                            "lineDesignBlockModel"      => [
                                "marginTop" => 500
                            ],
                            "submitIcon"                => "fa-lock",
                            "submitIconPosition"        => 1,
                            "submitAlignment"           => 1
                        ],
                        "hasLabel"        => true,
                        "successText"     => "Thanks!"
                    ],
                    "searchDesignModel" => [
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
                ],
                [
                    "formModel"         => [
                        "designFormModel" => [
                            "containerDesignBlockModel" => [
                                "marginTop" => 300
                            ],
                            "lineDesignBlockModel"      => [
                                "marginTop" => 200
                            ],
                            "submitIcon"                => "fa-check",
                            "submitIconPosition"        => 0,
                            "submitAlignment"           => 0
                        ],
                        "hasLabel"        => false,
                        "successText"     => "Text"
                    ],
                    "searchDesignModel" => [
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
                [
                    "formModel"         => [
                        "designFormModel" => [
                            "containerDesignBlockModel" => [
                                "marginTop" => 300
                            ],
                            "lineDesignBlockModel"      => [
                                "marginTop" => 200
                            ],
                            "submitIcon"                => "fa-check",
                            "submitIconPosition"        => 0,
                            "submitAlignment"           => 0
                        ],
                        "hasLabel"        => false,
                        "successText"     => "Text"
                    ],
                    "searchDesignModel" => [
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
                ]
            ]
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
                    "formModelId"    => 0,
                    "searchDesignId" => 0,
                ],
                [
                    "formModel"         => [
                        "designFormModel" => [
                            "containerDesignBlockModel" => [
                                "marginTop" => 0
                            ],
                            "lineDesignBlockModel"      => [
                                "marginTop" => 0
                            ],
                            "submitIcon"                => "",
                            "submitIconPosition"        => 0,
                            "submitAlignment"           => 0
                        ],
                        "hasLabel"        => false,
                        "successText"     => ""
                    ],
                    "searchDesignModel" => [
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
                [
                    "formModel" => [
                        "designFormModel"   => [
                            "containerDesignBlockModel" => [
                                "marginTop" => " 10a "
                            ],
                        ],
                        "hasLabel"                  => "asadasd",
                    ],
                    "searchDesignModel" => [
                        "containerDesignBlockModel" => [
                            "marginTop" => "120 a"
                        ],
                    ]
                ],
                [
                    "formModel" => [
                        "designFormModel"   => [
                            "containerDesignBlockModel" => [
                                "marginTop" => 10
                            ],
                        ],
                        "hasLabel"                  => false,
                    ],
                    "searchDesignModel" => [
                        "containerDesignBlockModel" => [
                            "marginTop" => 120
                        ],
                    ]
                ]
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
                "formModel"         => [
                    "designFormModel" => [
                        "containerDesignBlockModel" => [
                            "marginTop" => 400
                        ],
                        "lineDesignBlockModel"      => [
                            "marginTop" => 500
                        ],
                        "submitIcon"                => "fa-lock",
                        "submitIconPosition"        => 1,
                        "submitAlignment"           => 1
                    ],
                    "hasLabel"        => true,
                    "successText"     => "Thanks!"
                ],
                "searchDesignModel" => [
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
            ],
            [
                "formModel"         => [
                    "designFormModel" => [
                        "containerDesignBlockModel" => [
                            "marginTop" => 400
                        ],
                        "lineDesignBlockModel"      => [
                            "marginTop" => 500
                        ],
                        "submitIcon"                => "fa-lock",
                        "submitIconPosition"        => 1,
                        "submitAlignment"           => 1
                    ],
                    "hasLabel"        => true,
                    "successText"     => "Thanks!"
                ],
                "searchDesignModel" => [
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
            ]
        );
    }
}