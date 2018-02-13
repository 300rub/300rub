<?php

namespace ss\tests\unit\models\blocks\feedback\_base\AbstractFeedbackModel;

use ss\models\blocks\feedback\FeedbackModel;
use ss\tests\unit\models\_abstract\_base\AbstractIncorrectModelTest;

/**
 * Tests for the model FeedbackModel
 */
class AbstractFeedbackModelIncorrectTest extends AbstractIncorrectModelTest
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
     * Data provider for CRUD. Incorrect values
     *
     * @return array
     */
    protected function getDataProviderIncorrect()
    {
        return [
            'incorrect1' => $this->_getDataProviderIncorrect1(),
            'incorrect2' => $this->_getDataProviderIncorrect2(),
            'incorrect3' => $this->_getDataProviderIncorrect3(),
            'incorrect4' => $this->_getDataProviderIncorrect4(),
        ];
    }

    /**
     * Data provider for CRUD. Incorrect values
     *
     * @return array
     */
    private function _getDataProviderIncorrect1()
    {
        return [
            [
                'formModel'                => 'incorrect',
                'subjectFormInstanceModel' => 'incorrect',
                'subjectText'              => 'incorrect',
                'host'                     => 'incorrect',
                'port'                     => 'incorrect',
                'type'                     => 'incorrect',
                'user'                     => 'incorrect',
                'password'                 => 'incorrect',
            ],
            [
                'subjectFormInstanceModel' => [
                    'label' => ['required'],
                ],
            ]
        ];
    }

    /**
     * Data provider for CRUD. Incorrect values
     *
     * @return array
     */
    private function _getDataProviderIncorrect2()
    {
        return [
            [
                'formModel'                => [
                    'designFormModel' => [
                        'containerDesignBlockModel' => [
                            'marginTop' => '10 a'
                        ],
                        'lineDesignBlockModel'      => [
                            'marginTop' => ' 10 '
                        ],
                        'submitIcon'                => ' icon ',
                        'submitIconPosition'        => '1s',
                        'submitAlignment'           => '1'
                    ],
                    'hasLabel'        => 999,
                    'successText'     => ' <b>Success '
                ],
                'subjectFormInstanceModel' => [
                    'formModel'      => [
                        'designFormModel' => [
                            'containerDesignBlockModel' => [
                                'marginTop' => '20'
                            ],
                            'lineDesignBlockModel'      => [
                                'marginTop' => '20'
                            ],
                            'submitIcon'                => '  <b> icon-2  ',
                            'submitIconPosition'        => '1',
                            'submitAlignment'           => '1'
                        ],
                        'hasLabel'        => 'true',
                        'successText'     => 'S'
                    ],
                    'sort'           => '10',
                    'label'          => 'Label 3  <b>',
                    'isRequired'     => 'true',
                    'validationType' => '1',
                    'type'           => '1',
                ],
                'subjectText'              => '  Subject  ',
                'host'                     => '  127.0.0.1  ',
                'port'                     => '80',
                'type'                     => '<b> smtp',
                'user'                     => ' user ',
                'password'                 => ' pass ',
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
            ],
        ];
    }

    /**
     * Data provider for CRUD. Incorrect values
     *
     * @return array
     */
    private function _getDataProviderIncorrect3()
    {
        return [
            [
                'subjectFormInstanceModel' => [
                    'label' => 'Label',
                ],
                'subjectText'              => '<b>incorrect',
                'host'                     => '<b>incorrect',
                'port'                     => '<b>incorrect',
                'type'                     => '<b>incorrect',
                'user'                     => '<b>incorrect',
                'password'                 => '<b>incorrect',
            ],
            [
                'subjectText' => 'incorrect',
                'host'        => '<b>incorrect',
                'port'        => 0,
                'type'        => 'incorrect',
                'user'        => 'incorrect',
                'password'    => '<b>incorrect',
            ]
        ];
    }

    /**
     * Data provider for CRUD. Incorrect values
     *
     * @return array
     */
    private function _getDataProviderIncorrect4()
    {
        return [
            [
                'subjectFormInstanceModel' => [
                    'label' => 'Label',
                ],
                'subjectText'
                    => $this->generateStringWithLength(256),
                'host'
                    => $this->generateStringWithLength(256),
                'type'
                    => $this->generateStringWithLength(26),
                'user'
                    => $this->generateStringWithLength(256),
                'password'
                    => $this->generateStringWithLength(256),
            ],
            [
                'subjectText' => ['maxLength'],
                'host'        => ['maxLength'],
                'type'        => ['maxLength'],
                'user'        => ['maxLength'],
                'password'    => ['maxLength'],
            ]
        ];
    }
}
