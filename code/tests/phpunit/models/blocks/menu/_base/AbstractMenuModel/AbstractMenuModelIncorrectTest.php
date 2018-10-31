<?php

namespace ss\tests\phpunit\models\blocks\menu\_base\AbstractMenuModel;

use ss\models\blocks\menu\MenuModel;
use ss\tests\phpunit\models\_abstract\_base\AbstractIncorrectModelTest;

/**
 * Tests for the model AbstractMenuModel
 */
class AbstractMenuModelIncorrectTest extends AbstractIncorrectModelTest
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
     * Data provider for CRUD. Incorrect values
     *
     * @return array
     */
    protected function getDataProviderIncorrect()
    {
        return [
            'incorrect1' => [
                [
                    'designMenuModel' => 'incorrect',
                    'type'            => 'incorrect',
                ],
                [
                    'designMenuModel' => [
                        'containerDesignBlockModel'   => [
                            'marginTop' => 0
                        ],
                        'firstLevelDesignBlockModel'  => [
                            'marginTop' => 0
                        ],
                        'firstLevelDesignTextModel'   => [
                            'size' => 0
                        ],
                        'secondLevelDesignBlockModel' => [
                            'marginTop' => 0
                        ],
                        'secondLevelDesignTextModel'  => [
                            'size' => 0
                        ],
                        'lastLevelDesignBlockModel'   => [
                            'marginTop' => 0
                        ],
                        'lastLevelDesignTextModel'    => [
                            'size' => 0
                        ],
                    ],
                    'type'            => 0,
                ],
                [
                    'designMenuModel' => [
                        'containerDesignBlockModel'   => [
                            'marginTop' => ' 45d '
                        ],
                        'firstLevelDesignBlockModel'  => [
                            'marginTop' => ' 45d '
                        ],
                        'firstLevelDesignTextModel'   => [
                            'size' => ' 45d '
                        ],
                        'secondLevelDesignBlockModel' => [
                            'marginTop' => ' 45d '
                        ],
                        'secondLevelDesignTextModel'  => [
                            'size' => ' 45d '
                        ],
                        'lastLevelDesignBlockModel'   => [
                            'marginTop' => ' 45d '
                        ],
                        'lastLevelDesignTextModel'    => [
                            'size' => ' 45d '
                        ],
                    ],
                    'type'            => 999,
                ],
                [
                    'designMenuModel' => [
                        'containerDesignBlockModel'   => [
                            'marginTop' => 45
                        ],
                        'firstLevelDesignBlockModel'  => [
                            'marginTop' => 45
                        ],
                        'firstLevelDesignTextModel'   => [
                            'size' => 45
                        ],
                        'secondLevelDesignBlockModel' => [
                            'marginTop' => 45
                        ],
                        'secondLevelDesignTextModel'  => [
                            'size' => 45
                        ],
                        'lastLevelDesignBlockModel'   => [
                            'marginTop' => 45
                        ],
                        'lastLevelDesignTextModel'    => [
                            'size' => 45
                        ],
                    ],
                    'type'            => 0,
                ],
            ]
        ];
    }
}
