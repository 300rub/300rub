<?php

namespace ss\tests\phpunit\models\blocks\record\_base\AbstractRecordModel;

use ss\models\blocks\record\RecordModel;
use ss\tests\phpunit\models\_abstract\_base\AbstractDuplicateModelTest;

/**
 * Tests for the model AbstractRecordModel
 */
class AbstractRecordModelDuplicateTest extends AbstractDuplicateModelTest
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
     * Data provider for CRUD. Duplicate
     *
     * @return void
     */
    public function testDuplicate()
    {
        $this->duplicate(
            [
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
                'designRecordModel'
                    => $this->_designRecordModelCreateData(),
                'hasCover'             => true,
                'hasImages'            => true,
                'hasCoverZoom'         => true,
                'hasDescription'       => true,
                'useAutoload'          => true,
                'shortCardDateType'    => 1,
                'fullCardDateType'     => 1,
            ],
            [
                'hasCover'             => true,
                'hasImages'            => true,
                'hasCoverZoom'         => true,
                'hasDescription'       => true,
                'useAutoload'          => true,
                'shortCardDateType'    => 1,
                'fullCardDateType'     => 1,
            ],
            null,
            [
                'designBlockModel',
                'designImageSliderModel',
                'designImageZoomModel',
                'designImageSimpleModel',
            ]
        );
    }

    /**
     * Data provider for CRUD. Duplicate
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
     * Data provider for CRUD. Duplicate
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
     * Data provider for CRUD. Duplicate
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
}
