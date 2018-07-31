<?php

// @codingStandardsIgnoreLine
namespace ss\tests\phpunit\models\blocks\image\_base\AbstractDesignImageSliderModel;

use ss\models\blocks\image\DesignImageSliderModel;
use ss\tests\phpunit\models\_abstract\_base\AbstractCorrectModelTest;

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
                    'bulletDesignBlockModel'   => [
                        'marginTop'                => 10,
                        'borderBottomWidth'        => 7,
                        'borderColorHover'         => 'rgb(0,255,0)',
                    ],
                    'hasAutoPlay'                 => true,
                    'playSpeed'                   => 10,
                ],
                [
                    'bulletDesignBlockModel'   => [
                        'marginTop'                => 10,
                        'borderBottomWidth'        => 7,
                        'borderColorHover'         => 'rgb(0,255,0)',
                    ],
                    'hasAutoPlay'                 => true,
                    'playSpeed'                   => 10,
                ],
                [
                    'bulletDesignBlockModel'   => [
                        'marginTop'                => 5,
                        'borderBottomWidth'        => 4,
                        'borderColorHover'         => 'rgb(255,0,0)',
                    ],
                    'hasAutoPlay'                 => false,
                    'playSpeed'                   => 5,
                ],
                [
                    'bulletDesignBlockModel'   => [
                        'marginTop'                => 5,
                        'borderBottomWidth'        => 4,
                        'borderColorHover'         => 'rgb(255,0,0)',
                    ],
                    'hasAutoPlay'                 => false,
                    'playSpeed'                   => 5,
                ],
            ],
        ];
    }
}
