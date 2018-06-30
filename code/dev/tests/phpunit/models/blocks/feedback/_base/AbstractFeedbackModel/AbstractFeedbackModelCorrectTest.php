<?php

namespace ss\tests\unit\models\blocks\feedback\_base\AbstractFeedbackModel;

use ss\models\blocks\feedback\FeedbackModel;
use ss\tests\unit\models\_abstract\_base\AbstractCorrectModelTest;

/**
 * Tests for the model FeedbackModel
 */
class AbstractFeedbackModelCorrectTest extends AbstractCorrectModelTest
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
     * Data provider for CRUD. Correct values
     *
     * @return array
     */
    protected function getDataProviderCorrect()
    {
        return [
            'correct1' => [
                $this->_createData(),
                $this->_createExpectedData(),
                $this->_updateData(),
                $this->_updateExpectedData(),
            ]
        ];
    }

    /**
     * Data provider for CRUD. Correct values
     *
     * @return array
     */
    private function _createData()
    {
        return [
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
        ];
    }

    /**
     * Data provider for CRUD. Correct values
     *
     * @return array
     */
    private function _createExpectedData()
    {
        return [
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
        ];
    }

    /**
     * Data provider for CRUD. Correct values
     *
     * @return array
     */
    private function _updateData()
    {
        return [
            'formModel'                => [
                'designFormModel' => [
                    'containerDesignBlockModel' => [
                        'marginTop' => 30
                    ],
                    'lineDesignBlockModel'      => [
                        'marginTop' => 30
                    ],
                    'submitIcon'                => 'icon-5',
                    'submitIconPosition'        => 0,
                    'submitAlignment'           => 0
                ],
                'hasLabel'        => false,
                'successText'     => 'Success 2'
            ],
            'subjectFormInstanceModel' => [
                'formModel'      => [
                    'designFormModel' => [
                        'containerDesignBlockModel' => [
                            'marginTop' => 40
                        ],
                        'lineDesignBlockModel'      => [
                            'marginTop' => 40
                        ],
                        'submitIcon'                => 'icon-6',
                        'submitIconPosition'        => 0,
                        'submitAlignment'           => 0
                    ],
                    'hasLabel'        => false,
                    'successText'     => 'Success 7'
                ],
                'sort'           => 20,
                'label'          => 'Label 30',
                'isRequired'     => false,
                'validationType' => 0,
                'type'           => 0,
            ],
            'subjectText'              => 'Subject 23',
            'host'                     => '127.0.0.2',
            'port'                     => 1000,
            'type'                     => '',
            'user'                     => 'user2',
            'password'                 => 'pass2',
        ];
    }

    /**
     * Data provider for CRUD. Correct values
     *
     * @return array
     */
    private function _updateExpectedData()
    {
        return [
            'formModel'                => [
                'designFormModel' => [
                    'containerDesignBlockModel' => [
                        'marginTop' => 30
                    ],
                    'lineDesignBlockModel'      => [
                        'marginTop' => 30
                    ],
                    'submitIcon'                => 'icon-5',
                    'submitIconPosition'        => 0,
                    'submitAlignment'           => 0
                ],
                'hasLabel'        => false,
                'successText'     => 'Success 2'
            ],
            'subjectFormInstanceModel' => [
                'formModel'      => [
                    'designFormModel' => [
                        'containerDesignBlockModel' => [
                            'marginTop' => 40
                        ],
                        'lineDesignBlockModel'      => [
                            'marginTop' => 40
                        ],
                        'submitIcon'                => 'icon-6',
                        'submitIconPosition'        => 0,
                        'submitAlignment'           => 0
                    ],
                    'hasLabel'        => false,
                    'successText'     => 'Success 7'
                ],
                'sort'           => 20,
                'label'          => 'Label 30',
                'isRequired'     => false,
                'validationType' => 0,
                'type'           => 0,
            ],
            'subjectText'              => 'Subject 23',
            'host'                     => '127.0.0.2',
            'port'                     => 1000,
            'type'                     => '',
            'user'                     => 'user2',
            'password'                 => 'pass2',
        ];
    }
}
