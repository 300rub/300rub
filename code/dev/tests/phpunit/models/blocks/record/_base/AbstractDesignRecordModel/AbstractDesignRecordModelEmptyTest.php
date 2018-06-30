<?php

namespace ss\tests\unit\models\blocks\record\_base\AbstractDesignRecordModel;

use ss\models\blocks\record\DesignRecordModel;
use ss\tests\unit\models\_abstract\_base\AbstractEmptyModelTest;

/**
 * Tests for the model AbstractDesignRecordModel
 */
class AbstractDesignRecordModelEmptyTest extends AbstractEmptyModelTest
{

    /**
     * Gets model name
     *
     * @return DesignRecordModel
     */
    protected function getNewModel()
    {
        return new DesignRecordModel();
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
                'shortCardContainerDesignBlockModel'      => [
                    'marginTop' => 0
                ],
                'shortCardInstanceDesignBlockModel'       => [
                    'marginTop' => 0
                ],
                'shortCardTitleDesignBlockModel'          => [
                    'marginTop' => 0
                ],
                'shortCardTitleDesignTextModel'           => [
                    'size' => 0
                ],
                'shortCardDateDesignTextModel'            => [
                    'size' => 0
                ],
                'shortCardDescriptionDesignBlockModel'    => [
                    'marginTop' => 0
                ],
                'shortCardDescriptionDesignTextModel'     => [
                    'size' => 0
                ],
                'shortCardPaginationDesignBlockModel'     => [
                    'marginTop' => 0
                ],
                'shortCardPaginationItemDesignBlockModel' => [
                    'marginTop' => 0
                ],
                'shortCardPaginationItemDesignTextModel'  => [
                    'size' => 0
                ],
                'fullCardTitleDesignBlockModel'           => [
                    'marginTop' => 0
                ],
                'fullCardTitleDesignTextModel'            => [
                    'size' => 0
                ],
                'fullCardDateDesignTextModel'             => [
                    'size' => 0
                ],
                'shortCardViewType'                       => 0,
            ],
            [
                'shortCardPaginationDesignBlockModel'     => '',
                'shortCardPaginationItemDesignBlockModel' => '',
                'shortCardPaginationItemDesignTextModel'  => '',
                'fullCardTitleDesignBlockModel'           => '',
                'fullCardTitleDesignTextModel'            => '',
                'fullCardDateDesignTextModel'             => '',
                'shortCardViewType'                       => '',
            ],
            [
                'shortCardContainerDesignBlockModel'      => [
                    'marginTop' => 0
                ],
                'shortCardInstanceDesignBlockModel'       => [
                    'marginTop' => 0
                ],
                'shortCardTitleDesignBlockModel'          => [
                    'marginTop' => 0
                ],
                'shortCardTitleDesignTextModel'           => [
                    'size' => 0
                ],
                'shortCardDateDesignTextModel'            => [
                    'size' => 0
                ],
                'shortCardDescriptionDesignBlockModel'    => [
                    'marginTop' => 0
                ],
                'shortCardDescriptionDesignTextModel'     => [
                    'size' => 0
                ],
                'fullCardTitleDesignBlockModel'           => [
                    'marginTop' => 0
                ],
                'fullCardTitleDesignTextModel'            => [
                    'size' => 0
                ],
                'fullCardDateDesignTextModel'             => [
                    'size' => 0
                ],
                'shortCardViewType'                       => 0,
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
                'shortCardDescriptionDesignBlockModel'    => null,
                'shortCardDescriptionDesignTextModel'     => null,
                'fullCardTitleDesignBlockModel'           => null,
                'shortCardViewType'                       => null,
            ],
            [
                'shortCardTitleDesignTextModel'           => [
                    'size' => 0
                ],
                'shortCardDateDesignTextModel'            => [
                    'size' => 0
                ],
                'shortCardDescriptionDesignBlockModel'    => [
                    'marginTop' => 0
                ],
                'shortCardDescriptionDesignTextModel'     => [
                    'size' => 0
                ],
                'shortCardPaginationDesignBlockModel'     => [
                    'marginTop' => 0
                ],
                'shortCardPaginationItemDesignBlockModel' => [
                    'marginTop' => 0
                ],
                'shortCardPaginationItemDesignTextModel'  => [
                    'size' => 0
                ],
                'fullCardTitleDesignBlockModel'           => [
                    'marginTop' => 0
                ],
                'fullCardTitleDesignTextModel'            => [
                    'size' => 0
                ],
                'fullCardDateDesignTextModel'             => [
                    'size' => 0
                ],
                'shortCardViewType'                       => 0,
            ],
            [
                'shortCardContainerDesignBlockModel'      => ' ',
                'shortCardInstanceDesignBlockModel'       => ' ',
                'shortCardTitleDesignBlockModel'          => ' ',
                'shortCardTitleDesignTextModel'           => ' ',
                'shortCardDateDesignTextModel'            => ' ',
                'fullCardTitleDesignTextModel'            => ' ',
                'fullCardDateDesignTextModel'             => ' ',
                'shortCardViewType'                       => ' ',
            ],
            [
                'shortCardContainerDesignBlockModel'      => [
                    'marginTop' => 0
                ],
                'shortCardDescriptionDesignBlockModel'    => [
                    'marginTop' => 0
                ],
                'shortCardDescriptionDesignTextModel'     => [
                    'size' => 0
                ],
                'shortCardPaginationDesignBlockModel'     => [
                    'marginTop' => 0
                ],
                'shortCardPaginationItemDesignBlockModel' => [
                    'marginTop' => 0
                ],
                'shortCardPaginationItemDesignTextModel'  => [
                    'size' => 0
                ],
                'fullCardTitleDesignBlockModel'           => [
                    'marginTop' => 0
                ],
                'fullCardTitleDesignTextModel'            => [
                    'size' => 0
                ],
                'fullCardDateDesignTextModel'             => [
                    'size' => 0
                ],
                'shortCardViewType'                       => 0,
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
                'shortCardContainerDesignBlockId'      => ' ',
                'shortCardInstanceDesignBlockId'       => ' ',
                'shortCardTitleDesignBlockId'          => ' ',
                'shortCardTitleDesignTextId'           => ' ',
                'shortCardDateDesignTextId'            => ' ',
                'shortCardDescriptionDesignBlockId'    => ' ',
                'shortCardDescriptionDesignTextId'     => ' ',
                'shortCardPaginationDesignBlockId'     => ' ',
            ],
            [
                'shortCardContainerDesignBlockModel'      => [
                    'marginTop' => 0
                ],
                'shortCardInstanceDesignBlockModel'       => [
                    'marginTop' => 0
                ],
                'shortCardTitleDesignBlockModel'          => [
                    'marginTop' => 0
                ],
                'shortCardTitleDesignTextModel'           => [
                    'size' => 0
                ],
                'shortCardDateDesignTextModel'            => [
                    'size' => 0
                ],
                'shortCardDescriptionDesignBlockModel'    => [
                    'marginTop' => 0
                ],
            ],
            [
                'shortCardPaginationItemDesignBlockId' => null,
                'shortCardPaginationItemDesignTextId'  => null,
                'fullCardTitleDesignBlockId'           => null,
                'fullCardTitleDesignTextId'            => null,
                'fullCardDateDesignTextId'             => null,
                'shortCardViewType'                    => null,
            ],
            [
                'shortCardPaginationDesignBlockModel'     => [
                    'marginTop' => 0
                ],
                'shortCardPaginationItemDesignBlockModel' => [
                    'marginTop' => 0
                ],
                'shortCardPaginationItemDesignTextModel'  => [
                    'size' => 0
                ],
                'fullCardTitleDesignBlockModel'           => [
                    'marginTop' => 0
                ],
                'fullCardTitleDesignTextModel'            => [
                    'size' => 0
                ],
                'fullCardDateDesignTextModel'             => [
                    'size' => 0
                ],
                'shortCardViewType'                       => 0,
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
                'shortCardContainerDesignBlockModel'      => [
                    'marginTop' => ' '
                ],
                'shortCardInstanceDesignBlockModel'       => [
                    'marginTop' => ' '
                ],
                'shortCardTitleDesignBlockModel'          => [
                    'marginTop' => ' '
                ],
                'shortCardTitleDesignTextModel'           => [
                    'size' => ' '
                ],
                'shortCardDateDesignTextModel'            => [
                    'size' => ' '
                ],
                'shortCardDescriptionDesignBlockModel'    => [
                    'marginTop' => ' '
                ],
            ],
            [
                'shortCardContainerDesignBlockModel'      => [
                    'marginTop' => 0
                ],
                'shortCardInstanceDesignBlockModel'       => [
                    'marginTop' => 0
                ],
                'shortCardTitleDesignBlockModel'          => [
                    'marginTop' => 0
                ],
                'shortCardTitleDesignTextModel'           => [
                    'size' => 0
                ],
                'shortCardDateDesignTextModel'            => [
                    'size' => 0
                ],
                'shortCardDescriptionDesignBlockModel'    => [
                    'marginTop' => 0
                ],
            ],
            [
                'shortCardPaginationDesignBlockModel'     => [],
                'shortCardPaginationItemDesignBlockModel' => [],
                'shortCardPaginationItemDesignTextModel'  => [],
                'fullCardTitleDesignBlockModel'           => [],
                'fullCardTitleDesignTextModel'            => [],
                'fullCardDateDesignTextModel'             => [],
            ],
            [
                'shortCardDescriptionDesignTextModel'     => [
                    'size' => 0
                ],
                'shortCardPaginationDesignBlockModel'     => [
                    'marginTop' => 0
                ],
                'shortCardPaginationItemDesignBlockModel' => [
                    'marginTop' => 0
                ],
                'shortCardPaginationItemDesignTextModel'  => [
                    'size' => 0
                ],
                'fullCardTitleDesignBlockModel'           => [
                    'marginTop' => 0
                ],
                'fullCardTitleDesignTextModel'            => [
                    'size' => 0
                ],
                'fullCardDateDesignTextModel'             => [
                    'size' => 0
                ],
                'shortCardViewType'                       => 0,
            ],
        ];
    }
}
