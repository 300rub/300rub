<?php

namespace testS\tests\unit\models;

use testS\models\FormInstanceModel;

/**
 * Tests for the model FormInstanceModel
 *
 * @package testS\tests\unit\models
 */
class FormInstanceModelTest extends AbstractModelTest
{

    /**
     * Gets model name
     *
     * @return FormInstanceModel
     */
    protected function getNewModel()
    {
        return new FormInstanceModel();
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
                    "label" => ["required"],
                ]
            ],
            "empty2" => [
                [
                    "formModel"      => "",
                    "sort"           => "",
                    "label"          => "",
                    "isRequired"     => "",
                    "validationType" => "",
                    "type"           => "",
                ],
                [
                    "label" => ["required"],
                ]
            ],
            "empty3" => [
                [
                    "formModel"      => "",
                    "sort"           => "",
                    "label"          => "Label",
                    "isRequired"     => "",
                    "validationType" => "",
                    "type"           => "",
                ],
                [
                    "formModel"      => [
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
                    "sort"           => 0,
                    "label"          => "Label",
                    "isRequired"     => false,
                    "validationType" => 0,
                    "type"           => 0,
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
                    "formModel"      => [
                        "designFormModel" => [
                            "containerDesignBlockModel" => [
                                "marginTop" => 10
                            ],
                            "lineDesignBlockModel"      => [
                                "marginTop" => 10
                            ],
                            "submitIcon"                => "fa-lock",
                            "submitIconPosition"        => 1,
                            "submitAlignment"           => 1
                        ],
                        "hasLabel"        => true,
                        "successText"     => "Success"
                    ],
                    "sort"           => 10,
                    "label"          => "Label 1",
                    "isRequired"     => true,
                    "validationType" => 1,
                    "type"           => 1,
                ],
                [
                    "formModel"      => [
                        "designFormModel" => [
                            "containerDesignBlockModel" => [
                                "marginTop" => 10
                            ],
                            "lineDesignBlockModel"      => [
                                "marginTop" => 10
                            ],
                            "submitIcon"                => "fa-lock",
                            "submitIconPosition"        => 1,
                            "submitAlignment"           => 1
                        ],
                        "hasLabel"        => true,
                        "successText"     => "Success"
                    ],
                    "sort"           => 10,
                    "label"          => "Label 1",
                    "isRequired"     => true,
                    "validationType" => 1,
                    "type"           => 1,
                ],
                [
                    "formModel"      => [
                        "designFormModel" => [
                            "containerDesignBlockModel" => [
                                "marginTop" => 20
                            ],
                            "lineDesignBlockModel"      => [
                                "marginTop" => 20
                            ],
                            "submitIcon"                => "fa-user",
                            "submitIconPosition"        => 0,
                            "submitAlignment"           => 0
                        ],
                        "hasLabel"        => false,
                        "successText"     => "Success 2"
                    ],
                    "sort"           => 20,
                    "label"          => "Label 2",
                    "isRequired"     => false,
                    "validationType" => 0,
                    "type"           => 0,
                ],
                [
                    "formModel"      => [
                        "designFormModel" => [
                            "containerDesignBlockModel" => [
                                "marginTop" => 20
                            ],
                            "lineDesignBlockModel"      => [
                                "marginTop" => 20
                            ],
                            "submitIcon"                => "fa-user",
                            "submitIconPosition"        => 0,
                            "submitAlignment"           => 0
                        ],
                        "hasLabel"        => false,
                        "successText"     => "Success 2"
                    ],
                    "sort"           => 20,
                    "label"          => "Label 2",
                    "isRequired"     => false,
                    "validationType" => 0,
                    "type"           => 0,
                ],
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
                    "formModel"      => "incorrect",
                    "sort"           => "incorrect",
                    "label"          => 123,
                    "isRequired"     => "incorrect",
                    "validationType" => "incorrect",
                    "type"           => "incorrect",
                ],
                [
                    "formModel"      => [
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
                    "sort"           => 0,
                    "label"          => "123",
                    "isRequired"     => false,
                    "validationType" => 0,
                    "type"           => 0,
                ],
                [
                    "formModel"      => [
                        "designFormModel" => [
                            "containerDesignBlockModel" => [
                                "marginTop" => " 10a "
                            ],
                            "lineDesignBlockModel"      => [
                                "marginTop" => " 10a "
                            ],
                            "submitIcon"                => 123,
                            "submitIconPosition"        => 999,
                            "submitAlignment"           => 999
                        ],
                        "hasLabel"        => 999,
                        "successText"     => 999
                    ],
                    "sort"           => "123 d",
                    "label"          => "123a",
                    "isRequired"     => 999,
                    "validationType" => 999,
                    "type"           => 999,
                ],
                [
                    "formModel"      => [
                        "designFormModel" => [
                            "containerDesignBlockModel" => [
                                "marginTop" => 10
                            ],
                            "lineDesignBlockModel"      => [
                                "marginTop" => 10
                            ],
                            "submitIcon"                => "123",
                            "submitIconPosition"        => 0,
                            "submitAlignment"           => 0
                        ],
                        "hasLabel"        => true,
                        "successText"     => "999"
                    ],
                    "sort"           => 123,
                    "label"          => "123a",
                    "isRequired"     => true,
                    "validationType" => 0,
                    "type"           => 0,
                ]
            ],
            "incorrect2" => [
                [
                    "label" => $this->generateStringWithLength(256),
                ],
                [
                    "label" => ["maxLength"]
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
                "formModel"      => [
                    "designFormModel" => [
                        "containerDesignBlockModel" => [
                            "marginTop" => 10
                        ],
                        "lineDesignBlockModel"      => [
                            "marginTop" => 10
                        ],
                        "submitIcon"                => "fa-lock",
                        "submitIconPosition"        => 1,
                        "submitAlignment"           => 1
                    ],
                    "hasLabel"        => true,
                    "successText"     => "Success"
                ],
                "sort"           => 10,
                "label"          => "Label 1",
                "isRequired"     => true,
                "validationType" => 1,
                "type"           => 1,
            ],
            [
                "formModel"      => [
                    "designFormModel" => [
                        "containerDesignBlockModel" => [
                            "marginTop" => 10
                        ],
                        "lineDesignBlockModel"      => [
                            "marginTop" => 10
                        ],
                        "submitIcon"                => "fa-lock",
                        "submitIconPosition"        => 1,
                        "submitAlignment"           => 1
                    ],
                    "hasLabel"        => true,
                    "successText"     => "Success"
                ],
                "sort"           => 10,
                "label"          => "Label 1",
                "isRequired"     => true,
                "validationType" => 1,
                "type"           => 1,
            ]
        );
    }
}