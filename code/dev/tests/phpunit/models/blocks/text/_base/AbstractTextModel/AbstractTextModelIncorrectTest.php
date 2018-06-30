<?php

namespace ss\tests\unit\models\blocks\text\_base\AbstractTextModel;

use ss\models\blocks\text\TextModel;
use ss\tests\unit\models\_abstract\_base\AbstractIncorrectModelTest;

/**
 * Tests for the model TextModel
 */
class AbstractTextModelIncorrectTest extends AbstractIncorrectModelTest
{

    /**
     * Gets model name
     *
     * @return TextModel
     */
    protected function getNewModel()
    {
        return new TextModel();
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
            'incorrect2' => $this->_getDataProviderIncorrect2(),
            'incorrect3' => $this->_getDataProviderIncorrect3(),
            'incorrect4' => $this->_getDataProviderIncorrect4(),
            'incorrect5' => $this->_getDataProviderIncorrect5(),
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
                'designTextModel'  => 'incorrect',
                'designBlockModel' => 'incorrect',
                'type'             => 'incorrect',
                'hasEditor'        => 'incorrect',
            ],
            [
                'designTextModel'  => [
                    'size' => 0
                ],
                'designBlockModel' => [
                    'marginTop' => 0
                ],
                'type'             => 0,
                'hasEditor'        => false
            ],
            [
                'designTextModel'  => new TextModel(),
                'designBlockModel' => new \stdClass(),
                'type'             => new \stdClass(),
                'hasEditor'        => new \stdClass(),
            ],
            [
                'designTextModel'  => [
                    'size' => 0
                ],
                'designBlockModel' => [
                    'marginTop' => 0
                ],
                'type'             => 0,
                'hasEditor'        => false
            ]
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
                'designTextModel'  => 1,
                'designBlockModel' => 2,
                'type'             => 999,
                'hasEditor'        => 999,
            ],
            [
                'designTextModel'  => [
                    'size' => 0
                ],
                'designBlockModel' => [
                    'marginTop' => 0
                ],
                'type'             => 0,
                'hasEditor'        => true
            ],
            [
                'designTextModel'  => [],
                'designBlockModel' => [],
                'type'             => -1,
                'hasEditor'        => -1,
            ],
            [
                'designTextModel'  => [
                    'size' => 0
                ],
                'designBlockModel' => [
                    'marginTop' => 0
                ],
                'type'             => 0,
                'hasEditor'        => false
            ]
        ];
    }

    /**
     * Data provider for CRUD. Incorrect values
     *
     * @return array
     */
    private function _getDataProviderIncorrect3()
    {
        return [
            [
                'designTextModel'  => [
                    'size' => '30'
                ],
                'designBlockModel' => [
                    'marginTop' => '45'
                ],
                'type'             => '1',
                'hasEditor'        => 'true',
            ],
            [
                'designTextModel'  => [
                    'size' => 30
                ],
                'designBlockModel' => [
                    'marginTop' => 45
                ],
                'type'             => 1,
                'hasEditor'        => true
            ],
            [
                'designTextModel'  => [
                    'size' => '   50    '
                ],
                'designBlockModel' => [
                    'marginTop' => '   10   '
                ],
                'type'             => 'incorrect',
                'hasEditor'        => '  1   ',
            ],
            [
                'designTextModel'  => [
                    'size' => 50
                ],
                'designBlockModel' => [
                    'marginTop' => 10
                ],
                'type'             => 0,
                'hasEditor'        => true
            ]
        ];
    }

    /**
     * Data provider for CRUD. Incorrect values
     *
     * @return array
     */
    private function _getDataProviderIncorrect4()
    {
        return [
            [
                'designTextId'  => 999,
                'designBlockId' => 999,
                'type'          => [],
                'hasEditor'     => [],
            ],
            [
                'designTextModel'  => [
                    'size' => 0
                ],
                'designBlockModel' => [
                    'marginTop' => 0
                ],
                'type'             => 0,
                'hasEditor'        => false
            ],
            null,
            null,
            self::EXCEPTION_MODEL
        ];
    }

    /**
     * Data provider for CRUD. Incorrect values
     *
     * @return array
     */
    private function _getDataProviderIncorrect5()
    {
        return [
            [
                'designTextModel'  => [
                    'size' => '30 aaa'
                ],
                'designBlockModel' => [
                    'marginTop' => '45 sss'
                ],
                'type'             => '1dd',
                'hasEditor'        => '1aa',
            ],
            [
                'designTextModel'  => [
                    'size' => 30
                ],
                'designBlockModel' => [
                    'marginTop' => 45
                ],
                'type'             => 1,
                'hasEditor'        => false
            ],
            [
                'designTextId'  => 999,
                'designBlockId' => 999,
                'type'          => [],
                'hasEditor'     => [],
            ],
            [
                'designTextModel'  => [
                    'size' => 30
                ],
                'designBlockModel' => [
                    'marginTop' => 45
                ],
                'type'             => 0,
                'hasEditor'        => false
            ]
        ];
    }
}
