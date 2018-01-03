<?php

namespace testS\tests\unit\models\image\_base\AbstractDesignImageSliderModel;

use testS\models\blocks\image\DesignImageSliderModel;
use testS\tests\unit\models\_abstract\_base\AbstractIncorrectModelTest;

/**
 * Tests for the model AbstractDesignImageSliderModel
 */
// @codingStandardsIgnoreLine
class AbstractDesignImageSliderModelIncorrectTest extends AbstractIncorrectModelTest
{

    /**
     * Gets model name
     *
     * @return DesignImageSliderModel
     */
    protected function getNewModel()
    {
        return new DesignImageSliderModel();
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
                    'navigationDesignBlockModel'  => 'incorrect',
                    'descriptionDesignBlockModel' => 'incorrect',
                    'effect'                      => 'incorrect',
                    'hasAutoPlay'                 => 'incorrect',
                    'playSpeed'                   => 'incorrect',
                    'navigationAlignment'         => 'incorrect',
                    'descriptionAlignment'        => 'incorrect',
                ],
                [
                    'containerDesignBlockModel'   => [
                        'marginTop' => 0
                    ],
                    'navigationDesignBlockModel'  => [
                        'marginTop' => 0
                    ],
                    'descriptionDesignBlockModel' => [
                        'marginTop' => 0
                    ],
                    'effect'                      => 0,
                    'hasAutoPlay'                 => false,
                    'playSpeed'                   => 0,
                    'navigationAlignment'         => 0,
                    'descriptionAlignment'        => 0,
                ],
                [
                    'effect'               => 999,
                    'hasAutoPlay'          => 999,
                    'playSpeed'            => -50,
                    'navigationAlignment'  => 999,
                    'descriptionAlignment' => 999,
                ],
                [
                    'effect'               => 0,
                    'hasAutoPlay'          => true,
                    'playSpeed'            => 0,
                    'navigationAlignment'  => 0,
                    'descriptionAlignment' => 0,
                ],
            ],
            'incorrect2' => [
                [
                    'effect'               => ' 0 ',
                    'hasAutoPlay'          => ' 1 ',
                    'playSpeed'            => ' 2 ',
                    'navigationAlignment'  => ' 2 ',
                    'descriptionAlignment' => ' 1 ',
                ],
                [
                    'effect'               => 0,
                    'hasAutoPlay'          => true,
                    'playSpeed'            => 2,
                    'navigationAlignment'  => 2,
                    'descriptionAlignment' => 1,
                ],
                [
                    'containerDesignBlockModel' => [
                        'marginTop' => ' 500 '
                    ],
                    'effect'                    => '-1',
                    'hasAutoPlay'               => '-1',
                    'playSpeed'                 => '-1',
                    'navigationAlignment'       => '-1',
                    'descriptionAlignment'      => '-1',
                ],
                [
                    'containerDesignBlockModel' => [
                        'marginTop' => 500
                    ],
                    'effect'                    => 0,
                    'hasAutoPlay'               => false,
                    'playSpeed'                 => 0,
                    'navigationAlignment'       => 0,
                    'descriptionAlignment'      => 0,
                ],
            ]
        ];
    }
}
