<?php

// @codingStandardsIgnoreLine
namespace ss\tests\unit\models\blocks\image\_base\AbstractDesignImageZoomModel;

use ss\models\blocks\image\DesignImageZoomModel;
use ss\tests\unit\models\_abstract\_base\AbstractEmptyModelTest;

/**
 * Tests for the model AbstractDesignImageZoomModel
 */
class AbstractDesignImageZoomModelEmptyTest extends AbstractEmptyModelTest
{

    /**
     * Gets model name
     *
     * @return DesignImageZoomModel
     */
    protected function getNewModel()
    {
        return new DesignImageZoomModel();
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
                'designBlockModel'     => [
                    'marginTop' => 0
                ],
                'effect'               => 0,
            ],
            [
                'designBlockModel'     => '',
                'effect'               => '',
            ],
            [
                'designBlockModel'     => [
                    'marginTop' => 0
                ],
                'effect'               => 0,
            ]
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
                'designBlockModel'     => null,
                'effect'               => null,
            ],
            [
                'designBlockModel'     => [
                    'marginTop' => 0
                ],
                'effect'               => 0,
            ],
            [
                'designBlockModel'     => ' ',
                'effect'               => ' ',
            ],
            [
                'designBlockModel'     => [
                    'marginTop' => 0
                ],
                'effect'               => 0,
            ],
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
                'designBlockId' => ' ',
            ],
            [
                'designBlockModel'     => [
                    'marginTop' => 0
                ],
                'effect'               => 0,
            ],
            [
                'designBlockId' => null,
            ],
            [
                'designBlockModel'     => [
                    'marginTop' => 0
                ],
                'effect'               => 0,
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
                'designBlockModel' => [
                    'marginTop' => ' '
                ],
            ],
            [
                'designBlockModel'     => [
                    'marginTop' => 0
                ],
                'effect'               => 0,
            ],
            [
                'designBlockModel' => [],
            ],
            [
                'designBlockModel'     => [
                    'marginTop' => 0
                ],
                'effect'               => 0,
            ],
        ];
    }
}
