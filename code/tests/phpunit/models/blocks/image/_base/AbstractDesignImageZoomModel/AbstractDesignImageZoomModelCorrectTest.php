<?php

// @codingStandardsIgnoreLine
namespace ss\tests\phpunit\models\blocks\image\_base\AbstractDesignImageZoomModel;

use ss\models\blocks\image\DesignImageZoomModel;
use ss\tests\phpunit\models\_abstract\_base\AbstractCorrectModelTest;

/**
 * Tests for the model AbstractDesignImageZoomModel
 */
class AbstractDesignImageZoomModelCorrectTest extends AbstractCorrectModelTest
{

    /**
     * Gets model name
     *
     * @return DesignImageZoomModel
     */
    protected function getNewModel()
    {
        return new DesignImageZoomModel();
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
                    'designBlockModel'     => [
                        'marginTop'                => 10,
                        'borderBottomWidth'        => 7,
                        'borderColorHover'         => 'rgb(0,255,0)',
                        'backgroundColorFromHover' => 'rgba(255,0,255,0.5)',
                    ],
                    'effect'               => 0,
                ],
                [
                    'designBlockModel'     => [
                        'marginTop'                => 10,
                        'borderBottomWidth'        => 7,
                        'borderColorHover'         => 'rgb(0,255,0)',
                        'backgroundColorFromHover' => 'rgba(255,0,255,0.5)',
                    ],
                    'effect'               => 0,
                ],
                [
                    'designBlockModel'     => [
                        'marginTop'                => 5,
                        'borderBottomWidth'        => 4,
                        'borderColorHover'         => 'rgb(255,0,0)',
                        'backgroundColorFromHover' => 'rgba(0,0,255,0.7)',
                    ],
                    'effect'               => 0,
                ],
                [
                    'designBlockModel'     => [
                        'marginTop'                => 5,
                        'borderBottomWidth'        => 4,
                        'borderColorHover'         => 'rgb(255,0,0)',
                        'backgroundColorFromHover' => 'rgba(0,0,255,0.7)',
                    ],
                    'effect'               => 0,
                ],
            ],
        ];
    }
}
