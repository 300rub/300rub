<?php

// @codingStandardsIgnoreLine
namespace ss\tests\unit\models\blocks\helpers\field\_base\AbstractDesignFieldModel;

use ss\models\blocks\helpers\field\DesignFieldModel;
use ss\tests\unit\models\_abstract\_base\AbstractEmptyModelTest;

/**
 * Tests for the model AbstractDesignFieldModel
 */
class AbstractDesignFieldModelEmptyTest extends AbstractEmptyModelTest
{

    /**
     * Gets model name
     *
     * @return DesignFieldModel
     */
    protected function getNewModel()
    {
        return new DesignFieldModel();
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
                'shortCardContainerDesignBlockModel' => [
                    'marginTop' => 0
                ],
                'shortCardLabelDesignBlockModel'     => [
                    'marginTop' => 0
                ],
                'shortCardLabelDesignTextModel'      => [
                    'size' => 0
                ],
                'shortCardValueDesignBlockModel'     => [
                    'marginTop' => 0
                ],
                'shortCardValueDesignTextModel'      => [
                    'size' => 0
                ],
                'fullCardContainerDesignBlockModel'  => [
                    'marginTop' => 0
                ],
                'fullCardLabelDesignBlockModel'      => [
                    'marginTop' => 0
                ],
                'fullCardLabelDesignTextModel'       => [
                    'size' => 0
                ],
                'fullCardValueDesignBlockModel'      => [
                    'marginTop' => 0
                ],
                'fullCardValueDesignTextModel'       => [
                    'size' => 0
                ],
            ],
            [
                'shortCardContainerDesignBlockModel' => '',
                'shortCardLabelDesignBlockModel'     => '',
                'shortCardLabelDesignTextModel'      => '',
                'shortCardValueDesignBlockModel'     => '',
                'shortCardValueDesignTextModel'      => '',
                'fullCardContainerDesignBlockModel'  => '',
                'fullCardLabelDesignBlockModel'      => '',
                'fullCardLabelDesignTextModel'       => '',
                'fullCardValueDesignBlockModel'      => '',
                'fullCardValueDesignTextModel'       => '',
            ],
            [
                'shortCardContainerDesignBlockModel' => [
                    'marginTop' => 0
                ],
                'shortCardLabelDesignBlockModel'     => [
                    'marginTop' => 0
                ],
                'shortCardLabelDesignTextModel'      => [
                    'size' => 0
                ],
                'shortCardValueDesignBlockModel'     => [
                    'marginTop' => 0
                ],
                'shortCardValueDesignTextModel'      => [
                    'size' => 0
                ],
                'fullCardContainerDesignBlockModel'  => [
                    'marginTop' => 0
                ],
                'fullCardLabelDesignBlockModel'      => [
                    'marginTop' => 0
                ],
                'fullCardLabelDesignTextModel'       => [
                    'size' => 0
                ],
                'fullCardValueDesignBlockModel'      => [
                    'marginTop' => 0
                ],
                'fullCardValueDesignTextModel'       => [
                    'size' => 0
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
                'shortCardContainerDesignBlockModel' => null,
                'shortCardLabelDesignBlockModel'     => null,
                'shortCardLabelDesignTextModel'      => null,
                'shortCardValueDesignBlockModel'     => null,
                'shortCardValueDesignTextModel'      => null,
                'fullCardContainerDesignBlockModel'  => null,
                'fullCardLabelDesignBlockModel'      => null,
                'fullCardLabelDesignTextModel'       => null,
                'fullCardValueDesignBlockModel'      => null,
                'fullCardValueDesignTextModel'       => null,
            ],
            [
                'shortCardContainerDesignBlockModel' => [
                    'marginTop' => 0
                ],
                'shortCardLabelDesignBlockModel'     => [
                    'marginTop' => 0
                ],
                'shortCardLabelDesignTextModel'      => [
                    'size' => 0
                ],
                'shortCardValueDesignBlockModel'     => [
                    'marginTop' => 0
                ],
                'shortCardValueDesignTextModel'      => [
                    'size' => 0
                ],
                'fullCardContainerDesignBlockModel'  => [
                    'marginTop' => 0
                ],
                'fullCardLabelDesignBlockModel'      => [
                    'marginTop' => 0
                ],
                'fullCardLabelDesignTextModel'       => [
                    'size' => 0
                ],
                'fullCardValueDesignBlockModel'      => [
                    'marginTop' => 0
                ],
                'fullCardValueDesignTextModel'       => [
                    'size' => 0
                ],
            ],
            [
                'shortCardContainerDesignBlockModel' => ' ',
                'shortCardLabelDesignBlockModel'     => ' ',
                'shortCardLabelDesignTextModel'      => ' ',
                'shortCardValueDesignBlockModel'     => ' ',
                'shortCardValueDesignTextModel'      => ' ',
                'fullCardContainerDesignBlockModel'  => ' ',
                'fullCardLabelDesignBlockModel'      => ' ',
                'fullCardLabelDesignTextModel'       => ' ',
                'fullCardValueDesignBlockModel'      => ' ',
                'fullCardValueDesignTextModel'       => ' ',
            ],
            [
                'shortCardContainerDesignBlockModel' => [
                    'marginTop' => 0
                ],
                'shortCardLabelDesignBlockModel'     => [
                    'marginTop' => 0
                ],
                'shortCardLabelDesignTextModel'      => [
                    'size' => 0
                ],
                'shortCardValueDesignBlockModel'     => [
                    'marginTop' => 0
                ],
                'shortCardValueDesignTextModel'      => [
                    'size' => 0
                ],
                'fullCardContainerDesignBlockModel'  => [
                    'marginTop' => 0
                ],
                'fullCardLabelDesignBlockModel'      => [
                    'marginTop' => 0
                ],
                'fullCardLabelDesignTextModel'       => [
                    'size' => 0
                ],
                'fullCardValueDesignBlockModel'      => [
                    'marginTop' => 0
                ],
                'fullCardValueDesignTextModel'       => [
                    'size' => 0
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
                'shortCardContainerDesignBlockId' => ' ',
                'shortCardLabelDesignBlockId'     => ' ',
                'shortCardLabelDesignTextId'      => ' ',
                'shortCardValueDesignBlockId'     => ' ',
                'shortCardValueDesignTextId'      => ' ',
                'fullCardContainerDesignBlockId'  => ' ',
                'fullCardLabelDesignBlockId'      => ' ',
                'fullCardLabelDesignTextId'       => ' ',
                'fullCardValueDesignBlockId'      => ' ',
                'fullCardValueDesignTextId'       => ' ',
            ],
            [
                'shortCardContainerDesignBlockModel' => [
                    'marginTop' => 0
                ],
                'shortCardLabelDesignBlockModel'     => [
                    'marginTop' => 0
                ],
                'shortCardLabelDesignTextModel'      => [
                    'size' => 0
                ],
                'shortCardValueDesignBlockModel'     => [
                    'marginTop' => 0
                ],
                'shortCardValueDesignTextModel'      => [
                    'size' => 0
                ],
                'fullCardContainerDesignBlockModel'  => [
                    'marginTop' => 0
                ],
                'fullCardLabelDesignBlockModel'      => [
                    'marginTop' => 0
                ],
                'fullCardLabelDesignTextModel'       => [
                    'size' => 0
                ],
                'fullCardValueDesignBlockModel'      => [
                    'marginTop' => 0
                ],
                'fullCardValueDesignTextModel'       => [
                    'size' => 0
                ],
            ],
            [
                'shortCardContainerDesignBlockId' => null,
                'shortCardLabelDesignBlockId'     => null,
                'shortCardLabelDesignTextId'      => null,
                'shortCardValueDesignBlockId'     => null,
                'shortCardValueDesignTextId'      => null,
                'fullCardContainerDesignBlockId'  => null,
                'fullCardLabelDesignBlockId'      => null,
                'fullCardLabelDesignTextId'       => null,
                'fullCardValueDesignBlockId'      => null,
                'fullCardValueDesignTextId'       => null,
            ],
            [
                'shortCardContainerDesignBlockModel' => [
                    'marginTop' => 0
                ],
                'shortCardLabelDesignBlockModel'     => [
                    'marginTop' => 0
                ],
                'shortCardLabelDesignTextModel'      => [
                    'size' => 0
                ],
                'shortCardValueDesignBlockModel'     => [
                    'marginTop' => 0
                ],
                'shortCardValueDesignTextModel'      => [
                    'size' => 0
                ],
                'fullCardContainerDesignBlockModel'  => [
                    'marginTop' => 0
                ],
                'fullCardLabelDesignBlockModel'      => [
                    'marginTop' => 0
                ],
                'fullCardLabelDesignTextModel'       => [
                    'size' => 0
                ],
                'fullCardValueDesignBlockModel'      => [
                    'marginTop' => 0
                ],
                'fullCardValueDesignTextModel'       => [
                    'size' => 0
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
                'shortCardContainerDesignBlockModel' => [
                    'marginTop' => ' '
                ],
                'shortCardLabelDesignBlockModel'     => [
                    'marginTop' => ' '
                ],
                'fullCardContainerDesignBlockModel'  => [
                    'marginTop' => ' '
                ],
                'fullCardLabelDesignBlockModel'      => [
                    'marginTop' => ' '
                ],
                'fullCardLabelDesignTextModel'       => [
                    'size' => ' '
                ],
            ],
            [
                'shortCardContainerDesignBlockModel' => [
                    'marginTop' => 0
                ],
                'shortCardLabelDesignBlockModel'     => [
                    'marginTop' => 0
                ],
                'shortCardLabelDesignTextModel'      => [
                    'size' => 0
                ],
                'shortCardValueDesignBlockModel'     => [
                    'marginTop' => 0
                ],
                'shortCardValueDesignTextModel'      => [
                    'size' => 0
                ],
                'fullCardContainerDesignBlockModel'  => [
                    'marginTop' => 0
                ],
                'fullCardLabelDesignBlockModel'      => [
                    'marginTop' => 0
                ],
                'fullCardLabelDesignTextModel'       => [
                    'size' => 0
                ],
                'fullCardValueDesignBlockModel'      => [
                    'marginTop' => 0
                ],
                'fullCardValueDesignTextModel'       => [
                    'size' => 0
                ],
            ],
            [
                'shortCardLabelDesignTextModel'      => [],
                'shortCardValueDesignBlockModel'     => [],
                'shortCardValueDesignTextModel'      => [],
                'fullCardContainerDesignBlockModel'  => [],
                'fullCardLabelDesignBlockModel'      => [],
                'fullCardValueDesignBlockModel'      => [],
                'fullCardValueDesignTextModel'       => [],
            ],
            [
                'shortCardContainerDesignBlockModel' => [
                    'marginTop' => 0
                ],
                'shortCardLabelDesignBlockModel'     => [
                    'marginTop' => 0
                ],
                'shortCardLabelDesignTextModel'      => [
                    'size' => 0
                ],
                'shortCardValueDesignBlockModel'     => [
                    'marginTop' => 0
                ],
                'shortCardValueDesignTextModel'      => [
                    'size' => 0
                ],
                'fullCardContainerDesignBlockModel'  => [
                    'marginTop' => 0
                ],
                'fullCardLabelDesignBlockModel'      => [
                    'marginTop' => 0
                ],
                'fullCardValueDesignBlockModel'      => [
                    'marginTop' => 0
                ],
                'fullCardValueDesignTextModel'       => [
                    'size' => 0
                ],
            ],
        ];
    }
}
