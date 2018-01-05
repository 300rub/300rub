<?php

namespace testS\tests\unit\models\blocks\feedback\_base\AbstractFeedbackModel;

use testS\models\blocks\feedback\FeedbackModel;
use testS\tests\unit\models\_abstract\_base\AbstractDuplicateModelTest;

/**
 * Tests for the model FeedbackModel
 */
class AbstractFeedbackModelDuplicateTest extends AbstractDuplicateModelTest
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
     * Data provider for CRUD. Duplicate
     *
     * @return void
     */
    public function testDuplicate()
    {
        $this->duplicate(
            [
                'formModel'                => [
                    'designFormModel' => [
                        'containerDesignBlockModel' => [
                            'marginTop' => 10
                        ],
                        'lineDesignBlockModel'      => [
                            'marginTop' => 10
                        ],
                        'submitIcon'                => 'icon',
                        'submitIconPosition'        => 1,
                        'submitAlignment'           => 1
                    ],
                    'hasLabel'        => true,
                    'successText'     => 'Success'
                ],
                'subjectFormInstanceModel' => [
                    'formModel'      => [
                        'designFormModel' => [
                            'containerDesignBlockModel' => [
                                'marginTop' => 20
                            ],
                            'lineDesignBlockModel'      => [
                                'marginTop' => 20
                            ],
                            'submitIcon'                => 'icon-2',
                            'submitIconPosition'        => 1,
                            'submitAlignment'           => 1
                        ],
                        'hasLabel'        => true,
                        'successText'     => 'S'
                    ],
                    'sort'           => 10,
                    'label'          => 'Label 3',
                    'isRequired'     => true,
                    'validationType' => 1,
                    'type'           => 1,
                ],
                'subjectText'              => 'Subject',
                'host'                     => '127.0.0.1',
                'port'                     => 80,
                'type'                     => 'smtp',
                'user'                     => 'user',
                'password'                 => 'pass',
            ],
            [
                'formModel'                => [
                    'designFormModel' => [
                        'containerDesignBlockModel' => [
                            'marginTop' => 10
                        ],
                        'lineDesignBlockModel'      => [
                            'marginTop' => 10
                        ],
                        'submitIcon'                => 'icon',
                        'submitIconPosition'        => 1,
                        'submitAlignment'           => 1
                    ],
                    'hasLabel'        => true,
                    'successText'     => 'Success'
                ],
                'subjectFormInstanceModel' => [
                    'formModel'      => [
                        'designFormModel' => [
                            'containerDesignBlockModel' => [
                                'marginTop' => 20
                            ],
                            'lineDesignBlockModel'      => [
                                'marginTop' => 20
                            ],
                            'submitIcon'                => 'icon-2',
                            'submitIconPosition'        => 1,
                            'submitAlignment'           => 1
                        ],
                        'hasLabel'        => true,
                        'successText'     => 'S'
                    ],
                    'sort'           => 10,
                    'label'          => 'Label 3',
                    'isRequired'     => true,
                    'validationType' => 1,
                    'type'           => 1,
                ],
                'subjectText'              => 'Subject',
                'host'                     => '127.0.0.1',
                'port'                     => 80,
                'type'                     => 'smtp',
                'user'                     => 'user',
                'password'                 => 'pass',
            ]
        );
    }
}
