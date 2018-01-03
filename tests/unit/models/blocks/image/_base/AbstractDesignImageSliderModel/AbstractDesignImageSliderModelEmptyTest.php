<?php

namespace testS\tests\unit\models\image\_base\AbstractDesignImageSliderModel;

use testS\models\blocks\image\DesignImageSliderModel;
use testS\tests\unit\models\_abstract\_base\AbstractEmptyModelTest;

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
                'containerDesignBlockModel'   => [
                    'marginTop' => 0
                ],
                'navigationDesignBlockModel'  => [
                    'marginTop' => 0
                ],
                'descriptionDesignBlockModel' => [
                    'marginTop' => 0
                ],
                'effect'                      => 0,
                'hasAutoPlay'                 => false,
                'playSpeed'                   => 0,
                'navigationAlignment'         => 0,
                'descriptionAlignment'        => 0,
            ],
            [
                'containerDesignBlockModel'   => '',
                'navigationDesignBlockModel'  => '',
                'descriptionDesignBlockModel' => '',
                'effect'                      => '',
                'hasAutoPlay'                 => '',
                'playSpeed'                   => '',
                'navigationAlignment'         => '',
                'descriptionAlignment'        => '',
            ],
            [
                'containerDesignBlockModel'   => [
                    'marginTop' => 0
                ],
                'navigationDesignBlockModel'  => [
                    'marginTop' => 0
                ],
                'descriptionDesignBlockModel' => [
                    'marginTop' => 0
                ],
                'effect'                      => 0,
                'hasAutoPlay'                 => false,
                'playSpeed'                   => 0,
                'navigationAlignment'         => 0,
                'descriptionAlignment'        => 0,
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
                'containerDesignBlockModel'   => null,
                'navigationDesignBlockModel'  => null,
                'descriptionDesignBlockModel' => null,
                'effect'                      => null,
                'hasAutoPlay'                 => null,
                'playSpeed'                   => null,
                'navigationAlignment'         => null,
                'descriptionAlignment'        => null,
            ],
            [
                'containerDesignBlockModel'   => [
                    'marginTop' => 0
                ],
                'navigationDesignBlockModel'  => [
                    'marginTop' => 0
                ],
                'descriptionDesignBlockModel' => [
                    'marginTop' => 0
                ],
                'effect'                      => 0,
                'hasAutoPlay'                 => false,
                'playSpeed'                   => 0,
                'navigationAlignment'         => 0,
                'descriptionAlignment'        => 0,
            ],
            [
                'containerDesignBlockModel'   => ' ',
                'navigationDesignBlockModel'  => ' ',
                'descriptionDesignBlockModel' => ' ',
                'effect'                      => ' ',
                'hasAutoPlay'                 => ' ',
                'playSpeed'                   => ' ',
                'navigationAlignment'         => ' ',
                'descriptionAlignment'        => ' ',
            ],
            [
                'containerDesignBlockModel'   => [
                    'marginTop' => 0
                ],
                'navigationDesignBlockModel'  => [
                    'marginTop' => 0
                ],
                'descriptionDesignBlockModel' => [
                    'marginTop' => 0
                ],
                'effect'                      => 0,
                'hasAutoPlay'                 => false,
                'playSpeed'                   => 0,
                'navigationAlignment'         => 0,
                'descriptionAlignment'        => 0,
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
                'containerDesignBlockId'   => ' ',
                'navigationDesignBlockId'  => ' ',
                'descriptionDesignBlockId' => ' ',
            ],
            [
                'containerDesignBlockModel'   => [
                    'marginTop' => 0
                ],
                'navigationDesignBlockModel'  => [
                    'marginTop' => 0
                ],
                'descriptionDesignBlockModel' => [
                    'marginTop' => 0
                ],
                'effect'                      => 0,
                'hasAutoPlay'                 => false,
                'playSpeed'                   => 0,
                'navigationAlignment'         => 0,
                'descriptionAlignment'        => 0,
            ],
            [
                'containerDesignBlockId'   => null,
                'navigationDesignBlockId'  => null,
                'descriptionDesignBlockId' => null,
            ],
            [
                'containerDesignBlockModel'   => [
                    'marginTop' => 0
                ],
                'navigationDesignBlockModel'  => [
                    'marginTop' => 0
                ],
                'descriptionDesignBlockModel' => [
                    'marginTop' => 0
                ],
                'effect'                      => 0,
                'hasAutoPlay'                 => false,
                'playSpeed'                   => 0,
                'navigationAlignment'         => 0,
                'descriptionAlignment'        => 0,
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
                'containerDesignBlockModel'   => [
                    'marginTop' => ' '
                ],
                'navigationDesignBlockModel'  => [
                    'marginTop' => ' '
                ],
                'descriptionDesignBlockModel' => [
                    'marginTop' => ' '
                ],
            ],
            [
                'containerDesignBlockModel'   => [
                    'marginTop' => 0
                ],
                'navigationDesignBlockModel'  => [
                    'marginTop' => 0
                ],
                'descriptionDesignBlockModel' => [
                    'marginTop' => 0
                ],
                'effect'                      => 0,
                'hasAutoPlay'                 => false,
                'playSpeed'                   => 0,
                'navigationAlignment'         => 0,
                'descriptionAlignment'        => 0,
            ],
            [
                'containerDesignBlockModel'   => [],
                'navigationDesignBlockModel'  => [],
                'descriptionDesignBlockModel' => [],
            ],
            [
                'containerDesignBlockModel'   => [
                    'marginTop' => 0
                ],
                'navigationDesignBlockModel'  => [
                    'marginTop' => 0
                ],
                'descriptionDesignBlockModel' => [
                    'marginTop' => 0
                ],
                'effect'                      => 0,
                'hasAutoPlay'                 => false,
                'playSpeed'                   => 0,
                'navigationAlignment'         => 0,
                'descriptionAlignment'        => 0,
            ],
        ];
    }
}
