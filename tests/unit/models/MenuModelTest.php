<?php

namespace testS\tests\unit\models;

use testS\models\MenuModel;

/**
 * Tests for the model MenuModel
 *
 * @package testS\tests\unit\models
 */
class MenuModelTest extends AbstractModelTest
{

    /**
     * Gets model name
     *
     * @return string
     */
    protected function getNewModel()
    {
        return new MenuModel();
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
                    "designMenuModel" => [
                        "containerDesignBlockModel"   => [
                            "marginTop" => 0
                        ],
                        "firstLevelDesignBlockModel"  => [
                            "marginTop" => 0
                        ],
                        "firstLevelDesignTextModel"   => [
                            "size" => 0
                        ],
                        "secondLevelDesignBlockModel" => [
                            "marginTop" => 0
                        ],
                        "secondLevelDesignTextModel"  => [
                            "size" => 0
                        ],
                        "lastLevelDesignBlockModel"   => [
                            "marginTop" => 0
                        ],
                        "lastLevelDesignTextModel"    => [
                            "size" => 0
                        ],
                    ],
                    "type"            => 0,
                ]
            ],
            "empty2" => [
                [
                    "designMenuModel" => "",
                    "type"            => "",
                ],
                [
                    "designMenuModel" => [
                        "containerDesignBlockModel"   => [
                            "marginTop" => 0
                        ],
                        "firstLevelDesignBlockModel"  => [
                            "marginTop" => 0
                        ],
                        "firstLevelDesignTextModel"   => [
                            "size" => 0
                        ],
                        "secondLevelDesignBlockModel" => [
                            "marginTop" => 0
                        ],
                        "secondLevelDesignTextModel"  => [
                            "size" => 0
                        ],
                        "lastLevelDesignBlockModel"   => [
                            "marginTop" => 0
                        ],
                        "lastLevelDesignTextModel"    => [
                            "size" => 0
                        ],
                    ],
                    "type"            => 0,
                ],
                [
                    "designMenuModel" => [
                        "containerDesignBlockModel"   => [
                            "marginTop" => ""
                        ],
                        "firstLevelDesignBlockModel"  => [
                            "marginTop" => " "
                        ],
                        "firstLevelDesignTextModel"   => [
                            "size" => " "
                        ],
                        "secondLevelDesignBlockModel" => [
                            "marginTop" => " "
                        ],
                        "secondLevelDesignTextModel"  => [
                            "size" => " "
                        ],
                        "lastLevelDesignBlockModel"   => [
                            "marginTop" => " "
                        ],
                        "lastLevelDesignTextModel"    => [
                            "size" => " "
                        ],
                    ],
                    "type"            => " ",
                ],
                [
                    "designMenuModel" => [
                        "containerDesignBlockModel"   => [
                            "marginTop" => 0
                        ],
                        "firstLevelDesignBlockModel"  => [
                            "marginTop" => 0
                        ],
                        "firstLevelDesignTextModel"   => [
                            "size" => 0
                        ],
                        "secondLevelDesignBlockModel" => [
                            "marginTop" => 0
                        ],
                        "secondLevelDesignTextModel"  => [
                            "size" => 0
                        ],
                        "lastLevelDesignBlockModel"   => [
                            "marginTop" => 0
                        ],
                        "lastLevelDesignTextModel"    => [
                            "size" => 0
                        ],
                    ],
                    "type"            => 0,
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
                    "designMenuModel" => [
                        "containerDesignBlockModel"   => [
                            "marginTop" => 10
                        ],
                        "firstLevelDesignBlockModel"  => [
                            "marginTop" => 10
                        ],
                        "firstLevelDesignTextModel"   => [
                            "size" => 10
                        ],
                        "secondLevelDesignBlockModel" => [
                            "marginTop" => 10
                        ],
                        "secondLevelDesignTextModel"  => [
                            "size" => 10
                        ],
                        "lastLevelDesignBlockModel"   => [
                            "marginTop" => 10
                        ],
                        "lastLevelDesignTextModel"    => [
                            "size" => 10
                        ],
                    ],
                    "type"            => 1,
                ],
                [
                    "designMenuModel" => [
                        "containerDesignBlockModel"   => [
                            "marginTop" => 10
                        ],
                        "firstLevelDesignBlockModel"  => [
                            "marginTop" => 10
                        ],
                        "firstLevelDesignTextModel"   => [
                            "size" => 10
                        ],
                        "secondLevelDesignBlockModel" => [
                            "marginTop" => 10
                        ],
                        "secondLevelDesignTextModel"  => [
                            "size" => 10
                        ],
                        "lastLevelDesignBlockModel"   => [
                            "marginTop" => 10
                        ],
                        "lastLevelDesignTextModel"    => [
                            "size" => 10
                        ],
                    ],
                    "type"            => 1,
                ],
                [
                    "designMenuModel" => [
                        "containerDesignBlockModel"   => [
                            "marginTop" => 20
                        ],
                        "firstLevelDesignBlockModel"  => [
                            "marginTop" => 20
                        ],
                        "firstLevelDesignTextModel"   => [
                            "size" => 20
                        ],
                        "secondLevelDesignBlockModel" => [
                            "marginTop" => 20
                        ],
                        "secondLevelDesignTextModel"  => [
                            "size" => 20
                        ],
                        "lastLevelDesignBlockModel"   => [
                            "marginTop" => 20
                        ],
                        "lastLevelDesignTextModel"    => [
                            "size" => 20
                        ],
                    ],
                    "type"            => 0,
                ],
                [
                    "designMenuModel" => [
                        "containerDesignBlockModel"   => [
                            "marginTop" => 20
                        ],
                        "firstLevelDesignBlockModel"  => [
                            "marginTop" => 20
                        ],
                        "firstLevelDesignTextModel"   => [
                            "size" => 20
                        ],
                        "secondLevelDesignBlockModel" => [
                            "marginTop" => 20
                        ],
                        "secondLevelDesignTextModel"  => [
                            "size" => 20
                        ],
                        "lastLevelDesignBlockModel"   => [
                            "marginTop" => 20
                        ],
                        "lastLevelDesignTextModel"    => [
                            "size" => 20
                        ],
                    ],
                    "type"            => 0,
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
                    "designMenuModel" => "incorrect",
                    "type"            => "incorrect",
                ],
                [
                    "designMenuModel" => [
                        "containerDesignBlockModel"   => [
                            "marginTop" => 0
                        ],
                        "firstLevelDesignBlockModel"  => [
                            "marginTop" => 0
                        ],
                        "firstLevelDesignTextModel"   => [
                            "size" => 0
                        ],
                        "secondLevelDesignBlockModel" => [
                            "marginTop" => 0
                        ],
                        "secondLevelDesignTextModel"  => [
                            "size" => 0
                        ],
                        "lastLevelDesignBlockModel"   => [
                            "marginTop" => 0
                        ],
                        "lastLevelDesignTextModel"    => [
                            "size" => 0
                        ],
                    ],
                    "type"            => 0,
                ],
                [
                    "designMenuModel" => [
                        "containerDesignBlockModel"   => [
                            "marginTop" => " 45d "
                        ],
                        "firstLevelDesignBlockModel"  => [
                            "marginTop" => " 45d "
                        ],
                        "firstLevelDesignTextModel"   => [
                            "size" => " 45d "
                        ],
                        "secondLevelDesignBlockModel" => [
                            "marginTop" => " 45d "
                        ],
                        "secondLevelDesignTextModel"  => [
                            "size" => " 45d "
                        ],
                        "lastLevelDesignBlockModel"   => [
                            "marginTop" => " 45d "
                        ],
                        "lastLevelDesignTextModel"    => [
                            "size" => " 45d "
                        ],
                    ],
                    "type"            => 999,
                ],
                [
                    "designMenuModel" => [
                        "containerDesignBlockModel"   => [
                            "marginTop" => 45
                        ],
                        "firstLevelDesignBlockModel"  => [
                            "marginTop" => 45
                        ],
                        "firstLevelDesignTextModel"   => [
                            "size" => 45
                        ],
                        "secondLevelDesignBlockModel" => [
                            "marginTop" => 45
                        ],
                        "secondLevelDesignTextModel"  => [
                            "size" => 45
                        ],
                        "lastLevelDesignBlockModel"   => [
                            "marginTop" => 45
                        ],
                        "lastLevelDesignTextModel"    => [
                            "size" => 45
                        ],
                    ],
                    "type"            => 0,
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
                "designMenuModel" => [
                    "containerDesignBlockModel"   => [
                        "marginTop" => 10
                    ],
                    "firstLevelDesignBlockModel"  => [
                        "marginTop" => 10
                    ],
                    "firstLevelDesignTextModel"   => [
                        "size" => 10
                    ],
                    "secondLevelDesignBlockModel" => [
                        "marginTop" => 10
                    ],
                    "secondLevelDesignTextModel"  => [
                        "size" => 10
                    ],
                    "lastLevelDesignBlockModel"   => [
                        "marginTop" => 10
                    ],
                    "lastLevelDesignTextModel"    => [
                        "size" => 10
                    ],
                ],
                "type"            => 1,
            ],
            [
                "designMenuModel" => [
                    "containerDesignBlockModel"   => [
                        "marginTop" => 10
                    ],
                    "firstLevelDesignBlockModel"  => [
                        "marginTop" => 10
                    ],
                    "firstLevelDesignTextModel"   => [
                        "size" => 10
                    ],
                    "secondLevelDesignBlockModel" => [
                        "marginTop" => 10
                    ],
                    "secondLevelDesignTextModel"  => [
                        "size" => 10
                    ],
                    "lastLevelDesignBlockModel"   => [
                        "marginTop" => 10
                    ],
                    "lastLevelDesignTextModel"    => [
                        "size" => 10
                    ],
                ],
                "type"            => 1,
            ]
        );
    }
}