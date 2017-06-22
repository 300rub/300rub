<?php

namespace testS\tests\unit\models;

use testS\models\FeedbackModel;

/**
 * Tests for the model FeedbackModel
 *
 * @package testS\tests\unit\models
 */
class FeedbackModelTest extends AbstractModelTest
{

    /**
     * Gets model name
     *
     * @return FeedbackModel
     */
    protected function getNewModel()
    {
        return new FeedbackModel();
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
                    "subjectFormInstanceModel" => [
                        "label" => ["required"],
                    ],
                ]
            ],
            "empty2" => [
                [
                    "formModel"                => "",
                    "subjectFormInstanceModel" => "",
                    "subjectText"              => "",
                    "host"                     => "",
                    "port"                     => "",
                    "type"                     => "",
                    "user"                     => "",
                    "password"                 => "",
                ],
                [
                    "subjectFormInstanceModel" => [
                        "label" => ["required"],
                    ],
                ]
            ],
            "empty3" => [
                [
                    "subjectFormInstanceModel" => [
                        "label" => "Label",
                    ],
                ],
                [
                    "formModel"                => [
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
                    "subjectFormInstanceModel" => [
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
                    ],
                    "subjectText"              => "",
                    "host"                     => "",
                    "port"                     => 0,
                    "type"                     => "",
                    "user"                     => "",
                    "password"                 => "",
                ]
            ],
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
                    "formModel"                => [
                        "designFormModel" => [
                            "containerDesignBlockModel" => [
                                "marginTop" => 10
                            ],
                            "lineDesignBlockModel"      => [
                                "marginTop" => 10
                            ],
                            "submitIcon"                => "icon",
                            "submitIconPosition"        => 1,
                            "submitAlignment"           => 1
                        ],
                        "hasLabel"        => true,
                        "successText"     => "Success"
                    ],
                    "subjectFormInstanceModel" => [
                        "formModel"      => [
                            "designFormModel" => [
                                "containerDesignBlockModel" => [
                                    "marginTop" => 20
                                ],
                                "lineDesignBlockModel"      => [
                                    "marginTop" => 20
                                ],
                                "submitIcon"                => "icon-2",
                                "submitIconPosition"        => 1,
                                "submitAlignment"           => 1
                            ],
                            "hasLabel"        => true,
                            "successText"     => "S"
                        ],
                        "sort"           => 10,
                        "label"          => "Label 3",
                        "isRequired"     => true,
                        "validationType" => 1,
                        "type"           => 1,
                    ],
                    "subjectText"              => "Subject",
                    "host"                     => "127.0.0.1",
                    "port"                     => 80,
                    "type"                     => "smtp",
                    "user"                     => "user",
                    "password"                 => "pass",
                ],
                [
                    "formModel"                => [
                        "designFormModel" => [
                            "containerDesignBlockModel" => [
                                "marginTop" => 10
                            ],
                            "lineDesignBlockModel"      => [
                                "marginTop" => 10
                            ],
                            "submitIcon"                => "icon",
                            "submitIconPosition"        => 1,
                            "submitAlignment"           => 1
                        ],
                        "hasLabel"        => true,
                        "successText"     => "Success"
                    ],
                    "subjectFormInstanceModel" => [
                        "formModel"      => [
                            "designFormModel" => [
                                "containerDesignBlockModel" => [
                                    "marginTop" => 20
                                ],
                                "lineDesignBlockModel"      => [
                                    "marginTop" => 20
                                ],
                                "submitIcon"                => "icon-2",
                                "submitIconPosition"        => 1,
                                "submitAlignment"           => 1
                            ],
                            "hasLabel"        => true,
                            "successText"     => "S"
                        ],
                        "sort"           => 10,
                        "label"          => "Label 3",
                        "isRequired"     => true,
                        "validationType" => 1,
                        "type"           => 1,
                    ],
                    "subjectText"              => "Subject",
                    "host"                     => "127.0.0.1",
                    "port"                     => 80,
                    "type"                     => "smtp",
                    "user"                     => "user",
                    "password"                 => "pass",
                ],
                [
                    "formModel"                => [
                        "designFormModel" => [
                            "containerDesignBlockModel" => [
                                "marginTop" => 30
                            ],
                            "lineDesignBlockModel"      => [
                                "marginTop" => 30
                            ],
                            "submitIcon"                => "icon-5",
                            "submitIconPosition"        => 0,
                            "submitAlignment"           => 0
                        ],
                        "hasLabel"        => false,
                        "successText"     => "Success 2"
                    ],
                    "subjectFormInstanceModel" => [
                        "formModel"      => [
                            "designFormModel" => [
                                "containerDesignBlockModel" => [
                                    "marginTop" => 40
                                ],
                                "lineDesignBlockModel"      => [
                                    "marginTop" => 40
                                ],
                                "submitIcon"                => "icon-6",
                                "submitIconPosition"        => 0,
                                "submitAlignment"           => 0
                            ],
                            "hasLabel"        => false,
                            "successText"     => "Success 7"
                        ],
                        "sort"           => 20,
                        "label"          => "Label 30",
                        "isRequired"     => false,
                        "validationType" => 0,
                        "type"           => 0,
                    ],
                    "subjectText"              => "Subject 23",
                    "host"                     => "127.0.0.2",
                    "port"                     => 1000,
                    "type"                     => "",
                    "user"                     => "user2",
                    "password"                 => "pass2",
                ],
                [
                    "formModel"                => [
                        "designFormModel" => [
                            "containerDesignBlockModel" => [
                                "marginTop" => 30
                            ],
                            "lineDesignBlockModel"      => [
                                "marginTop" => 30
                            ],
                            "submitIcon"                => "icon-5",
                            "submitIconPosition"        => 0,
                            "submitAlignment"           => 0
                        ],
                        "hasLabel"        => false,
                        "successText"     => "Success 2"
                    ],
                    "subjectFormInstanceModel" => [
                        "formModel"      => [
                            "designFormModel" => [
                                "containerDesignBlockModel" => [
                                    "marginTop" => 40
                                ],
                                "lineDesignBlockModel"      => [
                                    "marginTop" => 40
                                ],
                                "submitIcon"                => "icon-6",
                                "submitIconPosition"        => 0,
                                "submitAlignment"           => 0
                            ],
                            "hasLabel"        => false,
                            "successText"     => "Success 7"
                        ],
                        "sort"           => 20,
                        "label"          => "Label 30",
                        "isRequired"     => false,
                        "validationType" => 0,
                        "type"           => 0,
                    ],
                    "subjectText"              => "Subject 23",
                    "host"                     => "127.0.0.2",
                    "port"                     => 1000,
                    "type"                     => "",
                    "user"                     => "user2",
                    "password"                 => "pass2",
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
                    "formModel"                => "incorrect",
                    "subjectFormInstanceModel" => "incorrect",
                    "subjectText"              => "incorrect",
                    "host"                     => "incorrect",
                    "port"                     => "incorrect",
                    "type"                     => "incorrect",
                    "user"                     => "incorrect",
                    "password"                 => "incorrect",
                ],
                [
                    "subjectFormInstanceModel" => [
                        "label" => ["required"],
                    ],
                ]
            ],
            "incorrect2" => [
                [
                    "formModel"                => [
                        "designFormModel" => [
                            "containerDesignBlockModel" => [
                                "marginTop" => "10 a"
                            ],
                            "lineDesignBlockModel"      => [
                                "marginTop" => " 10 "
                            ],
                            "submitIcon"                => " icon ",
                            "submitIconPosition"        => "1s",
                            "submitAlignment"           => "1"
                        ],
                        "hasLabel"        => 999,
                        "successText"     => " <b>Success "
                    ],
                    "subjectFormInstanceModel" => [
                        "formModel"      => [
                            "designFormModel" => [
                                "containerDesignBlockModel" => [
                                    "marginTop" => "20"
                                ],
                                "lineDesignBlockModel"      => [
                                    "marginTop" => "20"
                                ],
                                "submitIcon"                => "  <b> icon-2  ",
                                "submitIconPosition"        => "1",
                                "submitAlignment"           => "1"
                            ],
                            "hasLabel"        => "true",
                            "successText"     => "S"
                        ],
                        "sort"           => "10",
                        "label"          => "Label 3  <b>",
                        "isRequired"     => "true",
                        "validationType" => "1",
                        "type"           => "1",
                    ],
                    "subjectText"              => "  Subject  ",
                    "host"                     => "  127.0.0.1  ",
                    "port"                     => "80",
                    "type"                     => "<b> smtp",
                    "user"                     => " user ",
                    "password"                 => " pass ",
                ],
                [
                    "formModel"                => [
                        "designFormModel" => [
                            "containerDesignBlockModel" => [
                                "marginTop" => 10
                            ],
                            "lineDesignBlockModel"      => [
                                "marginTop" => 10
                            ],
                            "submitIcon"                => "icon",
                            "submitIconPosition"        => 1,
                            "submitAlignment"           => 1
                        ],
                        "hasLabel"        => true,
                        "successText"     => "Success"
                    ],
                    "subjectFormInstanceModel" => [
                        "formModel"      => [
                            "designFormModel" => [
                                "containerDesignBlockModel" => [
                                    "marginTop" => 20
                                ],
                                "lineDesignBlockModel"      => [
                                    "marginTop" => 20
                                ],
                                "submitIcon"                => "icon-2",
                                "submitIconPosition"        => 1,
                                "submitAlignment"           => 1
                            ],
                            "hasLabel"        => true,
                            "successText"     => "S"
                        ],
                        "sort"           => 10,
                        "label"          => "Label 3",
                        "isRequired"     => true,
                        "validationType" => 1,
                        "type"           => 1,
                    ],
                    "subjectText"              => "Subject",
                    "host"                     => "127.0.0.1",
                    "port"                     => 80,
                    "type"                     => "smtp",
                    "user"                     => "user",
                    "password"                 => "pass",
                ],
            ],
            "incorrect3" => [
                [
                    "subjectFormInstanceModel" => [
                        "label" => "Label",
                    ],
                    "subjectText"              => "<b>incorrect",
                    "host"                     => "<b>incorrect",
                    "port"                     => "<b>incorrect",
                    "type"                     => "<b>incorrect",
                    "user"                     => "<b>incorrect",
                    "password"                 => "<b>incorrect",
                ],
                [
                    "subjectText" => "incorrect",
                    "host"        => "<b>incorrect",
                    "port"        => 0,
                    "type"        => "incorrect",
                    "user"        => "incorrect",
                    "password"    => "<b>incorrect",
                ]
            ],
            "incorrect4" => [
                [
                    "subjectFormInstanceModel" => [
                        "label" => "Label",
                    ],
                    "subjectText"              => $this->generateStringWithLength(256),
                    "host"                     => $this->generateStringWithLength(256),
                    "type"                     => $this->generateStringWithLength(26),
                    "user"                     => $this->generateStringWithLength(256),
                    "password"                 => $this->generateStringWithLength(256),
                ],
                [
                    "subjectText" => ["maxLength"],
                    "host"        => ["maxLength"],
                    "type"        => ["maxLength"],
                    "user"        => ["maxLength"],
                    "password"    => ["maxLength"],
                ]
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
                "formModel"                => [
                    "designFormModel" => [
                        "containerDesignBlockModel" => [
                            "marginTop" => 10
                        ],
                        "lineDesignBlockModel"      => [
                            "marginTop" => 10
                        ],
                        "submitIcon"                => "icon",
                        "submitIconPosition"        => 1,
                        "submitAlignment"           => 1
                    ],
                    "hasLabel"        => true,
                    "successText"     => "Success"
                ],
                "subjectFormInstanceModel" => [
                    "formModel"      => [
                        "designFormModel" => [
                            "containerDesignBlockModel" => [
                                "marginTop" => 20
                            ],
                            "lineDesignBlockModel"      => [
                                "marginTop" => 20
                            ],
                            "submitIcon"                => "icon-2",
                            "submitIconPosition"        => 1,
                            "submitAlignment"           => 1
                        ],
                        "hasLabel"        => true,
                        "successText"     => "S"
                    ],
                    "sort"           => 10,
                    "label"          => "Label 3",
                    "isRequired"     => true,
                    "validationType" => 1,
                    "type"           => 1,
                ],
                "subjectText"              => "Subject",
                "host"                     => "127.0.0.1",
                "port"                     => 80,
                "type"                     => "smtp",
                "user"                     => "user",
                "password"                 => "pass",
            ],
            [
                "formModel"                => [
                    "designFormModel" => [
                        "containerDesignBlockModel" => [
                            "marginTop" => 10
                        ],
                        "lineDesignBlockModel"      => [
                            "marginTop" => 10
                        ],
                        "submitIcon"                => "icon",
                        "submitIconPosition"        => 1,
                        "submitAlignment"           => 1
                    ],
                    "hasLabel"        => true,
                    "successText"     => "Success"
                ],
                "subjectFormInstanceModel" => [
                    "formModel"      => [
                        "designFormModel" => [
                            "containerDesignBlockModel" => [
                                "marginTop" => 20
                            ],
                            "lineDesignBlockModel"      => [
                                "marginTop" => 20
                            ],
                            "submitIcon"                => "icon-2",
                            "submitIconPosition"        => 1,
                            "submitAlignment"           => 1
                        ],
                        "hasLabel"        => true,
                        "successText"     => "S"
                    ],
                    "sort"           => 10,
                    "label"          => "Label 3",
                    "isRequired"     => true,
                    "validationType" => 1,
                    "type"           => 1,
                ],
                "subjectText"              => "Subject",
                "host"                     => "127.0.0.1",
                "port"                     => 80,
                "type"                     => "smtp",
                "user"                     => "user",
                "password"                 => "pass",
            ]
        );
    }
}