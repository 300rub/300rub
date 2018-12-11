<?php

namespace ss\tests\phpunit\models\blocks\record\_base\AbstractRecordModel;

use ss\models\blocks\record\RecordModel;
use ss\tests\phpunit\models\_abstract\_base\AbstractCorrectModelTest;

/**
 * Tests for the model AbstractRecordModel
 */
class AbstractRecordModelCorrectTest extends AbstractCorrectModelTest
{

    /**
     * Gets model name
     *
     * @return RecordModel
     */
    protected function getNewModel()
    {
        return new RecordModel();
    }

    /**
     * Data provider for CRUD. Correct values
     *
     * @return array
     */
    protected function getDataProviderCorrect()
    {
        return [
            'correct1' => [
                $this->_createData(),
                $this->_createExpectedData(),
                $this->_updateData(),
                $this->_updateExpectedData(),
                null,
                null,
                [
                    'designBlockModel',
                    'designImageSliderModel',
                    'designImageZoomModel',
                    'designImageSimpleModel',
                ]
            ]
        ];
    }

    /**
     * Data provider for CRUD. Correct values
     *
     * @return array
     */
    private function _coverImageModelCreateData()
    {
        return [
            'designBlockModel'       => [
                'marginTop' => 10,
            ],
            'designImageSliderModel' => [
                'bulletDesignBlockModel' => [
                    'marginTop' => 10
                ],
                'hasAutoPlay'            => true,
                'playSpeed'              => 1,
            ],
            'designImageZoomModel'   => [
                'designBlockModel' => [
                    'marginTop' => 10
                ],
                'effect'           => 0,
            ],
            'designImageSimpleModel' => [
                'containerDesignBlockModel' => [
                    'marginTop' => 10
                ],
                'imageDesignBlockModel'     => [
                    'marginTop' => 10
                ],
                'alignment'                 => 1
            ],
            'type'                   => 1,
            'viewAutoCropType'       => 1,
            'viewCropX'              => 1,
            'viewCropY'              => 1,
            'thumbAutoCropType'      => 1,
            'thumbCropX'             => 1,
            'thumbCropY'             => 1,
            'useAlbums'              => true,
        ];
    }

    /**
     * Data provider for CRUD. Correct values
     *
     * @return array
     */
    private function _imagesImageModelCreateData()
    {
        return [
            'designBlockModel'       => [
                'marginTop' => 10,
            ],
            'designImageSliderModel' => [
                'bulletDesignBlockModel' => [
                    'marginTop' => 10
                ],
                'hasAutoPlay'            => true,
                'playSpeed'              => 1,
            ],
            'designImageZoomModel'   => [
                'designBlockModel' => [
                    'marginTop' => 10
                ],
                'effect'           => 0,
            ],
            'designImageSimpleModel' => [
                'containerDesignBlockModel' => [
                    'marginTop' => 1
                ],
                'imageDesignBlockModel'     => [
                    'marginTop' => 1
                ],
                'alignment'                 => 1
            ],
            'type'                   => 1,
            'viewAutoCropType'       => 1,
            'viewCropX'              => 1,
            'viewCropY'              => 1,
            'thumbAutoCropType'      => 1,
            'thumbCropX'             => 1,
            'thumbCropY'             => 1,
            'useAlbums'              => true,
        ];
    }

    /**
     * Data provider for CRUD. Correct values
     *
     * @return array
     */
    private function _designRecordModelCreateData()
    {
        return [
            'shortCardContainerDesignBlockModel'      => [
                'marginTop' => 10
            ],
            'shortCardInstanceDesignBlockModel'       => [
                'marginTop' => 10
            ],
            'shortCardTitleDesignBlockModel'          => [
                'marginTop' => 10
            ],
            'shortCardTitleDesignTextModel'           => [
                'size' => 10
            ],
            'shortCardDateDesignTextModel'            => [
                'size' => 10
            ],
            'shortCardDescriptionDesignBlockModel'    => [
                'marginTop' => 10
            ],
            'shortCardDescriptionDesignTextModel'     => [
                'size' => 10
            ],
            'shortCardPaginationDesignBlockModel'     => [
                'marginTop' => 10
            ],
            'shortCardPaginationItemDesignBlockModel' => [
                'marginTop' => 10
            ],
            'shortCardPaginationItemDesignTextModel'  => [
                'size' => 10
            ],
            'fullCardTitleDesignBlockModel'           => [
                'marginTop' => 10
            ],
            'fullCardTitleDesignTextModel'            => [
                'size' => 10
            ],
            'fullCardDateDesignTextModel'             => [
                'size' => 10
            ],
            'shortCardViewType'                       => 1,
        ];
    }

    /**
     * Data provider for CRUD. Correct values
     *
     * @return array
     */
    private function _coverImageModelUpdateData()
    {
        return [
            'designBlockModel'       => [
                'marginTop' => 30,
            ],
            'designImageSliderModel' => [
                'bulletDesignBlockModel' => [
                    'marginTop' => 30
                ],
                'hasAutoPlay'            => false,
                'playSpeed'              => 0,
            ],
            'designImageZoomModel'   => [
                'designBlockModel' => [
                    'marginTop' => 30
                ],
                'effect'           => 0,
            ],
            'designImageSimpleModel' => [
                'containerDesignBlockModel' => [
                    'marginTop' => 30
                ],
                'imageDesignBlockModel'     => [
                    'marginTop' => 30
                ],
                'alignment'                 => 0
            ],
            'type'                   => 0,
            'viewAutoCropType'       => 0,
            'viewCropX'              => 0,
            'viewCropY'              => 0,
            'thumbAutoCropType'      => 0,
            'thumbCropX'             => 0,
            'thumbCropY'             => 0,
            'useAlbums'              => false,
        ];
    }

