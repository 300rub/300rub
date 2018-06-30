<?php

// @codingStandardsIgnoreLine
namespace ss\tests\unit\models\blocks\image\_base\AbstractDesignImageSimpleModel;

use ss\models\blocks\image\DesignImageSimpleModel;
use ss\tests\unit\models\_abstract\_base\AbstractCorrectModelTest;

/**
 * Tests for the model AbstractDesignImageSimpleModel
 */
class AbstractDesignImageSimpleModelCorrectTest extends AbstractCorrectModelTest
{

    /**
     * Gets model name
     *
     * @return DesignImageSimpleModel
     */
    protected function getNewModel()
    {
        return new DesignImageSimpleModel();
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
                    'containerDesignBlockModel' => [
                        'marginTop'                => 10,
                        'borderBottomWidth'        => 7,
                        'borderColorHover'         => 'rgb(0,255,0)',
                        'backgroundColorFromHover' => 'rgba(255,0,255,0.5)',
                    ],
                    'imageDesignBlockModel'     => [
                        'marginTop'                => 10,
                        'borderBottomWidth'        => 7,
                        'borderColorHover'         => 'rgb(0,255,0)',
                        'backgroundColorFromHover' => 'rgba(255,0,255,0.5)',
                    ],
                    'alignment'                 => 1
                ],
                [
                    'containerDesignBlockModel' => [
                        'marginTop'                => 10,
                        'borderBottomWidth'        => 7,
                        'borderColorHover'         => 'rgb(0,255,0)',
                        'backgroundColorFromHover' => 'rgba(255,0,255,0.5)',
                    ],
                    'imageDesignBlockModel'     => [
                        'marginTop'                => 10,
                        'borderBottomWidth'        => 7,
                        'borderColorHover'         => 'rgb(0,255,0)',
                        'backgroundColorFromHover' => 'rgba(255,0,255,0.5)',
                    ],
                    'alignment'                 => 1
                ],
                [
                    'containerDesignBlockModel' => [
                        'marginTop'                => 5,
                        'borderBottomWidth'        => 4,
                        'borderColorHover'         => 'rgb(255,0,0)',
                        'backgroundColorFromHover' => 'rgba(0,0,255,0.7)',
                    ],
                    'imageDesignBlockModel'     => [
                        'marginTop'                => 5,
                        'borderBottomWidth'        => 4,
                        'borderColorHover'         => 'rgb(255,0,0)',
                        'backgroundColorFromHover' => 'rgba(0,0,255,0.7)',
                    ],
                    'alignment'                 => 2
                ],
                [
                    'containerDesignBlockModel' => [
                        'marginTop'                => 5,
                        'borderBottomWidth'        => 4,
                        'borderColorHover'         => 'rgb(255,0,0)',
                        'backgroundColorFromHover' => 'rgba(0,0,255,0.7)',
                    ],
                    'imageDesignBlockModel'     => [
                        'marginTop'                => 5,
                        'borderBottomWidth'        => 4,
                        'borderColorHover'         => 'rgb(255,0,0)',
                        'backgroundColorFromHover' => 'rgba(0,0,255,0.7)',
                    ],
                    'alignment'                 => 2
                ],
            ],
        ];
    }
}
