<?php

// @codingStandardsIgnoreLine
namespace ss\tests\unit\models\blocks\helpers\field\_base\AbstractFieldModel;

use ss\models\blocks\helpers\field\FieldModel;
use ss\tests\unit\models\_abstract\_base\AbstractCorrectModelTest;

/**
 * Tests for the model AbstractFieldModel
 */
class AbstractFieldModelCorrectTest extends AbstractCorrectModelTest
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
     * Data provider for CRUD. Correct values
     *
     * @return array
     */
    protected function getDataProviderCorrect()
    {
        return [
            'correct1' => [
                [
                    'designFieldModel' => [
                        'shortCardContainerDesignBlockModel' => [
                            'marginTop' => 10
                        ],
                        'shortCardLabelDesignBlockModel'     => [
                            'marginTop' => 20
                        ],
                        'shortCardLabelDesignTextModel'      => [
                            'size' => 30
                        ],
                        'shortCardValueDesignBlockModel'     => [
                            'marginTop' => 40
                        ],
                    ],
                ],
                [
                    'designFieldModel' => [
                        'shortCardContainerDesignBlockModel' => [
                            'marginTop' => 10
                        ],
                        'shortCardLabelDesignBlockModel'     => [
                            'marginTop' => 20
                        ],
                        'shortCardLabelDesignTextModel'      => [
                            'size' => 30
                        ],
                        'shortCardValueDesignBlockModel'     => [
                            'marginTop' => 40
                        ],
                    ],
                ],
                [
                    'designFieldModel' => [
                        'shortCardContainerDesignBlockModel' => [
                            'marginTop' => 15
                        ],
                        'shortCardLabelDesignBlockModel'     => [
                            'marginTop' => 25
                        ],
                        'shortCardLabelDesignTextModel'      => [
                            'size' => 35
                        ],
                        'shortCardValueDesignBlockModel'     => [
                            'marginTop' => 45
                        ],
                    ],
                ],
                [
                    'designFieldModel' => [
                        'shortCardContainerDesignBlockModel' => [
                            'marginTop' => 15
                        ],
                        'shortCardLabelDesignBlockModel'     => [
                            'marginTop' => 25
                        ],
                        'shortCardLabelDesignTextModel'      => [
                            'size' => 35
                        ],
                        'shortCardValueDesignBlockModel'     => [
                            'marginTop' => 45
                        ],
                    ],
                ],
            ]
        ];
    }
}
