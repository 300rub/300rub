<?php

// @codingStandardsIgnoreLine
namespace ss\tests\unit\models\blocks\helpers\field\_base\AbstractDesignFieldModel;

use ss\models\blocks\helpers\field\DesignFieldModel;
use ss\tests\unit\models\_abstract\_base\AbstractIncorrectModelTest;

/**
 * Tests for the model AbstractDesignFieldModel
 */
class AbstractDesignFieldModelIncorrectTest extends AbstractIncorrectModelTest
{

    /**
     * Gets model name
     *
     * @return DesignFieldModel
     */
    protected function getNewModel()
    {
        return new DesignFieldModel();
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
                    'shortCardContainerDesignBlockModel' => 'incorrect',
                    'shortCardLabelDesignBlockModel'     => 'incorrect',
                    'shortCardLabelDesignTextModel'      => 'incorrect',
                    'shortCardValueDesignBlockModel'     => 'incorrect',
                    'shortCardValueDesignTextModel'      => 'incorrect',
                    'fullCardContainerDesignBlockModel'  => 'incorrect',
                    'fullCardLabelDesignBlockModel'      => 'incorrect',
                    'fullCardLabelDesignTextModel'       => 'incorrect',
                    'fullCardValueDesignBlockModel'      => 'incorrect',
                    'fullCardValueDesignTextModel'       => 'incorrect',
                ],
                [
                    'shortCardContainerDesignBlockModel' => [
                        'marginTop' => 0
                    ],
                    'shortCardLabelDesignBlockModel'     => [
                        'marginTop' => 0
                    ],
                    'shortCardLabelDesignTextModel'      => [
                        'size' => 0
                    ],
                    'shortCardValueDesignBlockModel'     => [
                        'marginTop' => 0
                    ],
                    'shortCardValueDesignTextModel'      => [
                        'size' => 0
                    ],
                    'fullCardContainerDesignBlockModel'  => [
                        'marginTop' => 0
                    ],
                    'fullCardLabelDesignBlockModel'      => [
                        'marginTop' => 0
                    ],
                    'fullCardLabelDesignTextModel'       => [
                        'size' => 0
                    ],
                    'fullCardValueDesignBlockModel'      => [
                        'marginTop' => 0
                    ],
                    'fullCardValueDesignTextModel'       => [
                        'size' => 0
                    ],
                ],
                [
                    'shortCardContainerDesignBlockModel' => [
                        'marginTop' => ' 100 '
                    ],
                ],
                [
                    'shortCardContainerDesignBlockModel' => [
                        'marginTop' => 100
                    ],
                    'shortCardLabelDesignBlockModel'     => [
                        'marginTop' => 0
                    ],
                    'shortCardLabelDesignTextModel'      => [
                        'size' => 0
                    ],
                    'shortCardValueDesignBlockModel'     => [
                        'marginTop' => 0
                    ],
                    'shortCardValueDesignTextModel'      => [
                        'size' => 0
                    ],
                    'fullCardContainerDesignBlockModel'  => [
                        'marginTop' => 0
                    ],
                    'fullCardLabelDesignBlockModel'      => [
                        'marginTop' => 0
                    ],
                    'fullCardLabelDesignTextModel'       => [
                        'size' => 0
                    ],
                    'fullCardValueDesignBlockModel'      => [
                        'marginTop' => 0
                    ],
                    'fullCardValueDesignTextModel'       => [
                        'size' => 0
                    ],
                ],
            ],
        ];
    }
}
