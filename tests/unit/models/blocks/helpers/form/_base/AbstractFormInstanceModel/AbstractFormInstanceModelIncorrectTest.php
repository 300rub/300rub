<?php

// @codingStandardsIgnoreLine
namespace testS\tests\unit\models\blocks\helpers\form\_base\AbstractFormInstanceModel;

use testS\models\blocks\helpers\form\FormInstanceModel;
use testS\tests\unit\models\_abstract\_base\AbstractIncorrectModelTest;

/**
 * Tests for the model AbstractFormInstanceModel
 */
class AbstractFormInstanceModelIncorrectTest extends AbstractIncorrectModelTest
{

    /**
     * Gets model name
     *
     * @return FormInstanceModel
     */
    protected function getNewModel()
    {
        return new FormInstanceModel();
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
                    'formModel'      => 'incorrect',
                    'sort'           => 'incorrect',
                    'label'          => 123,
                    'isRequired'     => 'incorrect',
                    'validationType' => 'incorrect',
                    'type'           => 'incorrect',
                ],
                [
                    'formModel'      => [
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
                    'sort'           => 0,
                    'label'          => '123',
                    'isRequired'     => false,
                    'validationType' => 0,
                    'type'           => 0,
                ],
                [
                    'formModel'      => [
                        'designFormModel' => [
                            'containerDesignBlockModel' => [
                                'marginTop' => ' 10a '
                            ],
                            'lineDesignBlockModel'      => [
                                'marginTop' => ' 10a '
                            ],
                            'submitIcon'                => 123,
                            'submitIconPosition'        => 999,
                            'submitAlignment'           => 999
                        ],
                        'hasLabel'        => 999,
                        'successText'     => 999
                    ],
                    'sort'           => '123 d',
                    'label'          => '123a',
                    'isRequired'     => 999,
                    'validationType' => 999,
                    'type'           => 999,
                ],
                [
                    'formModel'      => [
                        'designFormModel' => [
                            'containerDesignBlockModel' => [
                                'marginTop' => 10
                            ],
                            'lineDesignBlockModel'      => [
                                'marginTop' => 10
                            ],
                            'submitIcon'                => '123',
                            'submitIconPosition'        => 0,
                            'submitAlignment'           => 0
                        ],
                        'hasLabel'        => true,
                        'successText'     => '999'
                    ],
                    'sort'           => 123,
                    'label'          => '123a',
                    'isRequired'     => true,
                    'validationType' => 0,
                    'type'           => 0,
                ]
            ],
            'incorrect2' => [
                [
                    'label' => $this->generateStringWithLength(256),
                ],
                [
                    'label' => ['maxLength']
                ],
            ]
        ];
    }
}
