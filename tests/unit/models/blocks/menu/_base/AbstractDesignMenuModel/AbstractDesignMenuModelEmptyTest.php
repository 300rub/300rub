<?php

namespace testS\tests\unit\models\blocks\menu\_base\AbstractDesignMenuModel;

use testS\models\blocks\menu\DesignMenuModel;
use testS\tests\unit\models\_abstract\_base\AbstractEmptyModelTest;

/**
 * Tests for the model AbstractDesignMenuModel
 */
class AbstractDesignMenuModelEmptyTest extends AbstractEmptyModelTest
{

    /**
     * Gets model name
     *
     * @return DesignMenuModel
     */
    protected function getNewModel()
    {
        return new DesignMenuModel();
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
                'firstLevelDesignBlockModel'  => [
                    'marginTop' => 0
                ],
                'firstLevelDesignTextModel'   => [
                    'size' => 0
                ],
                'secondLevelDesignBlockModel' => [
                    'marginTop' => 0
                ],
                'secondLevelDesignTextModel'  => [
                    'size' => 0
                ],
                'lastLevelDesignBlockModel'   => [
                    'marginTop' => 0
                ],
                'lastLevelDesignTextModel'    => [
                    'size' => 0
                ],
            ],
            [
                'containerDesignBlockModel'   => '',
                'firstLevelDesignBlockModel'  => '',
                'firstLevelDesignTextModel'   => '',
                'secondLevelDesignBlockModel' => '',
                'secondLevelDesignTextModel'  => '',
                'lastLevelDesignBlockModel'   => '',
                'lastLevelDesignTextModel'    => '',
            ],
            [
                'containerDesignBlockModel'   => [
                    'marginTop' => 0
                ],
                'firstLevelDesignBlockModel'  => [
                    'marginTop' => 0
                ],
                'firstLevelDesignTextModel'   => [
                    'size' => 0
                ],
                'secondLevelDesignBlockModel' => [
                    'marginTop' => 0
                ],
                'secondLevelDesignTextModel'  => [
                    'size' => 0
                ],
                'lastLevelDesignBlockModel'   => [
                    'marginTop' => 0
                ],
                'lastLevelDesignTextModel'    => [
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
                'containerDesignBlockModel'   => null,
                'firstLevelDesignBlockModel'  => null,
                'firstLevelDesignTextModel'   => null,
                'secondLevelDesignBlockModel' => null,
                'secondLevelDesignTextModel'  => null,
                'lastLevelDesignBlockModel'   => null,
                'lastLevelDesignTextModel'    => null,
            ],
            [
                'containerDesignBlockModel'   => [
                    'marginTop' => 0
                ],
                'firstLevelDesignBlockModel'  => [
                    'marginTop' => 0
                ],
                'firstLevelDesignTextModel'   => [
                    'size' => 0
                ],
                'secondLevelDesignBlockModel' => [
                    'marginTop' => 0
                ],
                'secondLevelDesignTextModel'  => [
                    'size' => 0
                ],
                'lastLevelDesignBlockModel'   => [
                    'marginTop' => 0
                ],
                'lastLevelDesignTextModel'    => [
                    'size' => 0
                ],
            ],
            [
                'containerDesignBlockModel'   => ' ',
                'firstLevelDesignBlockModel'  => ' ',
                'firstLevelDesignTextModel'   => ' ',
                'secondLevelDesignBlockModel' => ' ',
                'secondLevelDesignTextModel'  => ' ',
                'lastLevelDesignBlockModel'   => ' ',
                'lastLevelDesignTextModel'    => ' ',
            ],
            [
                'containerDesignBlockModel'   => [
                    'marginTop' => 0
                ],
                'firstLevelDesignBlockModel'  => [
                    'marginTop' => 0
                ],
                'firstLevelDesignTextModel'   => [
                    'size' => 0
                ],
                'secondLevelDesignBlockModel' => [
                    'marginTop' => 0
                ],
                'secondLevelDesignTextModel'  => [
                    'size' => 0
                ],
                'lastLevelDesignBlockModel'   => [
                    'marginTop' => 0
                ],
                'lastLevelDesignTextModel'    => [
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
                'containerDesignBlockId'   => ' ',
                'firstLevelDesignBlockId'  => ' ',
                'firstLevelDesignTextId'   => ' ',
                'secondLevelDesignBlockId' => ' ',
                'secondLevelDesignTextId'  => ' ',
                'lastLevelDesignBlockId'   => ' ',
                'lastLevelDesignTextId'    => ' ',
            ],
            [
                'containerDesignBlockModel'   => [
                    'marginTop' => 0
                ],
                'firstLevelDesignBlockModel'  => [
                    'marginTop' => 0
                ],
                'firstLevelDesignTextModel'   => [
                    'size' => 0
                ],
                'secondLevelDesignBlockModel' => [
                    'marginTop' => 0
                ],
                'secondLevelDesignTextModel'  => [
                    'size' => 0
                ],
                'lastLevelDesignBlockModel'   => [
                    'marginTop' => 0
                ],
                'lastLevelDesignTextModel'    => [
                    'size' => 0
                ],
            ],
            [
                'containerDesignBlockId'   => null,
                'firstLevelDesignBlockId'  => null,
                'firstLevelDesignTextId'   => null,
                'secondLevelDesignBlockId' => null,
                'secondLevelDesignTextId'  => null,
                'lastLevelDesignBlockId'   => null,
                'lastLevelDesignTextId'    => null,
            ],
            [
                'containerDesignBlockModel'   => [
                    'marginTop' => 0
                ],
                'firstLevelDesignBlockModel'  => [
                    'marginTop' => 0
                ],
                'firstLevelDesignTextModel'   => [
                    'size' => 0
                ],
                'secondLevelDesignBlockModel' => [
                    'marginTop' => 0
                ],
                'secondLevelDesignTextModel'  => [
                    'size' => 0
                ],
                'lastLevelDesignBlockModel'   => [
                    'marginTop' => 0
                ],
                'lastLevelDesignTextModel'    => [
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
                'containerDesignBlockModel'   => [
                    'marginTop' => ' '
                ],
                'firstLevelDesignBlockModel'  => [
                    'marginTop' => ' '
                ],
                'firstLevelDesignTextModel'   => [
                    'size' => ' '
                ],
                'secondLevelDesignBlockModel' => [
                    'marginTop' => ' '
                ],
                'secondLevelDesignTextModel'  => [
                    'size' => ' '
                ],
                'lastLevelDesignBlockModel'   => [
                    'marginTop' => ' '
                ],
                'lastLevelDesignTextModel'    => [
                    'size' => ' '
                ],
            ],
            [
                'containerDesignBlockModel'   => [
                    'marginTop' => 0
                ],
                'firstLevelDesignBlockModel'  => [
                    'marginTop' => 0
                ],
                'firstLevelDesignTextModel'   => [
                    'size' => 0
                ],
                'secondLevelDesignBlockModel' => [
                    'marginTop' => 0
                ],
                'secondLevelDesignTextModel'  => [
                    'size' => 0
                ],
                'lastLevelDesignBlockModel'   => [
                    'marginTop' => 0
                ],
                'lastLevelDesignTextModel'    => [
                    'size' => 0
                ],
            ],
            [
                'containerDesignBlockModel'   => [],
                'firstLevelDesignBlockModel'  => [],
                'firstLevelDesignTextModel'   => [],
                'secondLevelDesignBlockModel' => [],
                'secondLevelDesignTextModel'  => [],
                'lastLevelDesignBlockModel'   => [],
                'lastLevelDesignTextModel'    => [],
            ],
            [
                'containerDesignBlockModel'   => [
                    'marginTop' => 0
                ],
                'firstLevelDesignBlockModel'  => [
                    'marginTop' => 0
                ],
                'firstLevelDesignTextModel'   => [
                    'size' => 0
                ],
                'secondLevelDesignBlockModel' => [
                    'marginTop' => 0
                ],
                'secondLevelDesignTextModel'  => [
                    'size' => 0
                ],
                'lastLevelDesignBlockModel'   => [
                    'marginTop' => 0
                ],
                'lastLevelDesignTextModel'    => [
                    'size' => 0
                ],
            ],
        ];
    }
}
