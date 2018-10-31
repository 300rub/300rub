<?php

namespace ss\tests\phpunit\models\blocks\helpers\form\_base\AbstractFormModel;

use ss\models\blocks\helpers\form\FormModel;
use ss\tests\phpunit\models\_abstract\_base\AbstractCorrectModelTest;

/**
 * Tests for the model AbstractFormModel
 */
class AbstractFormModelCorrectTest extends AbstractCorrectModelTest
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
     * Data provider for CRUD. Correct values
     *
     * @return array
     */
    protected function getDataProviderCorrect()
    {
        return [
            'correct1' => [
                [
                    'designFormModel' => [
                        'containerDesignBlockModel' => [
                            'marginTop' => 400
                        ],
                        'lineDesignBlockModel'      => [
                            'marginTop' => 500
                        ],
                        'submitIcon'                => 'fa-lock',
                        'submitIconPosition'        => 1,
                        'submitAlignment'           => 1
                    ],
                    'hasLabel'        => true,
                    'successText'     => 'Thanks!'
                ],
                [
                    'designFormModel' => [
                        'containerDesignBlockModel' => [
                            'marginTop' => 400
                        ],
                        'lineDesignBlockModel'      => [
                            'marginTop' => 500
                        ],
                        'submitIcon'                => 'fa-lock',
                        'submitIconPosition'        => 1,
                        'submitAlignment'           => 1
                    ],
                    'hasLabel'        => true,
                    'successText'     => 'Thanks!'
                ],
                [
                    'designFormModel' => [
                        'containerDesignBlockModel' => [
                            'marginTop' => 300
                        ],
                        'lineDesignBlockModel'      => [
                            'marginTop' => 200
                        ],
                        'submitIcon'                => 'fa-check',
                        'submitIconPosition'        => 0,
                        'submitAlignment'           => 0
                    ],
                    'hasLabel'        => false,
                    'successText'     => 'Text'
                ],
                [
                    'designFormModel' => [
                        'containerDesignBlockModel' => [
                            'marginTop' => 300
                        ],
                        'lineDesignBlockModel'      => [
                            'marginTop' => 200
                        ],
                        'submitIcon'                => 'fa-check',
                        'submitIconPosition'        => 0,
                        'submitAlignment'           => 0
                    ],
                    'hasLabel'        => false,
                    'successText'     => 'Text'
                ]
            ]
        ];
    }
}
