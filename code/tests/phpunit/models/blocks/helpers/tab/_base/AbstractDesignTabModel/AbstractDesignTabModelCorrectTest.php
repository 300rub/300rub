<?php

// @codingStandardsIgnoreLine
namespace ss\tests\phpunit\models\blocks\helpers\tab\_base\AbstractDesignTabModel;

use ss\models\blocks\helpers\tab\DesignTabModel;
use ss\tests\phpunit\models\_abstract\_base\AbstractCorrectModelTest;

/**
 * Tests for the model AbstractDesignTabModel
 */
class AbstractDesignTabModelCorrectTest extends AbstractCorrectModelTest
{

    /**
     * Gets model name
     *
     * @return DesignTabModel
     */
    protected function getNewModel()
    {
        return new DesignTabModel();
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
                    'tabDesignBlockModel'       => [
                        'marginTop'                => 10,
                        'borderBottomWidth'        => 7,
                        'borderColorHover'         => 'rgb(0,255,0)',
                        'backgroundColorFromHover' => 'rgba(255,0,255,0.5)',
                    ],
                    'tabDesignTextModel'        => [
                        'size' => 10
                    ],
                    'contentDesignBlockModel'   => [
                        'marginTop'                => 10,
                        'borderBottomWidth'        => 7,
                        'borderColorHover'         => 'rgb(0,255,0)',
                        'backgroundColorFromHover' => 'rgba(255,0,255,0.5)',
                    ],
                ],
                [
                    'containerDesignBlockModel' => [
                        'marginTop'                => 10,
                        'borderBottomWidth'        => 7,
                        'borderColorHover'         => 'rgb(0,255,0)',
                        'backgroundColorFromHover' => 'rgba(255,0,255,0.5)',
                    ],
                    'tabDesignBlockModel'       => [
                        'marginTop'                => 10,
                        'borderBottomWidth'        => 7,
                        'borderColorHover'         => 'rgb(0,255,0)',
                        'backgroundColorFromHover' => 'rgba(255,0,255,0.5)',
                    ],
                    'tabDesignTextModel'        => [
                        'size' => 10
                    ],
                    'contentDesignBlockModel'   => [
                        'marginTop'                => 10,
                        'borderBottomWidth'        => 7,
                        'borderColorHover'         => 'rgb(0,255,0)',
                        'backgroundColorFromHover' => 'rgba(255,0,255,0.5)',
                    ],
                ],
                [
                    'containerDesignBlockModel' => [
                        'marginTop'                => 5,
                        'borderBottomWidth'        => 4,
                        'borderColorHover'         => 'rgb(255,0,0)',
                        'backgroundColorFromHover' => 'rgba(0,0,255,0.7)',
                    ],
                    'tabDesignBlockModel'       => [
                        'marginTop'                => 5,
                        'borderBottomWidth'        => 4,
                        'borderColorHover'         => 'rgb(255,0,0)',
                        'backgroundColorFromHover' => 'rgba(0,0,255,0.7)',
                    ],
                    'tabDesignTextModel'        => [
                        'size' => 20
                    ],
                    'contentDesignBlockModel'   => [
                        'marginTop'                => 5,
                        'borderBottomWidth'        => 4,
                        'borderColorHover'         => 'rgb(255,0,0)',
                        'backgroundColorFromHover' => 'rgba(0,0,255,0.7)',
                    ],
                ],
                [
                    'containerDesignBlockModel' => [
                        'marginTop'                => 5,
                        'borderBottomWidth'        => 4,
                        'borderColorHover'         => 'rgb(255,0,0)',
                        'backgroundColorFromHover' => 'rgba(0,0,255,0.7)',
                    ],
                    'tabDesignBlockModel'       => [
                        'marginTop'                => 5,
                        'borderBottomWidth'        => 4,
                        'borderColorHover'         => 'rgb(255,0,0)',
                        'backgroundColorFromHover' => 'rgba(0,0,255,0.7)',
                    ],
                    'tabDesignTextModel'        => [
                        'size' => 20
                    ],
                    'contentDesignBlockModel'   => [
                        'marginTop'                => 5,
                        'borderBottomWidth'        => 4,
                        'borderColorHover'         => 'rgb(255,0,0)',
                        'backgroundColorFromHover' => 'rgba(0,0,255,0.7)',
                    ],
                ],
            ],
        ];
    }
}
