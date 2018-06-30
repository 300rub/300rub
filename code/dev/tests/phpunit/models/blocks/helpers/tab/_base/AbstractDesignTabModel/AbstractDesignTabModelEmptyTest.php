<?php

// @codingStandardsIgnoreLine
namespace ss\tests\unit\models\blocks\helpers\tab\_base\AbstractDesignTabModel;

use ss\models\blocks\helpers\tab\DesignTabModel;
use ss\tests\unit\models\_abstract\_base\AbstractEmptyModelTest;

/**
 * Tests for the model AbstractDesignTabModel
 */
class AbstractDesignTabModelEmptyTest extends AbstractEmptyModelTest
{

    /**
     * Gets model name
     *
     * @return DesignTabModel
     */
    protected function getNewModel()
    {
        return new DesignTabModel();
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
            [
                'containerDesignBlockModel' => '',
                'tabDesignBlockModel'       => '',
                'tabDesignTextModel'        => '',
                'contentDesignBlockModel'   => '',
            ],
            [
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
                'tabDesignBlockModel'       => null,
                'tabDesignTextModel'        => null,
                'contentDesignBlockModel'   => null,
            ],
            [
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
            [
                'containerDesignBlockModel' => ' ',
                'tabDesignBlockModel'       => ' ',
                'tabDesignTextModel'        => ' ',
                'contentDesignBlockModel'   => ' ',
            ],
            [
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
                'tabDesignBlockId'       => ' ',
                'tabDesignTextId'        => ' ',
                'contentDesignBlockId'   => ' ',
            ],
            [
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
            [
                'containerDesignBlockId' => null,
                'tabDesignBlockId'       => null,
                'tabDesignTextId'        => null,
                'contentDesignBlockId'   => null,
            ],
            [
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
            [
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
            [
                'containerDesignBlockModel' => [],
                'tabDesignBlockModel'       => [],
                'tabDesignTextModel'        => [],
                'contentDesignBlockModel'   => [],
            ],
            [
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
        ];
    }
}
