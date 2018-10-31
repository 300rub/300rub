<?php

namespace ss\tests\phpunit\models\blocks\helpers\tab\_base\AbstractTabModel;

use ss\models\blocks\helpers\tab\TabModel;
use ss\tests\phpunit\models\_abstract\_base\AbstractEmptyModelTest;

/**
 * Tests for the model AbstractTabModel
 */
class AbstractTabModelEmptyTest extends AbstractEmptyModelTest
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
     * Data provider for CRUD. Empty values
     *
     * @return array
     */
    protected function getDataProviderEmpty()
    {
        return [
            'empty1' => $this->_getDataProviderEmpty1(),
            'empty2' => $this->_getDataProviderEmpty2(),
            'empty3' => $this->_getDataProviderEmpty3(),
            'empty4' => $this->_getDataProviderEmpty4()
        ];
    }

    /**
     * Data provider for CRUD. Empty values
     *
     * @return array
     */
    private function _getDataProviderEmpty1()
    {
        return [
            [],
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
                    'containerDesignBlockModel' => '',
                    'tabDesignBlockModel'       => '',
                    'tabDesignTextModel'        => '',
                    'contentDesignBlockModel'   => '',
                ],
                'textModel'       => [
                    'designTextModel'  => '',
                    'designBlockModel' => '',
                    'type'             => '',
                    'hasEditor'        => '',
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
     * Data provider for CRUD. Empty values
     *
     * @return array
     */
    private function _getDataProviderEmpty2()
    {
        return [
            [
                'designTabsModel' => '',
                'textModel'       => '',
                'isShowEmpty'     => '',
                'isLazyLoad'      => '',
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
            ]
        ];
    }

    /**
     * Data provider for CRUD. Empty values
     *
     * @return array
     */
    private function _getDataProviderEmpty3()
    {
        return [
            [
                'designTabsModel' => null,
                'textModel'       => null,
                'isShowEmpty'     => null,
                'isLazyLoad'      => null,
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
                    'containerDesignBlockModel' => null,
                    'tabDesignBlockModel'       => null,
                    'tabDesignTextModel'        => null,
                    'contentDesignBlockModel'   => null,
                ],
                'textModel'       => [
                    'designTextModel'  => null,
                    'designBlockModel' => null,
                    'type'             => null,
                    'hasEditor'        => null,
                ],
                'isShowEmpty'     => null,
                'isLazyLoad'      => null,
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
     * Data provider for CRUD. Empty values
     *
     * @return array
     */
    private function _getDataProviderEmpty4()
    {
        return [
            [
                'designTabsModel' => [
                    'containerDesignBlockModel' => [
                        'marginTop' => ' '
                    ],
                    'tabDesignBlockModel'       => [
                        'marginTop' => ' '
                    ],
                    'tabDesignTextModel'        => [
                        'size' => ' '
                    ],
                    'contentDesignBlockModel'   => [
                        'marginTop' => ' '
                    ],
                ],
                'textModel'       => [
                    'designTextModel'  => [
                        'size' => ' '
                    ],
                    'designBlockModel' => [
                        'marginTop' => ' '
                    ],
                    'type'             => ' ',
                    'hasEditor'        => ' ',
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
                'designTabsId' => ' ',
                'textId'       => ' '
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
}
