<?php

namespace testS\tests\unit\models;

use testS\models\FieldModel;

/**
 * Tests for the model FieldModel
 *
 * @package testS\tests\unit\models
 */
class FieldModelTest extends AbstractModelTest
{

    /**
     * Gets model name
     *
     * @return FieldModel
     */
    protected function getNewModel()
    {
        return new FieldModel();
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
                    "designFieldModel" => [
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
                    ]
                ],
                [
                    "designFieldModel" => ""
                ],
                [
                    "designFieldModel" => [
                        "shortCardContainerDesignBlockModel" => [
                            "marginTop" => 0
                        ],
                    ]
                ]
            ],
            "empty2" => [
                [
                    "designFieldModel" => null,
                ],
                [
                    "designFieldModel" => [
                        "shortCardContainerDesignBlockModel" => [
                            "marginTop" => 0
                        ],
                    ]
                ],
                [
                    "designFieldModel" => [
                        "shortCardContainerDesignBlockModel" => [
                            "marginTop" => " "
                        ],
                    ]
                ],
                [
                    "designFieldModel" => [
                        "shortCardContainerDesignBlockModel" => [
                            "marginTop" => 0
                        ],
                    ]
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
                    "designFieldModel" => [
                        "shortCardContainerDesignBlockModel" => [
                            "marginTop" => 10
                        ],
                        "shortCardLabelDesignBlockModel"     => [
                            "marginTop" => 20
                        ],
                        "shortCardLabelDesignTextModel"      => [
                            "size" => 30
                        ],
                        "shortCardValueDesignBlockModel"     => [
                            "marginTop" => 40
                        ],
                    ],
                ],
                [
                    "designFieldModel" => [
                        "shortCardContainerDesignBlockModel" => [
                            "marginTop" => 10
                        ],
                        "shortCardLabelDesignBlockModel"     => [
                            "marginTop" => 20
                        ],
                        "shortCardLabelDesignTextModel"      => [
                            "size" => 30
                        ],
                        "shortCardValueDesignBlockModel"     => [
                            "marginTop" => 40
                        ],
                    ],
                ],
                [
                    "designFieldModel" => [
                        "shortCardContainerDesignBlockModel" => [
                            "marginTop" => 15
                        ],
                        "shortCardLabelDesignBlockModel"     => [
                            "marginTop" => 25
                        ],
                        "shortCardLabelDesignTextModel"      => [
                            "size" => 35
                        ],
                        "shortCardValueDesignBlockModel"     => [
                            "marginTop" => 45
                        ],
                    ],
                ],
                [
                    "designFieldModel" => [
                        "shortCardContainerDesignBlockModel" => [
                            "marginTop" => 15
                        ],
                        "shortCardLabelDesignBlockModel"     => [
                            "marginTop" => 25
                        ],
                        "shortCardLabelDesignTextModel"      => [
                            "size" => 35
                        ],
                        "shortCardValueDesignBlockModel"     => [
                            "marginTop" => 45
                        ],
                    ],
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
                    "designFieldModel" => "incorrect"
                ],
                [
                    "designFieldModel" => [
                        "shortCardContainerDesignBlockModel" => [
                            "marginTop" => 0
                        ],
                    ]
                ],
                [
                    "designFieldModel" => [
                        "shortCardContainerDesignBlockModel" => "incorrect",
                    ]
                ],
                [
                    "designFieldModel" => [
                        "shortCardContainerDesignBlockModel" => [
                            "marginTop" => 0
                        ],
                    ]
                ],
            ],
            "incorrect2" => [
                [
                    "designFieldModel" => [
                        "shortCardContainerDesignBlockModel" => [
                            "marginTop" => "incorrect"
                        ],
                    ]
                ],
                [
                    "designFieldModel" => [
                        "shortCardContainerDesignBlockModel" => [
                            "marginTop" => 0
                        ],
                    ]
                ],
                [
                    "designFieldModel" => [
                        "shortCardContainerDesignBlockModel" => [
                            "marginTop" => " 50 ds"
                        ],
                    ]
                ],
                [
                    "designFieldModel" => [
                        "shortCardContainerDesignBlockModel" => [
                            "marginTop" => 50
                        ],
                    ]
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
                "designFieldModel" => [
                    "shortCardContainerDesignBlockModel" => [
                        "marginTop" => 10
                    ],
                    "shortCardLabelDesignBlockModel"     => [
                        "marginTop" => 20
                    ],
                    "shortCardLabelDesignTextModel"      => [
                        "size" => 30
                    ],
                    "shortCardValueDesignBlockModel"     => [
                        "marginTop" => 40
                    ],
                ],
            ],
            [
                "designFieldModel" => [
                    "shortCardContainerDesignBlockModel" => [
                        "marginTop" => 10
                    ],
                    "shortCardLabelDesignBlockModel"     => [
                        "marginTop" => 20
                    ],
                    "shortCardLabelDesignTextModel"      => [
                        "size" => 30
                    ],
                    "shortCardValueDesignBlockModel"     => [
                        "marginTop" => 40
                    ],
                ],
            ]
        );
    }
}