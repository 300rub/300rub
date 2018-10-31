<?php

// @codingStandardsIgnoreLine
namespace ss\tests\phpunit\models\blocks\helpers\form\_base\AbstractFormInstanceModel;

use ss\models\blocks\helpers\form\FormInstanceModel;
use ss\tests\phpunit\models\_abstract\_base\AbstractCorrectModelTest;

/**
 * Tests for the model AbstractFormInstanceModel
 */
class AbstractFormInstanceModelCorrectTest extends AbstractCorrectModelTest
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
     * Data provider for CRUD. Correct values
     *
     * @return array
     */
    protected function getDataProviderCorrect()
    {
        return [
            'correct1' => [
                [
                    'formModel'      => [
                        'designFormModel' => [
                            'containerDesignBlockModel' => [
                                'marginTop' => 10
                            ],
                            'lineDesignBlockModel'      => [
                                'marginTop' => 10
                            ],
                            'submitIcon'                => 'fa-lock',
                            'submitIconPosition'        => 1,
                            'submitAlignment'           => 1
                        ],
                        'hasLabel'        => true,
                        'successText'     => 'Success'
                    ],
                    'sort'           => 10,
                    'label'          => 'Label 1',
                    'isRequired'     => true,
                    'validationType' => 1,
                    'type'           => 1,
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
                            'submitIcon'                => 'fa-lock',
                            'submitIconPosition'        => 1,
                            'submitAlignment'           => 1
                        ],
                        'hasLabel'        => true,
                        'successText'     => 'Success'
                    ],
                    'sort'           => 10,
                    'label'          => 'Label 1',
                    'isRequired'     => true,
                    'validationType' => 1,
                    'type'           => 1,
                ],
                [
                    'formModel'      => [
                        'designFormModel' => [
                            'containerDesignBlockModel' => [
                                'marginTop' => 20
                            ],
                            'lineDesignBlockModel'      => [
                                'marginTop' => 20
                            ],
                            'submitIcon'                => 'fa-user',
                            'submitIconPosition'        => 0,
                            'submitAlignment'           => 0
                        ],
                        'hasLabel'        => false,
                        'successText'     => 'Success 2'
                    ],
                    'sort'           => 20,
                    'label'          => 'Label 2',
                    'isRequired'     => false,
                    'validationType' => 0,
                    'type'           => 0,
                ],
                [
                    'formModel'      => [
                        'designFormModel' => [
                            'containerDesignBlockModel' => [
                                'marginTop' => 20
                            ],
                            'lineDesignBlockModel'      => [
                                'marginTop' => 20
                            ],
                            'submitIcon'                => 'fa-user',
                            'submitIconPosition'        => 0,
                            'submitAlignment'           => 0
                        ],
                        'hasLabel'        => false,
                        'successText'     => 'Success 2'
                    ],
                    'sort'           => 20,
                    'label'          => 'Label 2',
                    'isRequired'     => false,
                    'validationType' => 0,
                    'type'           => 0,
                ],
            ]
        ];
    }
}
