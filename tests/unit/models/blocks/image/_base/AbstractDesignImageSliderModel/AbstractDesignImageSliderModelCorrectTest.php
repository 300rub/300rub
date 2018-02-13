<?php

// @codingStandardsIgnoreLine
namespace ss\tests\unit\models\blocks\image\_base\AbstractDesignImageSliderModel;

use ss\models\blocks\image\DesignImageSliderModel;
use ss\tests\unit\models\_abstract\_base\AbstractCorrectModelTest;

/**
 * Tests for the model AbstractDesignImageSliderModel
 */
class AbstractDesignImageSliderModelCorrectTest extends AbstractCorrectModelTest
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
     * Data provider for CRUD. Correct values
     *
     * @return array
     */
    protected function getDataProviderCorrect()
    {
        return [
            'correct1' => [
                [
                    'containerDesignBlockModel'   => [
                        'marginTop'                => 10,
                        'borderBottomWidth'        => 7,
                        'borderColorHover'         => 'rgb(0,255,0)',
                    ],
                    'navigationDesignBlockModel'  => [
                        'marginTop'                => 10,
                        'borderBottomWidth'        => 7,
                        'borderColorHover'         => 'rgb(0,255,0)',
                    ],
                    'descriptionDesignBlockModel' => [
                        'marginTop'                => 10,
                        'borderBottomWidth'        => 7,
                        'borderColorHover'         => 'rgb(0,255,0)',
                    ],
                    'effect'                      => 0,
                    'hasAutoPlay'                 => true,
                    'playSpeed'                   => 10,
                    'navigationAlignment'         => 1,
                    'descriptionAlignment'        => 2,
                ],
                [
                    'containerDesignBlockModel'   => [
                        'marginTop'                => 10,
                        'borderBottomWidth'        => 7,
                        'borderColorHover'         => 'rgb(0,255,0)',
                    ],
                    'navigationDesignBlockModel'  => [
                        'marginTop'                => 10,
                        'borderBottomWidth'        => 7,
                        'borderColorHover'         => 'rgb(0,255,0)',
                    ],
                    'descriptionDesignBlockModel' => [
                        'marginTop'                => 10,
                        'borderBottomWidth'        => 7,
                        'borderColorHover'         => 'rgb(0,255,0)',
                    ],
                    'effect'                      => 0,
                    'hasAutoPlay'                 => true,
                    'playSpeed'                   => 10,
                    'navigationAlignment'         => 1,
                    'descriptionAlignment'        => 2,
                ],
                [
                    'containerDesignBlockModel'   => [
                        'marginTop'                => 5,
                        'borderBottomWidth'        => 4,
                        'borderColorHover'         => 'rgb(255,0,0)',
                    ],
                    'navigationDesignBlockModel'  => [
                        'marginTop'                => 5,
                        'borderBottomWidth'        => 4,
                        'borderColorHover'         => 'rgb(255,0,0)',
                    ],
                    'descriptionDesignBlockModel' => [
                        'marginTop'                => 5,
                        'borderBottomWidth'        => 4,
                        'borderColorHover'         => 'rgb(255,0,0)',
                    ],
                    'effect'                      => 0,
                    'hasAutoPlay'                 => false,
                    'playSpeed'                   => 5,
                    'navigationAlignment'         => 2,
                    'descriptionAlignment'        => 1,
                ],
                [
                    'containerDesignBlockModel'   => [
                        'marginTop'                => 5,
                        'borderBottomWidth'        => 4,
                        'borderColorHover'         => 'rgb(255,0,0)',
                    ],
                    'navigationDesignBlockModel'  => [
                        'marginTop'                => 5,
                        'borderBottomWidth'        => 4,
                        'borderColorHover'         => 'rgb(255,0,0)',
                    ],
                    'descriptionDesignBlockModel' => [
                        'marginTop'                => 5,
                        'borderBottomWidth'        => 4,
                        'borderColorHover'         => 'rgb(255,0,0)',
                    ],
                    'effect'                      => 0,
                    'hasAutoPlay'                 => false,
                    'playSpeed'                   => 5,
                    'navigationAlignment'         => 2,
                    'descriptionAlignment'        => 1,
                ],
            ],
        ];
    }
}
