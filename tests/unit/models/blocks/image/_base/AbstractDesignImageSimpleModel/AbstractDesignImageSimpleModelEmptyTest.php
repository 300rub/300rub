<?php

namespace testS\tests\unit\models\image\_base\AbstractDesignImageSimpleModel;

use testS\models\blocks\image\DesignImageSimpleModel;
use testS\tests\unit\models\_abstract\_base\AbstractEmptyModelTest;

/**
 * Tests for the model AbstractDesignImageSimpleModel
 */
class AbstractDesignImageSimpleModelEmptyTest extends AbstractEmptyModelTest
{

    /**
     * Gets model name
     *
     * @return DesignImageSimpleModel
     */
    protected function getNewModel()
    {
        return new DesignImageSimpleModel();
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
                'containerDesignBlockModel' => [
                    'marginTop' => 0
                ],
                'imageDesignBlockModel'     => [
                    'marginTop' => 0
                ],
                'alignment'                 => 0
            ],
            [
                'containerDesignBlockModel' => '',
                'imageDesignBlockModel'     => '',
                'alignment'                 => '',
            ],
            [
                'containerDesignBlockModel' => [
                    'marginTop' => 0
                ],
                'imageDesignBlockModel'     => [
                    'marginTop' => 0
                ],
                'alignment'                 => 0
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
                'containerDesignBlockModel' => null,
                'imageDesignBlockModel'     => null,
                'alignment'                 => null,
            ],
            [
                'containerDesignBlockModel' => [
                    'marginTop' => 0
                ],
                'imageDesignBlockModel'     => [
                    'marginTop' => 0
                ],
                'alignment'                 => 0
            ],
            [
                'containerDesignBlockModel' => ' ',
                'imageDesignBlockModel'     => ' ',
                'alignment'                 => ' ',
            ],
            [
                'containerDesignBlockModel' => [
                    'marginTop' => 0
                ],
                'imageDesignBlockModel'     => [
                    'marginTop' => 0
                ],
                'alignment'                 => 0
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
                'containerDesignBlockId' => ' ',
                'imageDesignBlockId'     => ' ',
                'alignment'              => ' ',
            ],
            [
                'containerDesignBlockModel' => [
                    'marginTop' => 0
                ],
                'imageDesignBlockModel'     => [
                    'marginTop' => 0
                ],
                'alignment'                 => 0
            ],
            [
                'containerDesignBlockId' => null,
                'imageDesignBlockId'     => null,
                'alignment'              => null,
            ],
            [
                'containerDesignBlockModel' => [
                    'marginTop' => 0
                ],
                'imageDesignBlockModel'     => [
                    'marginTop' => 0
                ],
                'alignment'                 => 0
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
                'containerDesignBlockModel' => [
                    'marginTop' => ' '
                ],
                'imageDesignBlockModel'     => [
                    'marginTop' => ' '
                ],
            ],
            [
                'containerDesignBlockModel' => [
                    'marginTop' => 0
                ],
                'imageDesignBlockModel'     => [
                    'marginTop' => 0
                ],
                'alignment'                 => 0
            ],
            [
                'containerDesignBlockModel' => [],
                'imageDesignBlockModel'     => [],
            ],
            [
                'containerDesignBlockModel' => [
                    'marginTop' => 0
                ],
                'imageDesignBlockModel'     => [
                    'marginTop' => 0
                ],
                'alignment'                 => 0
            ],
        ];
    }
}
