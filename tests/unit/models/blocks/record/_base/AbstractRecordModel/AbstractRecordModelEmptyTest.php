<?php

namespace ss\tests\unit\models\blocks\record\_base\AbstractRecordModel;

use ss\models\blocks\record\RecordModel;
use ss\tests\unit\models\_abstract\_base\AbstractEmptyModelTest;

/**
 * Tests for the model AbstractRecordModel
 */
class AbstractRecordModelEmptyTest extends AbstractEmptyModelTest
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
     * Data provider for CRUD. Empty values
     *
     * @return array
     */
    protected function getDataProviderEmpty()
    {
        return [
            'empty1' => [
                [],
                [
                    'coverImageModel'     => $this->_coverImageModelData(),
                    'imagesImageModel'    => $this->_imagesImageModelData(),
                    'descriptionTextModel' => [
                        'designTextModel'  => [
                            'size' => 0
                        ],
                        'designBlockModel' => [
                            'marginTop' => 0
                        ],
                        'type'             => 0,
                        'hasEditor'        => false
                    ],
                    'textTextModel'        => [
                        'designTextModel'  => [
                            'size' => 0
                        ],
                        'designBlockModel' => [
                            'marginTop' => 0
                        ],
                        'type'             => 0,
                        'hasEditor'        => false
                    ],
                    'designRecordsModel'   => $this->_designRecordsModelData(),
                    'hasCover'             => false,
                    'hasImages'            => false,
                    'hasCoverZoom'         => false,
                    'hasDescription'       => false,
                    'useAutoload'          => false,
                    'shortCardDateType'    => 0,
                    'fullCardDateType'     => 0,
                ]
            ],
        ];
    }

    /**
     * Data provider for CRUD. Empty values
     *
     * @return array
     */
    private function _coverImageModelData()
    {
        return [
            'designBlockModel'       => [
                'marginTop' => 0,
            ],
            'designImageSliderModel' => [
                'containerDesignBlockModel'   => [
                    'marginTop' => 0
                ],
                'navigationDesignBlockModel'  => [
                    'marginTop' => 0
                ],
                'descriptionDesignBlockModel' => [
                    'marginTop' => 0
                ],
                'hasAutoPlay'                 => false,
                'playSpeed'                   => 0,
                'navigationAlignment'         => 0,
                'descriptionAlignment'        => 0,
            ],
            'designImageZoomModel'   => [
                'designBlockModel'     => [
                    'marginTop' => 0
                ],
                'effect'               => 0,
            ],
            'designImageSimpleModel' => [
                'containerDesignBlockModel' => [
                    'marginTop' => 0
                ],
                'imageDesignBlockModel'     => [
                    'marginTop' => 0
                ],
                'alignment'                 => 0
            ],
            'type'                   => 0,
            'autoCropType'           => 0,
            'cropWidth'              => 0,
            'cropHeight'             => 0,
            'cropX'                  => 0,
            'cropY'                  => 0,
            'thumbAutoCropType'      => 0,
            'thumbCropX'             => 0,
            'thumbCropY'             => 0,
            'useAlbums'              => false,
        ];
    }

    /**
     * Data provider for CRUD. Empty values
     *
     * @return array
     */
    private function _imagesImageModelData()
    {
        return [
            'designBlockModel'       => [
                'marginTop' => 0,
            ],
            'designImageSliderModel' => [
                'containerDesignBlockModel'   => [
                    'marginTop' => 0
                ],
                'navigationDesignBlockModel'  => [
                    'marginTop' => 0
                ],
                'descriptionDesignBlockModel' => [
                    'marginTop' => 0
                ],
                'hasAutoPlay'                 => false,
                'playSpeed'                   => 0,
                'navigationAlignment'         => 0,
                'descriptionAlignment'        => 0,
            ],
            'designImageZoomModel'   => [
                'designBlockModel'     => [
                    'marginTop' => 0
                ],
                'effect'               => 0,
            ],
            'designImageSimpleModel' => [
                'containerDesignBlockModel' => [
                    'marginTop' => 0
                ],
                'imageDesignBlockModel'     => [
                    'marginTop' => 0
                ],
                'alignment'                 => 0
            ],
            'type'                   => 0,
            'autoCropType'           => 0,
            'cropWidth'              => 0,
            'cropHeight'             => 0,
            'cropX'                  => 0,
            'cropY'                  => 0,
            'thumbAutoCropType'      => 0,
            'thumbCropX'             => 0,
            'thumbCropY'             => 0,
            'useAlbums'              => false,
        ];
    }

    /**
     * Data provider for CRUD. Empty values
     *
     * @return array
     */
    private function _designRecordsModelData()
    {
        return [
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
        ];
    }
}
