<?php

namespace testS\tests\unit\models;

use testS\models\FormModel;

/**
 * Tests for the model FormModel
 *
 * @package testS\tests\unit\models
 */
class FormModelTest extends AbstractModelTest
{

    /**
     * Gets model name
     *
     * @return FormModel
     */
    protected function getNewModel()
    {
        return new FormModel();
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
                [
                    "designFormModel" => "",
                    "hasLabel"        => "",
                    "successText"     => ""
                ],
                [
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
            ],
            "empty2" => [
                [
                    "designFormModel" => null,
                    "hasLabel"        => null,
                    "successText"     => null
                ],
                [
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
                [
                    "designFormModel" => [
                        "containerDesignBlockModel" => [
                            "marginTop" => " "
                        ],
                        "lineDesignBlockModel"      => [
                            "marginTop" => " "
                        ],
                        "submitIcon"                => " ",
                        "submitIconPosition"        => " ",
                        "submitAlignment"           => " "
                    ],
                    "hasLabel"        => " ",
                    "successText"     => " "
                ],
                [
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
            ],
            "empty3" => [
                [
                    "designFormId" => " ",
                ],
                [
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
                [
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
                [
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
                [
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
                    "designFormModel" => "incorrect",
                    "hasLabel"        => "incorrect",
                    "successText"     => [],
                ],
                [
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
                [
                    "designFormModel" => [
                        "containerDesignBlockModel" => [
                            "marginTop" => "incorrect"
                        ],
                        "lineDesignBlockModel"      => [
                            "marginTop" => "incorrect"
                        ],
                        "submitIcon"                => "",
                        "submitIconPosition"        => "incorrect",
                        "submitAlignment"           => "incorrect"
                    ],
                    "hasLabel"        => "fffffffff",
                    "successText"     => "  "
                ],
                [
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
            ],
            "incorrect2" => [
                [
                    "designFormModel" => [
                        "containerDesignBlockModel" => [
                            "marginTop" => " 500 asd"
                        ],
                        "lineDesignBlockModel"      => [
                            "marginTop" => " 1d"
                        ],
                        "submitIcon"                => [],
                        "submitIconPosition"        => " 1",
                        "submitAlignment"           => " 1 s"
                    ],
                    "hasLabel"        => "123",
                    "successText"     => 321
                ],
                [
                    "designFormModel" => [
                        "containerDesignBlockModel" => [
                            "marginTop" => 500
                        ],
                        "lineDesignBlockModel"      => [
                            "marginTop" => 1
                        ],
                        "submitIcon"                => "",
                        "submitIconPosition"        => 1,
                        "submitAlignment"           => 1
                    ],
                    "hasLabel"        => false,
                    "successText"     => "321"
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
            [
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
            ]
        );
    }
}