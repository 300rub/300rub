<?php

// @codingStandardsIgnoreLine
namespace ss\tests\phpunit\models\blocks\image\_base\AbstractDesignImageZoomModel;

use ss\models\blocks\image\DesignImageZoomModel;
use ss\tests\phpunit\models\_abstract\_base\AbstractIncorrectModelTest;

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
                    'effect'               => 'incorrect',
                ],
                [
                    'designBlockModel'     => [
                        'marginTop' => 0
                    ],
                    'effect'               => 0,
                ],
                [
                    'effect'               => 999,
                ],
                [
                    'effect'               => 0,
                ],
            ],
            'incorrect2' => [
                [
                    'effect'               => '0',
                ],
                [
                    'effect'               => 0,
                ],
                [
                    'designBlockModel'     => [
                        'marginTop' => ' 500 '
                    ],
                    'effect'               => '-1',
                ],
                [
                    'designBlockModel'     => [
                        'marginTop' => 500
                    ],
                    'effect'               => 0,
                ],
            ]
        ];
    }
}
