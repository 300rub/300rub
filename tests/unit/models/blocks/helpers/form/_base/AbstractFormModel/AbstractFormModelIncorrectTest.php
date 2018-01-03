<?php

namespace testS\tests\unit\models\blocks\helpers\form\_base\AbstractFormModel;

use testS\models\blocks\helpers\form\FormModel;
use testS\tests\unit\models\_abstract\_base\AbstractIncorrectModelTest;

/**
 * Tests for the model AbstractFormModel
 */
class AbstractFormModelIncorrectTest extends AbstractIncorrectModelTest
{

    /**
     * Gets model name
     *
     * @return FormModel
     */
    protected function getNewModel()
    {
        return new FormModel();
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
                    'designFormModel' => 'incorrect',
                    'hasLabel'        => 'incorrect',
                    'successText'     => [],
                ],
                [
                    'designFormModel' => [
                        'containerDesignBlockModel' => [
                            'marginTop' => 0
                        ],
                        'lineDesignBlockModel'      => [
                            'marginTop' => 0
                        ],
                        'submitIcon'                => '',
                        'submitIconPosition'        => 0,
                        'submitAlignment'           => 0
                    ],
                    'hasLabel'        => false,
                    'successText'     => ''
                ],
                [
                    'designFormModel' => [
                        'containerDesignBlockModel' => [
                            'marginTop' => 'incorrect'
                        ],
                        'lineDesignBlockModel'      => [
                            'marginTop' => 'incorrect'
                        ],
                        'submitIcon'                => '',
                        'submitIconPosition'        => 'incorrect',
                        'submitAlignment'           => 'incorrect'
                    ],
                    'hasLabel'        => 'fffffffff',
                    'successText'     => '  '
                ],
                [
                    'designFormModel' => [
                        'containerDesignBlockModel' => [
                            'marginTop' => 0
                        ],
                        'lineDesignBlockModel'      => [
                            'marginTop' => 0
                        ],
                        'submitIcon'                => '',
                        'submitIconPosition'        => 0,
                        'submitAlignment'           => 0
                    ],
                    'hasLabel'        => false,
                    'successText'     => ''
                ],
            ],
            'incorrect2' => [
                [
                    'designFormModel' => [
                        'containerDesignBlockModel' => [
                            'marginTop' => ' 500 asd'
                        ],
                        'lineDesignBlockModel'      => [
                            'marginTop' => ' 1d'
                        ],
                        'submitIcon'                => [],
                        'submitIconPosition'        => ' 1',
                        'submitAlignment'           => ' 1 s'
                    ],
                    'hasLabel'        => '123',
                    'successText'     => 321
                ],
                [
                    'designFormModel' => [
                        'containerDesignBlockModel' => [
                            'marginTop' => 500
                        ],
                        'lineDesignBlockModel'      => [
                            'marginTop' => 1
                        ],
                        'submitIcon'                => '',
                        'submitIconPosition'        => 1,
                        'submitAlignment'           => 1
                    ],
                    'hasLabel'        => false,
                    'successText'     => '321'
                ],
            ]
        ];
    }
}
