<?php

// @codingStandardsIgnoreLine
namespace ss\tests\unit\models\blocks\image\_base\AbstractDesignImageSliderModel;

use ss\models\blocks\image\DesignImageSliderModel;
use ss\tests\unit\models\_abstract\_base\AbstractEmptyModelTest;

/**
 * Tests for the model AbstractDesignImageSliderModel
 */
class AbstractDesignImageSliderModelEmptyTest extends AbstractEmptyModelTest
{

    /**
     * Gets model name
     *
     * @return DesignImageSliderModel
     */
    protected function getNewModel()
    {
        return new DesignImageSliderModel();
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
                'bulletDesignBlockModel'   => [
                    'marginTop' => 0
                ],
                'hasAutoPlay'                 => false,
                'playSpeed'                   => 0,
            ],
            [
                'bulletDesignBlockModel'   => '',
                'hasAutoPlay'                 => '',
                'playSpeed'                   => '',
            ],
            [
                'bulletDesignBlockModel'   => [
                    'marginTop' => 0
                ],
                'hasAutoPlay'                 => false,
                'playSpeed'                   => 0,
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
                'bulletDesignBlockModel'   => null,
                'hasAutoPlay'                 => null,
                'playSpeed'                   => null,
            ],
            [
                'bulletDesignBlockModel'   => [
                    'marginTop' => 0
                ],
                'hasAutoPlay'                 => false,
                'playSpeed'                   => 0,
            ],
            [
                'bulletDesignBlockModel'   => ' ',
                'hasAutoPlay'                 => ' ',
                'playSpeed'                   => ' ',
            ],
            [
                'bulletDesignBlockModel'   => [
                    'marginTop' => 0
                ],
                'hasAutoPlay'                 => false,
                'playSpeed'                   => 0,
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
                'bulletDesignBlockId'   => ' ',
            ],
            [
                'bulletDesignBlockModel'   => [
                    'marginTop' => 0
                ],
                'hasAutoPlay'                 => false,
                'playSpeed'                   => 0,
            ],
            [
                'bulletDesignBlockId'   => null,
            ],
            [
                'bulletDesignBlockModel'   => [
                    'marginTop' => 0
                ],
                'hasAutoPlay'                 => false,
                'playSpeed'                   => 0,
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
                'bulletDesignBlockModel'   => [
                    'marginTop' => ' '
                ],
            ],
            [
                'bulletDesignBlockModel'   => [
                    'marginTop' => 0
                ],
                'hasAutoPlay'                 => false,
                'playSpeed'                   => 0,
            ],
            [
                'bulletDesignBlockModel'   => [],
            ],
            [
                'bulletDesignBlockModel'   => [
                    'marginTop' => 0
                ],
                'hasAutoPlay'                 => false,
                'playSpeed'                   => 0,
            ],
        ];
    }
}
