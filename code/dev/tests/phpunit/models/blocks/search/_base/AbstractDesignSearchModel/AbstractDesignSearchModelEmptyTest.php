<?php

namespace ss\tests\unit\models\blocks\search\_base\AbstractDesignSearchModel;

use ss\models\blocks\search\DesignSearchModel;
use ss\tests\unit\models\_abstract\_base\AbstractEmptyModelTest;

/**
 * Tests for the model AbstractDesignSearchModel
 */
class AbstractDesignSearchModelEmptyTest extends AbstractEmptyModelTest
{

    /**
     * Gets model name
     *
     * @return DesignSearchModel
     */
    protected function getNewModel()
    {
        return new DesignSearchModel();
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
                'containerDesignBlockModel'      => [
                    'marginTop' => 0
                ],
                'titleDesignBlockModel'          => [
                    'marginTop' => 0
                ],
                'titleDesignTextModel'           => [
                    'size' => 0
                ],
                'descriptionDesignBlockModel'    => [
                    'marginTop' => 0
                ],
                'descriptionDesignTextModel'     => [
                    'size' => 0
                ],
                'paginationDesignBlockModel'     => [
                    'marginTop' => 0
                ],
                'paginationItemDesignBlockModel' => [
                    'marginTop' => 0
                ],
                'paginationItemDesignTextModel'  => [
                    'size' => 0
                ],
            ],
            [
                'containerDesignBlockModel'      => '',
                'titleDesignBlockModel'          => '',
                'titleDesignTextModel'           => '',
                'descriptionDesignBlockModel'    => '',
                'descriptionDesignTextModel'     => '',
                'paginationDesignBlockModel'     => '',
                'paginationItemDesignBlockModel' => '',
                'paginationItemDesignTextModel'  => '',
            ],
            [
                'containerDesignBlockModel'      => [
                    'marginTop' => 0
                ],
                'titleDesignBlockModel'          => [
                    'marginTop' => 0
                ],
                'titleDesignTextModel'           => [
                    'size' => 0
                ],
                'descriptionDesignBlockModel'    => [
                    'marginTop' => 0
                ],
                'descriptionDesignTextModel'     => [
                    'size' => 0
                ],
                'paginationDesignBlockModel'     => [
                    'marginTop' => 0
                ],
                'paginationItemDesignBlockModel' => [
                    'marginTop' => 0
                ],
                'paginationItemDesignTextModel'  => [
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
                'containerDesignBlockModel'      => null,
                'titleDesignBlockModel'          => null,
                'titleDesignTextModel'           => null,
                'descriptionDesignBlockModel'    => null,
                'descriptionDesignTextModel'     => null,
                'paginationDesignBlockModel'     => null,
                'paginationItemDesignBlockModel' => null,
                'paginationItemDesignTextModel'  => null,
            ],
            [
                'containerDesignBlockModel'      => [
                    'marginTop' => 0
                ],
                'titleDesignBlockModel'          => [
                    'marginTop' => 0
                ],
                'titleDesignTextModel'           => [
                    'size' => 0
                ],
                'descriptionDesignBlockModel'    => [
                    'marginTop' => 0
                ],
                'descriptionDesignTextModel'     => [
                    'size' => 0
                ],
                'paginationDesignBlockModel'     => [
                    'marginTop' => 0
                ],
                'paginationItemDesignBlockModel' => [
                    'marginTop' => 0
                ],
                'paginationItemDesignTextModel'  => [
                    'size' => 0
                ],
            ],
            [
                'containerDesignBlockModel'      => ' ',
                'titleDesignBlockModel'          => ' ',
                'titleDesignTextModel'           => ' ',
                'descriptionDesignBlockModel'    => ' ',
                'descriptionDesignTextModel'     => ' ',
                'paginationDesignBlockModel'     => ' ',
                'paginationItemDesignBlockModel' => ' ',
                'paginationItemDesignTextModel'  => ' ',
            ],
            [
                'containerDesignBlockModel'      => [
                    'marginTop' => 0
                ],
                'titleDesignBlockModel'          => [
                    'marginTop' => 0
                ],
                'titleDesignTextModel'           => [
                    'size' => 0
                ],
                'descriptionDesignBlockModel'    => [
                    'marginTop' => 0
                ],
                'descriptionDesignTextModel'     => [
                    'size' => 0
                ],
                'paginationDesignBlockModel'     => [
                    'marginTop' => 0
                ],
                'paginationItemDesignBlockModel' => [
                    'marginTop' => 0
                ],
                'paginationItemDesignTextModel'  => [
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
                'containerDesignBlockId'      => ' ',
                'titleDesignBlockId'          => ' ',
                'titleDesignTextId'           => ' ',
                'descriptionDesignBlockId'    => ' ',
                'descriptionDesignTextId'     => ' ',
                'paginationDesignBlockId'     => ' ',
                'paginationItemDesignBlockId' => ' ',
                'paginationItemDesignTextId'  => ' ',
            ],
            [
                'containerDesignBlockModel'      => [
                    'marginTop' => 0
                ],
                'titleDesignBlockModel'          => [
                    'marginTop' => 0
                ],
                'titleDesignTextModel'           => [
                    'size' => 0
                ],
                'descriptionDesignBlockModel'    => [
                    'marginTop' => 0
                ],
                'descriptionDesignTextModel'     => [
                    'size' => 0
                ],
                'paginationDesignBlockModel'     => [
                    'marginTop' => 0
                ],
                'paginationItemDesignBlockModel' => [
                    'marginTop' => 0
                ],
                'paginationItemDesignTextModel'  => [
                    'size' => 0
                ],
            ],
            [
                'containerDesignBlockId'      => null,
                'titleDesignBlockId'          => null,
                'titleDesignTextId'           => null,
                'descriptionDesignBlockId'    => null,
                'descriptionDesignTextId'     => null,
                'paginationDesignBlockId'     => null,
                'paginationItemDesignBlockId' => null,
                'paginationItemDesignTextId'  => null,
            ],
            [
                'containerDesignBlockModel'      => [
                    'marginTop' => 0
                ],
                'titleDesignBlockModel'          => [
                    'marginTop' => 0
                ],
                'titleDesignTextModel'           => [
                    'size' => 0
                ],
                'descriptionDesignBlockModel'    => [
                    'marginTop' => 0
                ],
                'descriptionDesignTextModel'     => [
                    'size' => 0
                ],
                'paginationDesignBlockModel'     => [
                    'marginTop' => 0
                ],
                'paginationItemDesignBlockModel' => [
                    'marginTop' => 0
                ],
                'paginationItemDesignTextModel'  => [
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
                'containerDesignBlockModel'      => [
                    'marginTop' => ' '
                ],
                'titleDesignBlockModel'          => [
                    'marginTop' => ' '
                ],
                'titleDesignTextModel'           => [
                    'size' => ' '
                ],
                'descriptionDesignBlockModel'    => [
                    'marginTop' => ' '
                ],
                'descriptionDesignTextModel'     => [
                    'size' => ' '
                ],
                'paginationDesignBlockModel'     => [
                    'marginTop' => ' '
                ],
                'paginationItemDesignBlockModel' => [
                    'marginTop' => ' '
                ],
                'paginationItemDesignTextModel'  => [
                    'size' => ' '
                ],
            ],
            [
                'containerDesignBlockModel'      => [
                    'marginTop' => 0
                ],
                'titleDesignBlockModel'          => [
                    'marginTop' => 0
                ],
                'titleDesignTextModel'           => [
                    'size' => 0
                ],
                'descriptionDesignBlockModel'    => [
                    'marginTop' => 0
                ],
                'descriptionDesignTextModel'     => [
                    'size' => 0
                ],
                'paginationDesignBlockModel'     => [
                    'marginTop' => 0
                ],
                'paginationItemDesignBlockModel' => [
                    'marginTop' => 0
                ],
                'paginationItemDesignTextModel'  => [
                    'size' => 0
                ],
            ],
            [
                'containerDesignBlockModel'      => [],
                'titleDesignBlockModel'          => [],
                'titleDesignTextModel'           => [],
                'descriptionDesignBlockModel'    => [],
                'descriptionDesignTextModel'     => [],
                'paginationDesignBlockModel'     => [],
                'paginationItemDesignBlockModel' => [],
                'paginationItemDesignTextModel'  => [],
            ],
            [
                'containerDesignBlockModel'      => [
                    'marginTop' => 0
                ],
                'titleDesignBlockModel'          => [
                    'marginTop' => 0
                ],
                'titleDesignTextModel'           => [
                    'size' => 0
                ],
                'descriptionDesignBlockModel'    => [
                    'marginTop' => 0
                ],
                'descriptionDesignTextModel'     => [
                    'size' => 0
                ],
                'paginationDesignBlockModel'     => [
                    'marginTop' => 0
                ],
                'paginationItemDesignBlockModel' => [
                    'marginTop' => 0
                ],
                'paginationItemDesignTextModel'  => [
                    'size' => 0
                ],
            ],
        ];
    }
}
