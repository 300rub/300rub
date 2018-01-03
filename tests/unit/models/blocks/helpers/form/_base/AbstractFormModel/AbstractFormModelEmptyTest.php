<?php

namespace testS\tests\unit\models\blocks\helpers\form\_base\AbstractFormModel;

use testS\models\blocks\helpers\form\FormModel;
use testS\tests\unit\models\_abstract\_base\AbstractEmptyModelTest;

/**
 * Tests for the model AbstractFormModel
 */
class AbstractFormModelEmptyTest extends AbstractEmptyModelTest
{

    /**
     * Gets model name
     *
     * @return FormModel
     */
    protected function getNewModel()
    {
        return new FormModel();
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
            'empty3' => $this->_getDataProviderEmpty3()
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
                'designFormModel' => [
                    'containerDesignBlockModel' => [
                        'marginTop' => 0
                    ],
                    'lineDesignBlockModel'      => [
                        'marginTop' => 0
                    ],
                    'submitIcon'                => '',
                    'submitIconPosition'        => 0,
                    'submitAlignment'           => 0
                ],
                'hasLabel'        => false,
                'successText'     => ''
            ],
            [
                'designFormModel' => '',
                'hasLabel'        => '',
                'successText'     => ''
            ],
            [
                'designFormModel' => [
                    'containerDesignBlockModel' => [
                        'marginTop' => 0
                    ],
                    'lineDesignBlockModel'      => [
                        'marginTop' => 0
                    ],
                    'submitIcon'                => '',
                    'submitIconPosition'        => 0,
                    'submitAlignment'           => 0
                ],
                'hasLabel'        => false,
                'successText'     => ''
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
                'designFormModel' => null,
                'hasLabel'        => null,
                'successText'     => null
            ],
            [
                'designFormModel' => [
                    'containerDesignBlockModel' => [
                        'marginTop' => 0
                    ],
                    'lineDesignBlockModel'      => [
                        'marginTop' => 0
                    ],
                    'submitIcon'                => '',
                    'submitIconPosition'        => 0,
                    'submitAlignment'           => 0
                ],
                'hasLabel'        => false,
                'successText'     => ''
            ],
            [
                'designFormModel' => [
                    'containerDesignBlockModel' => [
                        'marginTop' => ' '
                    ],
                    'lineDesignBlockModel'      => [
                        'marginTop' => ' '
                    ],
                    'submitIcon'                => ' ',
                    'submitIconPosition'        => ' ',
                    'submitAlignment'           => ' '
                ],
                'hasLabel'        => ' ',
                'successText'     => ' '
            ],
            [
                'designFormModel' => [
                    'containerDesignBlockModel' => [
                        'marginTop' => 0
                    ],
                    'lineDesignBlockModel'      => [
                        'marginTop' => 0
                    ],
                    'submitIcon'                => '',
                    'submitIconPosition'        => 0,
                    'submitAlignment'           => 0
                ],
                'hasLabel'        => false,
                'successText'     => ''
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
                'designFormId' => ' ',
            ],
            [
                'designFormModel' => [
                    'containerDesignBlockModel' => [
                        'marginTop' => 0
                    ],
                    'lineDesignBlockModel'      => [
                        'marginTop' => 0
                    ],
                    'submitIcon'                => '',
                    'submitIconPosition'        => 0,
                    'submitAlignment'           => 0
                ],
                'hasLabel'        => false,
                'successText'     => ''
            ],
        ];
    }
}
