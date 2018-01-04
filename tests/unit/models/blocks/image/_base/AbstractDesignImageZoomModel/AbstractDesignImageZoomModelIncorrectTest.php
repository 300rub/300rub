<?php

// @codingStandardsIgnoreLine
namespace testS\tests\unit\models\blocks\image\_base\AbstractDesignImageZoomModel;

use testS\models\blocks\image\DesignImageZoomModel;
use testS\tests\unit\models\_abstract\_base\AbstractIncorrectModelTest;

/**
 * Tests for the model AbstractDesignImageZoomModel
 */
// @codingStandardsIgnoreLine
class AbstractDesignImageZoomModelIncorrectTest extends AbstractIncorrectModelTest
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
     * Data provider for CRUD. Incorrect values
     *
     * @return array
     */
    protected function getDataProviderIncorrect()
    {
        return [
            'incorrect1' => [
                [
                    'designBlockModel'     => 'incorrect',
                    'hasScroll'            => 'incorrect',
                    'thumbsAlignment'      => 'incorrect',
                    'descriptionAlignment' => 'incorrect',
                    'effect'               => 'incorrect',
                ],
                [
                    'designBlockModel'     => [
                        'marginTop' => 0
                    ],
                    'hasScroll'            => false,
                    'thumbsAlignment'      => 0,
                    'descriptionAlignment' => 0,
                    'effect'               => 0,
                ],
                [
                    'hasScroll'            => 999,
                    'thumbsAlignment'      => 999,
                    'descriptionAlignment' => 999,
                    'effect'               => 999,
                ],
                [
                    'hasScroll'            => true,
                    'thumbsAlignment'      => 0,
                    'descriptionAlignment' => 0,
                    'effect'               => 0,
                ],
            ],
            'incorrect2' => [
                [
                    'hasScroll'            => ' 1 ',
                    'thumbsAlignment'      => ' 2 asd ',
                    'descriptionAlignment' => ' asd1 ',
                    'effect'               => '0',
                ],
                [
                    'hasScroll'            => true,
                    'thumbsAlignment'      => 2,
                    'descriptionAlignment' => 0,
                    'effect'               => 0,
                ],
                [
                    'designBlockModel'     => [
                        'marginTop' => ' 500 '
                    ],
                    'hasScroll'            => '-1',
                    'thumbsAlignment'      => '-1',
                    'descriptionAlignment' => '-1',
                    'effect'               => '-1',
                ],
                [
                    'designBlockModel'     => [
                        'marginTop' => 500
                    ],
                    'hasScroll'            => false,
                    'thumbsAlignment'      => 0,
                    'descriptionAlignment' => 0,
                    'effect'               => 0,
                ],
            ]
        ];
    }
}
