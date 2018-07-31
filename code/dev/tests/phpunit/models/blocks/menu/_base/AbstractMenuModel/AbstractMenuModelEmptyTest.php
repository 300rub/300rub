<?php

namespace ss\tests\phpunit\models\blocks\menu\_base\AbstractMenuModel;

use ss\models\blocks\menu\MenuModel;
use ss\tests\phpunit\models\_abstract\_base\AbstractEmptyModelTest;

/**
 * Tests for the model AbstractMenuModel
 */
class AbstractMenuModelEmptyTest extends AbstractEmptyModelTest
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
     * Data provider for CRUD. Empty values
     *
     * @return array
     */
    protected function getDataProviderEmpty()
    {
        return [
            'empty1' => [
                [],
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
                ]
            ],
            'empty2' => [
                [
                    'designMenuModel' => '',
                    'type'            => '',
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
                            'marginTop' => ''
                        ],
                        'firstLevelDesignBlockModel'  => [
                            'marginTop' => ' '
                        ],
                    ],
                    'type'            => ' ',
                ],
                [
                    'designMenuModel' => [
                        'containerDesignBlockModel'   => [
                            'marginTop' => 0
                        ],
                        'firstLevelDesignBlockModel'  => [
                            'marginTop' => 0
                        ],
                    ],
                    'type'            => 0,
                ],
            ]
        ];
    }
}
