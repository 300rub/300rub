<?php

namespace testS\tests\unit\models\blocks\record\_base\AbstractDesignRecordModel;

use testS\models\blocks\record\DesignRecordModel;
use testS\tests\unit\models\_abstract\_base\AbstractIncorrectModelTest;

/**
 * Tests for the model AbstractDesignRecordModel
 */
class AbstractDesignRecordModelIncorrectTest extends AbstractIncorrectModelTest
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
     * Data provider for CRUD. Incorrect values
     *
     * @return array
     */
    protected function getDataProviderIncorrect()
    {
        return [
            'incorrect1' => $this->_getDataProviderIncorrect1(),
            'incorrect2' => $this->_getDataProviderIncorrect2(),
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
                'shortCardContainerDesignBlockModel'      => 'incorrect',
                'shortCardInstanceDesignBlockModel'       => 'incorrect',
                'shortCardTitleDesignBlockModel'          => 'incorrect',
                'shortCardTitleDesignTextModel'           => 'incorrect',
                'shortCardDateDesignTextModel'            => 'incorrect',
                'shortCardDescriptionDesignBlockModel'    => 'incorrect',
                'shortCardDescriptionDesignTextModel'     => 'incorrect',
                'shortCardPaginationDesignBlockModel'     => 'incorrect',
                'shortCardPaginationItemDesignBlockModel' => 'incorrect',
                'shortCardPaginationItemDesignTextModel'  => 'incorrect',
                'fullCardTitleDesignBlockModel'           => 'incorrect',
                'fullCardTitleDesignTextModel'            => 'incorrect',
                'fullCardDateDesignTextModel'             => 'incorrect',
                'shortCardViewType'                       => 'incorrect',
                'fullCardImagesPosition'                  => 'incorrect',
                'fullCardDatePosition'                    => 'incorrect',
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
                'fullCardImagesPosition'                  => 0,
                'fullCardDatePosition'                    => 0,
            ],
            [
                'shortCardViewType'      => 999,
                'fullCardImagesPosition' => 999,
                'fullCardDatePosition'   => 999,
            ],
            [
                'shortCardViewType'      => 0,
                'fullCardImagesPosition' => 0,
                'fullCardDatePosition'   => 0,
            ],
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
                'shortCardViewType'      => ' 1 ',
                'fullCardImagesPosition' => ' 1 ',
                'fullCardDatePosition'   => ' 1 ',
            ],
            [
                'shortCardViewType'      => 1,
                'fullCardImagesPosition' => 1,
                'fullCardDatePosition'   => 1,
            ],
            [
                'shortCardInstanceDesignBlockModel'       => [
                    'marginTop' => ' 500 '
                ],
                'shortCardTitleDesignBlockModel'          => [
                    'marginTop' => ' 500 '
                ],
                'shortCardTitleDesignTextModel'           => [
                    'size' => ' 500 '
                ],
                'shortCardDateDesignTextModel'            => [
                    'size' => ' 500 '
                ],
                'shortCardDescriptionDesignBlockModel'    => [
                    'marginTop' => ' 500 '
                ],
                'shortCardDescriptionDesignTextModel'     => [
                    'size' => ' 500 '
                ],
                'shortCardPaginationDesignBlockModel'     => [
                    'marginTop' => ' 500 '
                ],
                'shortCardPaginationItemDesignBlockModel' => [
                    'marginTop' => ' 500 '
                ],
                'shortCardPaginationItemDesignTextModel'  => [
                    'size' => ' 500 '
                ],
                'fullCardTitleDesignBlockModel'           => [
                    'marginTop' => ' 500 '
                ],
                'fullCardTitleDesignTextModel'            => [
                    'size' => ' 500 '
                ],
                'fullCardDateDesignTextModel'             => [
                    'size' => ' 500 '
                ],
                'shortCardViewType'                       => true,
                'fullCardImagesPosition'                  => false,
                'fullCardDatePosition'                    => true,
            ],
            [
                'shortCardInstanceDesignBlockModel'       => [
                    'marginTop' => 500
                ],
                'shortCardTitleDesignBlockModel'          => [
                    'marginTop' => 500
                ],
                'shortCardTitleDesignTextModel'           => [
                    'size' => 500
                ],
                'shortCardDateDesignTextModel'            => [
                    'size' => 500
                ],
                'shortCardDescriptionDesignBlockModel'    => [
                    'marginTop' => 500
                ],
                'shortCardDescriptionDesignTextModel'     => [
                    'size' => 500
                ],
                'shortCardPaginationDesignBlockModel'     => [
                    'marginTop' => 500
                ],
                'shortCardPaginationItemDesignBlockModel' => [
                    'marginTop' => 500
                ],
                'shortCardPaginationItemDesignTextModel'  => [
                    'size' => 500
                ],
                'fullCardTitleDesignBlockModel'           => [
                    'marginTop' => 500
                ],
                'fullCardTitleDesignTextModel'            => [
                    'size' => 500
                ],
                'fullCardDateDesignTextModel'             => [
                    'size' => 500
                ],
                'shortCardViewType'                       => 1,
                'fullCardImagesPosition'                  => 0,
                'fullCardDatePosition'                    => 1,
            ],
        ];
    }
}
