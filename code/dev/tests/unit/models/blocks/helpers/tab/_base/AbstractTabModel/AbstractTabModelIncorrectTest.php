<?php

namespace ss\tests\unit\models\blocks\helpers\tab\_base\AbstractTabModel;

use ss\models\blocks\helpers\tab\TabModel;
use ss\tests\unit\models\_abstract\_base\AbstractIncorrectModelTest;

/**
 * Tests for the model AbstractTabModel
 */
class AbstractTabModelIncorrectTest extends AbstractIncorrectModelTest
{

    /**
     * Gets model name
     *
     * @return TabModel
     */
    protected function getNewModel()
    {
        return new TabModel();
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
            'incorrect2' => $this->_getDataProviderIncorrect2()
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
                'designTabsModel' => 'incorrect',
                'textModel'       => 'incorrect',
                'isShowEmpty'     => 'incorrect',
                'isLazyLoad'      => 'incorrect',
            ],
            [
                'designTabsModel' => [
                    'containerDesignBlockModel' => [
                        'marginTop' => 0
                    ],
                    'tabDesignBlockModel'       => [
                        'marginTop' => 0
                    ],
                    'tabDesignTextModel'        => [
                        'size' => 0
                    ],
                    'contentDesignBlockModel'   => [
                        'marginTop' => 0
                    ],
                ],
                'textModel'       => [
                    'designTextModel'  => [
                        'size' => 0
                    ],
                    'designBlockModel' => [
                        'marginTop' => 0
                    ],
                    'type'             => 0,
                    'hasEditor'        => false,
                ],
                'isShowEmpty'     => false,
                'isLazyLoad'      => false,
            ],
            [
                'designTabsModel' => [
                    'containerDesignBlockModel' => 'incorrect',
                    'tabDesignBlockModel'       => 'incorrect',
                    'tabDesignTextModel'        => 'incorrect',
                    'contentDesignBlockModel'   => 'incorrect',
                ],
                'textModel'       => [
                    'designTextModel'  => 'incorrect',
                    'designBlockModel' => 'incorrect',
                    'type'             => 'incorrect',
                    'hasEditor'        => 'incorrect',
                ],
            ],
            [
                'designTabsModel' => [
                    'containerDesignBlockModel' => [
                        'marginTop' => 0
                    ],
                    'tabDesignBlockModel'       => [
                        'marginTop' => 0
                    ],
                    'tabDesignTextModel'        => [
                        'size' => 0
                    ],
                    'contentDesignBlockModel'   => [
                        'marginTop' => 0
                    ],
                ],
                'textModel'       => [
                    'designTextModel'  => [
                        'size' => 0
                    ],
                    'designBlockModel' => [
                        'marginTop' => 0
                    ],
                    'type'             => 0,
                    'hasEditor'        => false,
                ],
                'isShowEmpty'     => false,
                'isLazyLoad'      => false,
            ],
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
                'designTabsModel' => [
                    'containerDesignBlockModel' => [
                        'marginTop' => 'incorrect',
                    ],
                    'tabDesignBlockModel'       => [
                        'marginTop' => 'incorrect',
                    ],
                    'tabDesignTextModel'        => [
                        'size' => 'incorrect',
                    ],
                    'contentDesignBlockModel'   => [
                        'marginTop' => 'incorrect',
                    ],
                ],
                'textModel'       => [
                    'designTextModel'  => [
                        'size' => 'incorrect',
                    ],
                    'designBlockModel' => [
                        'marginTop' => 'incorrect',
                    ],
                ],
            ],
            [
                'designTabsModel' => [
                    'containerDesignBlockModel' => [
                        'marginTop' => 0
                    ],
                    'tabDesignBlockModel'       => [
                        'marginTop' => 0
                    ],
                    'tabDesignTextModel'        => [
                        'size' => 0
                    ],
                    'contentDesignBlockModel'   => [
                        'marginTop' => 0
                    ],
                ],
                'textModel'       => [
                    'designTextModel'  => [
                        'size' => 0
                    ],
                    'designBlockModel' => [
                        'marginTop' => 0
                    ],
                    'type'             => 0,
                    'hasEditor'        => false,
                ],
                'isShowEmpty'     => false,
                'isLazyLoad'      => false,
            ],
            [
                'textModel'       => [
                    'type'             => 9999,
                    'hasEditor'        => 9999,
                ],
                'isShowEmpty'     => 999,
                'isLazyLoad'      => 999,
            ],
            [
                'designTabsModel' => [
                    'containerDesignBlockModel' => [
                        'marginTop' => 0
                    ],
                    'tabDesignBlockModel'       => [
                        'marginTop' => 0
                    ],
                    'tabDesignTextModel'        => [
                        'size' => 0
                    ],
                    'contentDesignBlockModel'   => [
                        'marginTop' => 0
                    ],
                ],
                'textModel'       => [
                    'designTextModel'  => [
                        'size' => 0
                    ],
                    'designBlockModel' => [
                        'marginTop' => 0
                    ],
                    'type'             => 0,
                    'hasEditor'        => true,
                ],
                'isShowEmpty'     => true,
                'isLazyLoad'      => true,
            ],
        ];
    }
}
