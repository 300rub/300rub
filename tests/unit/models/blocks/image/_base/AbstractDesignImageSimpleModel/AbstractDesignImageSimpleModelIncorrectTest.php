<?php

// @codingStandardsIgnoreLine
namespace testS\tests\unit\models\blocks\image\_base\AbstractDesignImageSimpleModel;

use testS\models\blocks\image\DesignImageSimpleModel;
use testS\tests\unit\models\_abstract\_base\AbstractIncorrectModelTest;

/**
 * Tests for the model AbstractDesignImageSimpleModel
 */
// @codingStandardsIgnoreLine
class AbstractDesignImageSimpleModelIncorrectTest extends AbstractIncorrectModelTest
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
     * Data provider for CRUD. Incorrect values
     *
     * @return array
     */
    protected function getDataProviderIncorrect()
    {
        return [
            'incorrect1' => [
                [
                    'containerDesignBlockModel' => 'incorrect',
                    'imageDesignBlockModel'     => 'incorrect',
                    'alignment'                 => 'incorrect',
                ],
                [
                    'containerDesignBlockModel' => [
                        'marginTop' => 0
                    ],
                    'imageDesignBlockModel'     => [
                        'marginTop' => 0
                    ],
                    'alignment'                 => 0
                ],
                [
                    'alignment' => 999,
                ],
                [
                    'alignment' => 0,
                ],
            ],
            'incorrect2' => [
                [
                    'alignment' => ' 1 ',
                ],
                [
                    'alignment' => 1,
                ],
                [
                    'containerDesignBlockModel' => [
                        'marginTop' => ' 500 '
                    ],
                    'alignment'                 => true,
                ],
                [
                    'containerDesignBlockModel' => [
                        'marginTop' => 500
                    ],
                    'alignment'                 => 1,
                ],
            ]
        ];
    }
}
