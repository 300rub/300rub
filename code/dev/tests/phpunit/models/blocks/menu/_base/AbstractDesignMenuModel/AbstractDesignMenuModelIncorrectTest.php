<?php

namespace ss\tests\phpunit\models\blocks\menu\_base\AbstractDesignMenuModel;

use ss\models\blocks\menu\DesignMenuModel;
use ss\tests\phpunit\models\_abstract\_base\AbstractIncorrectModelTest;

/**
 * Tests for the model AbstractDesignMenuModel
 */
class AbstractDesignMenuModelIncorrectTest extends AbstractIncorrectModelTest
{

    /**
     * Gets model name
     *
     * @return DesignMenuModel
     */
    protected function getNewModel()
    {
        return new DesignMenuModel();
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
                    'containerDesignBlockModel'   => 'incorrect',
                    'firstLevelDesignBlockModel'  => 'incorrect',
                    'firstLevelDesignTextModel'   => 'incorrect',
                    'secondLevelDesignBlockModel' => 'incorrect',
                    'secondLevelDesignTextModel'  => 'incorrect',
                    'lastLevelDesignBlockModel'   => 'incorrect',
                    'lastLevelDesignTextModel'    => 'incorrect',
                ],
                [
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
                [
                    'containerDesignBlockModel'   => [
                        'marginTop' => ' 500 '
                    ],
                    'firstLevelDesignBlockModel'  => [
                        'marginTop' => ' 500 '
                    ],
                    'firstLevelDesignTextModel'   => [
                        'size' => ' 500 '
                    ],
                    'secondLevelDesignBlockModel' => [
                        'marginTop' => ' 500 '
                    ],
                    'secondLevelDesignTextModel'  => [
                        'size' => ' 500 '
                    ],
                    'lastLevelDesignBlockModel'   => [
                        'marginTop' => ' 500 '
                    ],
                    'lastLevelDesignTextModel'    => [
                        'size' => ' 500 '
                    ],
                ],
                [
                    'containerDesignBlockModel'   => [
                        'marginTop' => 500
                    ],
                    'firstLevelDesignBlockModel'  => [
                        'marginTop' => 500
                    ],
                    'firstLevelDesignTextModel'   => [
                        'size' => 500
                    ],
                    'secondLevelDesignBlockModel' => [
                        'marginTop' => 500
                    ],
                    'secondLevelDesignTextModel'  => [
                        'size' => 500
                    ],
                    'lastLevelDesignBlockModel'   => [
                        'marginTop' => 500
                    ],
                    'lastLevelDesignTextModel'    => [
                        'size' => 500
                    ],
                ],
            ]
        ];
    }
}
