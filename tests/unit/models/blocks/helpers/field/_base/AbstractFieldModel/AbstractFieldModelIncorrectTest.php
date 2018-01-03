<?php

// @codingStandardsIgnoreLine
namespace testS\tests\unit\models\blocks\helpers\field\_base\AbstractFieldModel;

use testS\models\blocks\helpers\field\FieldModel;
use testS\tests\unit\models\_abstract\_base\AbstractIncorrectModelTest;

/**
 * Tests for the model AbstractFieldModel
 */
class AbstractFieldModelIncorrectTest extends AbstractIncorrectModelTest
{

    /**
     * Gets model name
     *
     * @return FieldModel
     */
    protected function getNewModel()
    {
        return new FieldModel();
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
                    'designFieldModel' => 'incorrect'
                ],
                [
                    'designFieldModel' => [
                        'shortCardContainerDesignBlockModel' => [
                            'marginTop' => 0
                        ],
                    ]
                ],
                [
                    'designFieldModel' => [
                        'shortCardContainerDesignBlockModel' => 'incorrect',
                    ]
                ],
                [
                    'designFieldModel' => [
                        'shortCardContainerDesignBlockModel' => [
                            'marginTop' => 0
                        ],
                    ]
                ],
            ],
            'incorrect2' => [
                [
                    'designFieldModel' => [
                        'shortCardContainerDesignBlockModel' => [
                            'marginTop' => 'incorrect'
                        ],
                    ]
                ],
                [
                    'designFieldModel' => [
                        'shortCardContainerDesignBlockModel' => [
                            'marginTop' => 0
                        ],
                    ]
                ],
                [
                    'designFieldModel' => [
                        'shortCardContainerDesignBlockModel' => [
                            'marginTop' => ' 50 ds'
                        ],
                    ]
                ],
                [
                    'designFieldModel' => [
                        'shortCardContainerDesignBlockModel' => [
                            'marginTop' => 50
                        ],
                    ]
                ],
            ]
        ];
    }
}
