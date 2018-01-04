<?php

namespace testS\tests\unit\models\blocks\menu\_base\AbstractMenuModel;

use testS\models\blocks\menu\MenuModel;
use testS\tests\unit\models\_abstract\_base\AbstractEmptyModelTest;

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
