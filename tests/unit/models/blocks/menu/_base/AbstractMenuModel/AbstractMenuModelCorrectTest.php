<?php

namespace ss\tests\unit\models\blocks\menu\_base\AbstractMenuModel;

use ss\models\blocks\menu\MenuModel;
use ss\tests\unit\models\_abstract\_base\AbstractCorrectModelTest;

/**
 * Tests for the model AbstractMenuModel
 */
class AbstractMenuModelCorrectTest extends AbstractCorrectModelTest
{

    /**
     * Gets model name
     *
     * @return MenuModel
     */
    protected function getNewModel()
    {
        return new MenuModel();
    }

    /**
     * Data provider for CRUD. Correct values
     *
     * @return array
     */
    protected function getDataProviderCorrect()
    {
        return [
            'correct1' => [
                [
                    'designMenuModel' => [
                        'containerDesignBlockModel'   => [
                            'marginTop' => 10
                        ],
                        'firstLevelDesignBlockModel'  => [
                            'marginTop' => 10
                        ],
                        'firstLevelDesignTextModel'   => [
                            'size' => 10
                        ],
                        'secondLevelDesignBlockModel' => [
                            'marginTop' => 10
                        ],
                        'secondLevelDesignTextModel'  => [
                            'size' => 10
                        ],
                        'lastLevelDesignBlockModel'   => [
                            'marginTop' => 10
                        ],
                        'lastLevelDesignTextModel'    => [
                            'size' => 10
                        ],
                    ],
                    'type'            => 1,
                ],
                [
                    'designMenuModel' => [
                        'containerDesignBlockModel'   => [
                            'marginTop' => 10
                        ],
                        'firstLevelDesignBlockModel'  => [
                            'marginTop' => 10
                        ],
                        'firstLevelDesignTextModel'   => [
                            'size' => 10
                        ],
                        'secondLevelDesignBlockModel' => [
                            'marginTop' => 10
                        ],
                        'secondLevelDesignTextModel'  => [
                            'size' => 10
                        ],
                        'lastLevelDesignBlockModel'   => [
                            'marginTop' => 10
                        ],
                        'lastLevelDesignTextModel'    => [
                            'size' => 10
                        ],
                    ],
                    'type'            => 1,
                ],
                [
                    'designMenuModel' => [
                        'secondLevelDesignTextModel'  => [
                            'size' => 20
                        ],
                        'lastLevelDesignBlockModel'   => [
                            'marginTop' => 20
                        ],
                        'lastLevelDesignTextModel'    => [
                            'size' => 20
                        ],
                    ],
                    'type'            => 0,
                ],
                [
                    'designMenuModel' => [
                        'secondLevelDesignTextModel'  => [
                            'size' => 20
                        ],
                        'lastLevelDesignBlockModel'   => [
                            'marginTop' => 20
                        ],
                        'lastLevelDesignTextModel'    => [
                            'size' => 20
                        ],
                    ],
                    'type'            => 0,
                ],
            ]
        ];
    }
}