    /**
     * Data provider for CRUD. Correct values
     *
     * @return array
     */
    private function _imagesImageModelUpdateData()
    {
        return [
            'designBlockModel'       => [
                'marginTop' => 30,
            ],
            'designImageSliderModel' => [
                'bulletDesignBlockModel' => [
                    'marginTop' => 30
                ],
                'hasAutoPlay'            => false,
                'playSpeed'              => 0,
            ],
            'designImageZoomModel'   => [
                'designBlockModel' => [
                    'marginTop' => 30
                ],
                'effect'           => 0,
            ],
            'designImageSimpleModel' => [
                'containerDesignBlockModel' => [
                    'marginTop' => 30
                ],
                'imageDesignBlockModel'     => [
                    'marginTop' => 30
                ],
                'alignment'                 => 0
            ],
            'type'                   => 0,
            'viewAutoCropType'       => 0,
            'viewCropX'              => 0,
            'viewCropY'              => 0,
            'thumbAutoCropType'      => 0,
            'thumbCropX'             => 0,
            'thumbCropY'             => 0,
            'useAlbums'              => false,
        ];
    }

    /**
     * Data provider for CRUD. Correct values
     *
     * @return array
     */
    private function _designRecordModelUpdateData()
    {
        return [
            'shortCardContainerDesignBlockModel'      => [
                'marginTop' => 30
            ],
            'shortCardInstanceDesignBlockModel'       => [
                'marginTop' => 30
            ],
            'shortCardTitleDesignBlockModel'          => [
                'marginTop' => 30
            ],
            'shortCardTitleDesignTextModel'           => [
                'size' => 30
            ],
            'shortCardDateDesignTextModel'            => [
                'size' => 30
            ],
            'shortCardDescriptionDesignBlockModel'    => [
                'marginTop' => 30
            ],
            'shortCardDescriptionDesignTextModel'     => [
                'size' => 30
            ],
            'shortCardPaginationDesignBlockModel'     => [
                'marginTop' => 30
            ],
            'shortCardPaginationItemDesignBlockModel' => [
                'marginTop' => 30
            ],
            'shortCardPaginationItemDesignTextModel'  => [
                'size' => 30
            ],
            'fullCardTitleDesignBlockModel'           => [
                'marginTop' => 30
            ],
            'fullCardTitleDesignTextModel'            => [
                'size' => 30
            ],
            'fullCardDateDesignTextModel'             => [
                'size' => 30
            ],
            'shortCardViewType'                       => 0,
        ];
    }

    /**
     * Data provider for CRUD. Correct values
     *
     * @return array
     */
    private function _createData()
    {
        return [
            'coverImageModel'     => $this->_coverImageModelCreateData(),
            'imagesImageModel'    => $this->_imagesImageModelCreateData(),
            'descriptionTextModel' => [
                'designTextModel'  => [
                    'size' => 10
                ],
                'designBlockModel' => [
                    'marginTop' => 10
                ],
                'type'             => 1,
                'hasEditor'        => true
            ],
            'textTextModel'        => [
                'designTextModel'  => [
                    'size' => 10
                ],
                'designBlockModel' => [
                    'marginTop' => 10
                ],
                'type'             => 1,
                'hasEditor'        => true
            ],
            'designRecordModel'   => $this->_designRecordModelCreateData(),
            'hasCover'             => true,
            'hasImages'            => true,
            'hasCoverZoom'         => true,
            'hasDescription'       => true,
            'useAutoload'          => true,
            'shortCardDateType'    => 1,
            'fullCardDateType'     => 1,
        ];
    }

    /**
     * Data provider for CRUD. Correct values
     *
     * @return array
     */
    private function _createExpectedData()
    {
        return [
            'hasCover'             => true,
            'hasImages'            => true,
            'hasCoverZoom'         => true,
            'hasDescription'       => true,
            'useAutoload'          => true,
            'shortCardDateType'    => 1,
            'fullCardDateType'     => 1,
        ];
    }

    /**
     * Data provider for CRUD. Correct values
     *
     * @return array
     */
    private function _updateData()
    {
        return [
            'coverImageModel'     => $this->_coverImageModelUpdateData(),
            'imagesImageModel'    => $this->_imagesImageModelUpdateData(),
            'descriptionTextModel' => [
                'designTextModel'  => [
                    'size' => 30
                ],
                'designBlockModel' => [
                    'marginTop' => 30
                ],
                'type'             => 0,
                'hasEditor'        => false
            ],
            'textTextModel'        => [
                'designTextModel'  => [
                    'size' => 30
                ],
                'designBlockModel' => [
                    'marginTop' => 30
                ],
                'type'             => 0,
                'hasEditor'        => false
            ],
            'designRecordModel'   => $this->_designRecordModelUpdateData(),
            'hasCover'             => false,
            'hasImages'            => false,
            'hasCoverZoom'         => false,
            'hasDescription'       => false,
            'useAutoload'          => false,
            'shortCardDateType'    => 0,
            'fullCardDateType'     => 0,
        ];
    }

    /**
     * Data provider for CRUD. Correct values
     *
     * @return array
     */
    private function _updateExpectedData()
    {
        return [
            'hasCover'             => false,
            'hasImages'            => false,
            'hasCoverZoom'         => false,
            'hasDescription'       => false,
            'useAutoload'          => false,
            'shortCardDateType'    => 0,
            'fullCardDateType'     => 0,
        ];
    }
}
