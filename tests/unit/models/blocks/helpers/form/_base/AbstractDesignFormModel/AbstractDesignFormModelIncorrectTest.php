<?php

// @codingStandardsIgnoreLine
namespace testS\tests\unit\models\blocks\helpers\form\_base\AbstractDesignFormModel;

use testS\models\blocks\helpers\form\DesignFormModel;
use testS\tests\unit\models\_abstract\_base\AbstractIncorrectModelTest;

/**
 * Tests for the model AbstractDesignFormModel
 */
class AbstractDesignFormModelIncorrectTest extends AbstractIncorrectModelTest
{

    /**
     * Gets model name
     *
     * @return DesignFormModel
     */
    protected function getNewModel()
    {
        return new DesignFormModel();
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
                    'lineDesignBlockModel'      => 'incorrect',
                    'labelDesignBlockModel'     => 'incorrect',
                    'labelDesignTextModel'      => 'incorrect',
                    'formDesignBlockModel'      => 'incorrect',
                    'formDesignTextModel'       => 'incorrect',
                    'submitDesignBlockModel'    => 'incorrect',
                    'submitDesignTextModel'     => 'incorrect',
                    'submitIconDesignTextModel' => 'incorrect',
                    'submitIcon'                => 123,
                    'submitIconPosition'        => 'incorrect',
                    'submitAlignment'           => 'incorrect',
                ],
                [
                    'containerDesignBlockModel' => [
                        'marginTop' => 0
                    ],
                    'lineDesignBlockModel'      => [
                        'marginTop' => 0
                    ],
                    'labelDesignBlockModel'     => [
                        'marginTop' => 0
                    ],
                    'labelDesignTextModel'      => [
                        'size' => 0
                    ],
                    'formDesignBlockModel'      => [
                        'marginTop' => 0
                    ],
                    'formDesignTextModel'       => [
                        'size' => 0
                    ],
                    'submitDesignBlockModel'    => [
                        'marginTop' => 0
                    ],
                    'submitDesignTextModel'     => [
                        'size' => 0
                    ],
                    'submitIconDesignTextModel' => [
                        'size' => 0
                    ],
                    'submitIcon'                => '123',
                    'submitIconPosition'        => 0,
                    'submitAlignment'           => 0
                ],
                [
                    'submitIconPosition' => 999,
                    'submitAlignment'    => 999
                ],
                [
                    'submitIconPosition' => 0,
                    'submitAlignment'    => 0
                ],
            ],
            'incorrect2' => [
                [
                    'submitIconPosition' => ' 1 ',
                    'submitAlignment'    => '1asdads',
                ],
                [
                    'submitIconPosition' => 1,
                    'submitAlignment'    => 1,
                ],
                [
                    'containerDesignBlockModel' => [
                        'marginTop' => ' 500 '
                    ],
                    'submitIconPosition'        => true,
                    'submitAlignment'           => false,
                ],
                [
                    'containerDesignBlockModel' => [
                        'marginTop' => 500
                    ],
                    'submitIconPosition'        => 1,
                    'submitAlignment'           => 0,
                ],
            ],
            'incorrect3' => [
                [
                    'submitIcon' => $this->generateStringWithLength(51),
                ],
                [
                    'submitIcon' => ['maxLength'],
                ],
            ],
        ];
    }
}
