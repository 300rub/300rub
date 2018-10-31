<?php

// @codingStandardsIgnoreLine
namespace ss\tests\phpunit\models\blocks\helpers\form\_base\AbstractDesignFormModel;

use ss\models\blocks\helpers\form\DesignFormModel;
use ss\tests\phpunit\models\_abstract\_base\AbstractEmptyModelTest;

/**
 * Tests for the model AbstractDesignFormModel
 */
class AbstractDesignFormModelEmptyTest extends AbstractEmptyModelTest
{

    /**
     * Gets model name
     *
     * @return DesignFormModel
     */
    protected function getNewModel()
    {
        return new DesignFormModel();
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
                'lineDesignBlockModel'      => [
                    'marginTop' => 0
                ],
                'labelDesignBlockModel'     => [
                    'marginTop' => 0
                ],
                'labelDesignTextModel'      => [
                    'size' => 0
                ],
                'formDesignBlockModel'      => [
                    'marginTop' => 0
                ],
                'formDesignTextModel'       => [
                    'size' => 0
                ],
                'submitDesignBlockModel'    => [
                    'marginTop' => 0
                ],
                'submitDesignTextModel'     => [
                    'size' => 0
                ],
                'submitIconDesignTextModel' => [
                    'size' => 0
                ],
                'submitIcon'                => '',
                'submitIconPosition'        => 0,
                'submitAlignment'           => 0
            ],
            [
                'containerDesignBlockModel' => '',
                'lineDesignBlockModel'      => '',
                'labelDesignBlockModel'     => '',
                'labelDesignTextModel'      => '',
                'formDesignBlockModel'      => '',
                'formDesignTextModel'       => '',
                'submitDesignBlockModel'    => '',
                'submitDesignTextModel'     => '',
                'submitIconDesignTextModel' => '',
                'submitIcon'                => '',
                'submitIconPosition'        => '',
                'submitAlignment'           => ''
            ],
            [
                'containerDesignBlockModel' => [
                    'marginTop' => 0
                ],
                'lineDesignBlockModel'      => [
                    'marginTop' => 0
                ],
                'labelDesignBlockModel'     => [
                    'marginTop' => 0
                ],
                'labelDesignTextModel'      => [
                    'size' => 0
                ],
                'formDesignBlockModel'      => [
                    'marginTop' => 0
                ],
                'formDesignTextModel'       => [
                    'size' => 0
                ],
                'submitDesignBlockModel'    => [
                    'marginTop' => 0
                ],
                'submitDesignTextModel'     => [
                    'size' => 0
                ],
                'submitIconDesignTextModel' => [
                    'size' => 0
                ],
                'submitIcon'                => '',
                'submitIconPosition'        => 0,
                'submitAlignment'           => 0
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
                'lineDesignBlockModel'      => null,
                'labelDesignBlockModel'     => null,
                'labelDesignTextModel'      => null,
                'formDesignBlockModel'      => null,
                'formDesignTextModel'       => null,
                'submitDesignBlockModel'    => null,
                'submitDesignTextModel'     => null,
                'submitIconDesignTextModel' => null,
                'submitIcon'                => null,
                'submitIconPosition'        => null,
                'submitAlignment'           => null,
            ],
            [
                'containerDesignBlockModel' => [
                    'marginTop' => 0
                ],
                'lineDesignBlockModel'      => [
                    'marginTop' => 0
                ],
                'labelDesignBlockModel'     => [
                    'marginTop' => 0
                ],
                'labelDesignTextModel'      => [
                    'size' => 0
                ],
                'formDesignBlockModel'      => [
                    'marginTop' => 0
                ],
                'formDesignTextModel'       => [
                    'size' => 0
                ],
                'submitDesignBlockModel'    => [
                    'marginTop' => 0
                ],
                'submitDesignTextModel'     => [
                    'size' => 0
                ],
                'submitIconDesignTextModel' => [
                    'size' => 0
                ],
                'submitIcon'                => '',
                'submitIconPosition'        => 0,
                'submitAlignment'           => 0
            ],
            [
                'containerDesignBlockModel' => ' ',
                'lineDesignBlockModel'      => ' ',
                'labelDesignBlockModel'     => ' ',
                'labelDesignTextModel'      => ' ',
                'formDesignBlockModel'      => ' ',
                'formDesignTextModel'       => ' ',
                'submitDesignBlockModel'    => ' ',
                'submitDesignTextModel'     => ' ',
                'submitIconDesignTextModel' => ' ',
                'submitIcon'                => ' ',
                'submitIconPosition'        => ' ',
                'submitAlignment'           => ' ',
            ],
            [
                'containerDesignBlockModel' => [
                    'marginTop' => 0
                ],
                'lineDesignBlockModel'      => [
                    'marginTop' => 0
                ],
                'labelDesignBlockModel'     => [
                    'marginTop' => 0
                ],
                'labelDesignTextModel'      => [
                    'size' => 0
                ],
                'formDesignBlockModel'      => [
                    'marginTop' => 0
                ],
                'formDesignTextModel'       => [
                    'size' => 0
                ],
                'submitDesignBlockModel'    => [
                    'marginTop' => 0
                ],
                'submitDesignTextModel'     => [
                    'size' => 0
                ],
                'submitIconDesignTextModel' => [
                    'size' => 0
                ],
                'submitIcon'                => '',
                'submitIconPosition'        => 0,
                'submitAlignment'           => 0
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
                'lineDesignBlockId'      => ' ',
                'labelDesignBlockId'     => ' ',
                'labelDesignTextId'      => ' ',
                'formDesignBlockId'      => ' ',
                'formDesignTextId'       => ' ',
                'submitDesignBlockId'    => ' ',
                'submitDesignTextId'     => ' ',
                'submitIconDesignTextId' => ' ',
            ],
            [
                'containerDesignBlockModel' => [
                    'marginTop' => 0
                ],
                'lineDesignBlockModel'      => [
                    'marginTop' => 0
                ],
                'labelDesignBlockModel'     => [
                    'marginTop' => 0
                ],
                'labelDesignTextModel'      => [
                    'size' => 0
                ],
                'formDesignBlockModel'      => [
                    'marginTop' => 0
                ],
                'formDesignTextModel'       => [
                    'size' => 0
                ],
                'submitDesignBlockModel'    => [
                    'marginTop' => 0
                ],
                'submitDesignTextModel'     => [
                    'size' => 0
                ],
                'submitIconDesignTextModel' => [
                    'size' => 0
                ],
                'submitIcon'                => '',
                'submitIconPosition'        => 0,
                'submitAlignment'           => 0
            ],
            [
                'containerDesignBlockId' => null,
                'lineDesignBlockId'      => null,
                'labelDesignBlockId'     => null,
                'labelDesignTextId'      => null,
                'formDesignBlockId'      => null,
                'formDesignTextId'       => null,
                'submitDesignBlockId'    => null,
                'submitDesignTextId'     => null,
                'submitIconDesignTextId' => null,
            ],
            [
                'containerDesignBlockModel' => [
                    'marginTop' => 0
                ],
                'lineDesignBlockModel'      => [
                    'marginTop' => 0
                ],
                'labelDesignBlockModel'     => [
                    'marginTop' => 0
                ],
                'labelDesignTextModel'      => [
                    'size' => 0
                ],
                'formDesignBlockModel'      => [
                    'marginTop' => 0
                ],
                'formDesignTextModel'       => [
                    'size' => 0
                ],
                'submitDesignBlockModel'    => [
                    'marginTop' => 0
                ],
                'submitDesignTextModel'     => [
                    'size' => 0
                ],
                'submitIconDesignTextModel' => [
                    'size' => 0
                ],
                'submitIcon'                => '',
                'submitIconPosition'        => 0,
                'submitAlignment'           => 0
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
                'lineDesignBlockModel'      => [
                    'marginTop' => ' '
                ],
                'labelDesignBlockModel'     => [
                    'marginTop' => ' '
                ],
                'labelDesignTextModel'      => [
                    'size' => ' '
                ],
                'formDesignBlockModel'      => [
                    'marginTop' => ' '
                ],
                'formDesignTextModel'       => [
                    'size' => ' '
                ],
            ],
            [
                'containerDesignBlockModel' => [
                    'marginTop' => 0
                ],
                'lineDesignBlockModel'      => [
                    'marginTop' => 0
                ],
                'labelDesignBlockModel'     => [
                    'marginTop' => 0
                ],
                'labelDesignTextModel'      => [
                    'size' => 0
                ],
                'formDesignBlockModel'      => [
                    'marginTop' => 0
                ],
                'formDesignTextModel'       => [
                    'size' => 0
                ],
                'submitDesignBlockModel'    => [
                    'marginTop' => 0
                ],
                'submitDesignTextModel'     => [
                    'size' => 0
                ],
                'submitIconDesignTextModel' => [
                    'size' => 0
                ],
                'submitIcon'                => '',
                'submitIconPosition'        => 0,
                'submitAlignment'           => 0
            ],
            [
                'formDesignBlockModel'      => [],
                'formDesignTextModel'       => [],
                'submitDesignBlockModel'    => [],
                'submitDesignTextModel'     => [],
                'submitIconDesignTextModel' => [],
            ],
            [
                'containerDesignBlockModel' => [
                    'marginTop' => 0
                ],
                'lineDesignBlockModel'      => [
                    'marginTop' => 0
                ],
                'labelDesignBlockModel'     => [
                    'marginTop' => 0
                ],
                'labelDesignTextModel'      => [
                    'size' => 0
                ],
                'formDesignBlockModel'      => [
                    'marginTop' => 0
                ],
                'formDesignTextModel'       => [
                    'size' => 0
                ],
                'submitDesignBlockModel'    => [
                    'marginTop' => 0
                ],
                'submitDesignTextModel'     => [
                    'size' => 0
                ],
                'submitIconDesignTextModel' => [
                    'size' => 0
                ],
                'submitIcon'                => '',
                'submitIconPosition'        => 0,
                'submitAlignment'           => 0
            ],
        ];
    }
}
