<?php

namespace ss\tests\phpunit\models\blocks\feedback\_base\AbstractFeedbackModel;

use ss\models\blocks\feedback\FeedbackModel;
use ss\tests\phpunit\models\_abstract\_base\AbstractEmptyModelTest;

/**
 * Tests for the model FeedbackModel
 */
class AbstractFeedbackModelEmptyTest extends AbstractEmptyModelTest
{

    /**
     * Gets model name
     *
     * @return FeedbackModel
     */
    protected function getNewModel()
    {
        return new FeedbackModel();
    }

    /**
     * Data provider for CRUD. Empty values
     *
     * @return array
     */
    protected function getDataProviderEmpty()
    {
        return [
            'empty1' => [
                [],
                [
                    'subjectFormInstanceModel' => [
                        'label' => ['required'],
                    ],
                ]
            ],
            'empty2' => [
                [
                    'formModel'                => '',
                    'subjectFormInstanceModel' => '',
                    'subjectText'              => '',
                    'host'                     => '',
                    'port'                     => '',
                    'type'                     => '',
                    'user'                     => '',
                    'password'                 => '',
                ],
                [
                    'subjectFormInstanceModel' => [
                        'label' => ['required'],
                    ],
                ]
            ],
            'empty3' => [
                [
                    'subjectFormInstanceModel' => [
                        'label' => 'Label',
                    ],
                ],
                [
                    'formModel'                => [
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
                    'subjectFormInstanceModel' => [
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
                        'label'          => 'Label',
                        'isRequired'     => false,
                        'validationType' => 0,
                        'type'           => 0,
                    ],
                    'subjectText'              => '',
                    'host'                     => '',
                    'port'                     => 0,
                    'type'                     => '',
                    'user'                     => '',
                    'password'                 => '',
                ]
            ],
        ];
    }
}
