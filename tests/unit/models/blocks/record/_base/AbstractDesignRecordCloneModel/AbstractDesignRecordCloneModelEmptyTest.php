<?php

// @codingStandardsIgnoreLine
namespace ss\tests\unit\models\blocks\record\_base\AbstractDesignRecordCloneModel;

use ss\models\blocks\record\DesignRecordCloneModel;
use ss\tests\unit\models\_abstract\_base\AbstractEmptyModelTest;

/**
 * Tests for the model AbstractDesignRecordCloneModel
 */
class AbstractDesignRecordCloneModelEmptyTest extends AbstractEmptyModelTest
{

    /**
     * Gets model name
     *
     * @return DesignRecordCloneModel
     */
    protected function getNewModel()
    {
        return new DesignRecordCloneModel();
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
                'instanceDesignBlockModel'    => [
                    'marginTop' => 0
                ],
                'titleDesignBlockModel'       => [
                    'marginTop' => 0
                ],
                'titleDesignTextModel'        => [
                    'size' => 0
                ],
                'dateDesignTextModel'         => [
                    'size' => 0
                ],
                'descriptionDesignBlockModel' => [
                    'marginTop' => 0
                ],
                'descriptionDesignTextModel'  => [
                    'size' => 0
                ],
                'viewType'                    => 0,
            ],
            [
                'containerDesignBlockModel'   => '',
                'instanceDesignBlockModel'    => '',
                'titleDesignBlockModel'       => '',
                'titleDesignTextModel'        => '',
                'dateDesignTextModel'         => '',
                'descriptionDesignBlockModel' => '',
                'descriptionDesignTextModel'  => '',
                'viewType'                    => '',
            ],
            [
                'containerDesignBlockModel'   => [
                    'marginTop' => 0
                ],
                'instanceDesignBlockModel'    => [
                    'marginTop' => 0
                ],
                'titleDesignBlockModel'       => [
                    'marginTop' => 0
                ],
                'titleDesignTextModel'        => [
                    'size' => 0
                ],
                'dateDesignTextModel'         => [
                    'size' => 0
                ],
                'descriptionDesignBlockModel' => [
                    'marginTop' => 0
                ],
                'descriptionDesignTextModel'  => [
                    'size' => 0
                ],
                'viewType'                    => 0,
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
                'instanceDesignBlockModel'    => null,
                'titleDesignBlockModel'       => null,
                'titleDesignTextModel'        => null,
                'dateDesignTextModel'         => null,
                'descriptionDesignBlockModel' => null,
                'descriptionDesignTextModel'  => null,
                'viewType'                    => null,
            ],
            [
                'containerDesignBlockModel'   => [
                    'marginTop' => 0
                ],
                'instanceDesignBlockModel'    => [
                    'marginTop' => 0
                ],
                'titleDesignBlockModel'       => [
                    'marginTop' => 0
                ],
                'titleDesignTextModel'        => [
                    'size' => 0
                ],
                'dateDesignTextModel'         => [
                    'size' => 0
                ],
                'descriptionDesignBlockModel' => [
                    'marginTop' => 0
                ],
                'descriptionDesignTextModel'  => [
                    'size' => 0
                ],
                'viewType'                    => 0,
            ],
            [
                'containerDesignBlockModel'   => ' ',
                'instanceDesignBlockModel'    => ' ',
                'titleDesignBlockModel'       => ' ',
                'titleDesignTextModel'        => ' ',
                'dateDesignTextModel'         => ' ',
                'descriptionDesignBlockModel' => ' ',
                'descriptionDesignTextModel'  => ' ',
                'viewType'                    => ' ',
            ],
            [
                'containerDesignBlockModel'   => [
                    'marginTop' => 0
                ],
                'instanceDesignBlockModel'    => [
                    'marginTop' => 0
                ],
                'titleDesignBlockModel'       => [
                    'marginTop' => 0
                ],
                'titleDesignTextModel'        => [
                    'size' => 0
                ],
                'dateDesignTextModel'         => [
                    'size' => 0
                ],
                'descriptionDesignBlockModel' => [
                    'marginTop' => 0
                ],
                'descriptionDesignTextModel'  => [
                    'size' => 0
                ],
                'viewType'                    => 0,
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
                'instanceDesignBlockId'    => ' ',
                'titleDesignBlockId'       => ' ',
                'titleDesignTextId'        => ' ',
                'dateDesignTextId'         => ' ',
                'descriptionDesignBlockId' => ' ',
                'descriptionDesignTextId'  => ' ',
                'viewType'                 => ' ',
            ],
            [
                'containerDesignBlockModel'   => [
                    'marginTop' => 0
                ],
                'instanceDesignBlockModel'    => [
                    'marginTop' => 0
                ],
                'titleDesignBlockModel'       => [
                    'marginTop' => 0
                ],
                'titleDesignTextModel'        => [
                    'size' => 0
                ],
                'dateDesignTextModel'         => [
                    'size' => 0
                ],
                'descriptionDesignBlockModel' => [
                    'marginTop' => 0
                ],
                'descriptionDesignTextModel'  => [
                    'size' => 0
                ],
                'viewType'                    => 0,
            ],
            [
                'containerDesignBlockId'   => null,
                'instanceDesignBlockId'    => null,
                'titleDesignBlockId'       => null,
                'titleDesignTextId'        => null,
                'dateDesignTextId'         => null,
                'descriptionDesignBlockId' => null,
                'descriptionDesignTextId'  => null,
                'viewType'                 => null,
            ],
            [
                'containerDesignBlockModel'   => [
                    'marginTop' => 0
                ],
                'instanceDesignBlockModel'    => [
                    'marginTop' => 0
                ],
                'titleDesignBlockModel'       => [
                    'marginTop' => 0
                ],
                'titleDesignTextModel'        => [
                    'size' => 0
                ],
                'dateDesignTextModel'         => [
                    'size' => 0
                ],
                'descriptionDesignBlockModel' => [
                    'marginTop' => 0
                ],
                'descriptionDesignTextModel'  => [
                    'size' => 0
                ],
                'viewType'                    => 0,
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
                'instanceDesignBlockModel'    => [
                    'marginTop' => ' '
                ],
                'titleDesignBlockModel'       => [
                    'marginTop' => ' '
                ],
                'titleDesignTextModel'        => [
                    'size' => ' '
                ],
                'dateDesignTextModel'         => [
                    'size' => ' '
                ],
                'descriptionDesignBlockModel' => [
                    'marginTop' => ' '
                ],
                'descriptionDesignTextModel'  => [
                    'size' => ' '
                ],
                'viewType'                    => ' ',
            ],
            [
                'containerDesignBlockModel'   => [
                    'marginTop' => 0
                ],
                'instanceDesignBlockModel'    => [
                    'marginTop' => 0
                ],
                'titleDesignBlockModel'       => [
                    'marginTop' => 0
                ],
                'titleDesignTextModel'        => [
                    'size' => 0
                ],
                'dateDesignTextModel'         => [
                    'size' => 0
                ],
                'descriptionDesignBlockModel' => [
                    'marginTop' => 0
                ],
                'descriptionDesignTextModel'  => [
                    'size' => 0
                ],
                'viewType'                    => 0,
            ],
            [
                'containerDesignBlockModel'   => [],
                'instanceDesignBlockModel'    => [],
                'titleDesignBlockModel'       => [],
                'titleDesignTextModel'        => [],
                'dateDesignTextModel'         => [],
                'descriptionDesignBlockModel' => [],
                'descriptionDesignTextModel'  => [],
            ],
            [
                'containerDesignBlockModel'   => [
                    'marginTop' => 0
                ],
                'instanceDesignBlockModel'    => [
                    'marginTop' => 0
                ],
                'titleDesignBlockModel'       => [
                    'marginTop' => 0
                ],
                'titleDesignTextModel'        => [
                    'size' => 0
                ],
                'dateDesignTextModel'         => [
                    'size' => 0
                ],
                'descriptionDesignBlockModel' => [
                    'marginTop' => 0
                ],
                'descriptionDesignTextModel'  => [
                    'size' => 0
                ],
                'viewType'                    => 0,
            ],
        ];
    }
}
