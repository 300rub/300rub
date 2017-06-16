<?php

namespace testS\tests\unit\models;

use testS\models\GridLineModel;

/**
 * Tests for the model GridLineModel
 *
 * @package testS\tests\unit\models
 */
class GridLineModelTest extends AbstractModelTest
{

    /**
     * Gets model name
     *
     * @return GridLineModel
     */
    protected function getNewModel()
    {
        return new GridLineModel();
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
                [],
                [],
                [],
                self::EXCEPTION_MODEL
            ],
            "empty2" => [
                [
                    "sectionId"       => "",
                    "outsideDesignId" => "",
                    "insideDesignId"  => "",
                    "sort"            => "",
                ],
                [],
                [],
                [],
                self::EXCEPTION_MODEL
            ],
            "empty3" => [
                [
                    "sectionModel"       => "",
                    "outsideDesignModel" => "",
                    "insideDesignModel"  => "",
                    "sort"               => "",
                ],
                [],
                [],
                [],
                self::EXCEPTION_MODEL
            ],
            "empty4" => [
                [
                    "sectionId"          => 1,
                    "outsideDesignModel" => "",
                    "insideDesignModel"  => "",
                    "sort"               => "",
                ],
                [
                    "sectionId"          => 1,
                    "outsideDesignModel" => [
                        "marginTop" => 0
                    ],
                    "insideDesignModel"  => [
                        "marginTop" => 0
                    ],
                    "sort"               => 0,
                ],
                [
                    "sectionId"          => 1,
                    "outsideDesignModel" => [
                        "marginTop" => " "
                    ],
                    "insideDesignModel"  => [
                        "marginTop" => " "
                    ],
                    "sort"               => " ",
                ],
                [
                    "sectionId"          => 1,
                    "outsideDesignModel" => [
                        "marginTop" => 0
                    ],
                    "insideDesignModel"  => [
                        "marginTop" => 0
                    ],
                    "sort"               => 0,
                ],
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
                    "sectionId"          => 1,
                    "outsideDesignModel" => [
                        "marginTop" => 10
                    ],
                    "insideDesignModel"  => [
                        "marginTop" => 20
                    ],
                    "sort"               => 30,
                ],
                [
                    "sectionId"          => 1,
                    "outsideDesignModel" => [
                        "marginTop" => 10
                    ],
                    "insideDesignModel"  => [
                        "marginTop" => 20
                    ],
                    "sort"               => 30,
                ],
                [
                    "sectionId"          => 1,
                    "outsideDesignModel" => [
                        "marginTop" => 50
                    ],
                    "insideDesignModel"  => [
                        "marginTop" => 60
                    ],
                    "sort"               => 70,
                ],
                [
                    "sectionId"          => 1,
                    "outsideDesignModel" => [
                        "marginTop" => 50
                    ],
                    "insideDesignModel"  => [
                        "marginTop" => 60
                    ],
                    "sort"               => 70,
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
                    "sectionId"       => "incorrect",
                    "outsideDesignId" => "incorrect",
                    "insideDesignId"  => "incorrect",
                    "sort"            => "incorrect",
                ],
                [],
                [],
                [],
                self::EXCEPTION_MODEL
            ],
            "incorrect2" => [
                [
                    "sectionId"       => "1",
                    "outsideDesignId" => "incorrect",
                    "insideDesignId"  => "incorrect",
                    "sort"            => "incorrect",
                ],
                [
                    "sectionId"          => 1,
                    "outsideDesignModel" => [
                        "marginTop" => 0
                    ],
                    "insideDesignModel"  => [
                        "marginTop" => 0
                    ],
                    "sort"               => 0,
                ],
                [
                    "sectionId"          => " 1 ",
                    "outsideDesignModel" => [
                        "marginTop" => " 500 "
                    ],
                    "insideDesignModel"  => [
                        "marginTop" => " 200 a"
                    ],
                    "sort"               => " 32 as",
                ],
                [
                    "sectionId"          => 1,
                    "outsideDesignModel" => [
                        "marginTop" => 500
                    ],
                    "insideDesignModel"  => [
                        "marginTop" => 200
                    ],
                    "sort"               => 32,
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
                "sectionId"          => 1,
                "outsideDesignModel" => [
                    "marginTop" => 10
                ],
                "insideDesignModel"  => [
                    "marginTop" => 20
                ],
                "sort"               => 30,
            ],
            [
                "sectionId"          => 1,
                "outsideDesignModel" => [
                    "marginTop" => 10
                ],
                "insideDesignModel"  => [
                    "marginTop" => 20
                ],
                "sort"               => 30,
            ]
        );
    }
}