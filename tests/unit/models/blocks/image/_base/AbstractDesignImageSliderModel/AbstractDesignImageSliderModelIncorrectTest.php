<?php

// @codingStandardsIgnoreLine
namespace ss\tests\unit\models\blocks\image\_base\AbstractDesignImageSliderModel;

use ss\models\blocks\image\DesignImageSliderModel;
use ss\tests\unit\models\_abstract\_base\AbstractIncorrectModelTest;

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
                    'bulletDesignBlockModel'   => 'incorrect',
                    'hasAutoPlay'                 => 'incorrect',
                    'playSpeed'                   => 'incorrect',
                ],
                [
                    'bulletDesignBlockModel'   => [
                        'marginTop' => 0
                    ],
                    'hasAutoPlay'                 => false,
                    'playSpeed'                   => 0,
                ],
                [
                    'hasAutoPlay'          => 999,
                    'playSpeed'            => -50,
                ],
                [
                    'hasAutoPlay'          => true,
                    'playSpeed'            => 0,
                ],
            ],
            'incorrect2' => [
                [
                    'hasAutoPlay'          => ' 1 ',
                    'playSpeed'            => ' 2 ',
                ],
                [
                    'hasAutoPlay'          => true,
                    'playSpeed'            => 2,
                ],
                [
                    'bulletDesignBlockModel' => [
                        'marginTop' => ' 500 '
                    ],
                    'hasAutoPlay'               => '-1',
                    'playSpeed'                 => '-1',
                ],
                [
                    'bulletDesignBlockModel' => [
                        'marginTop' => 500
                    ],
                    'hasAutoPlay'               => false,
                    'playSpeed'                 => 0,
                ],
            ]
        ];
    }
}
