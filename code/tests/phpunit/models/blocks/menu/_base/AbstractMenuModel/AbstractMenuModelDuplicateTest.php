<?php

namespace ss\tests\phpunit\models\blocks\menu\_base\AbstractMenuModel;

use ss\models\blocks\menu\MenuModel;
use ss\tests\phpunit\models\_abstract\_base\AbstractDuplicateModelTest;

/**
 * Tests for the model AbstractMenuModel
 */
class AbstractMenuModelDuplicateTest extends AbstractDuplicateModelTest
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
     * Data provider for CRUD. Duplicate
     *
     * @return void
     */
    public function testDuplicate()
    {
        $this->duplicate(
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
            ]
        );
    }
}
