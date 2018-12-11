<?php

namespace ss\tests\phpunit\models\blocks\image\_base\AbstractImageModel;

use ss\models\blocks\image\ImageModel;
use ss\tests\phpunit\models\_abstract\_base\AbstractEmptyModelTest;

/**
 * Tests for the model AbstractImageModel
 */
class AbstractImageModelEmptyTest extends AbstractEmptyModelTest
{

    /**
     * Gets model name
     *
     * @return ImageModel
     */
    protected function getNewModel()
    {
        return new ImageModel();
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
                'designBlockModel'       => [
                    'marginTop' => 0,
                ],
                'designImageSliderModel' => [
                    'bulletDesignBlockModel' => [
                        'marginTop' => 0
                    ],
                    'hasAutoPlay'            => false,
                    'playSpeed'              => 0,
                ],
                'designImageZoomModel'   => [
                    'designBlockModel' => [
                        'marginTop' => 0
                    ],
                    'effect'           => 0,
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
                'viewAutoCropType'       => 0,
                'viewCropX'              => 0,
                'viewCropY'              => 0,
                'thumbAutoCropType'      => 0,
                'thumbCropX'             => 0,
                'thumbCropY'             => 0,
                'useAlbums'              => false,
            ]
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
                'designBlockModel'       => '',
                'designImageSliderModel' => '',
                'designImageZoomModel'   => '',
                'designImageSimpleModel' => '',
                'type'                   => '',
                'viewAutoCropType'       => '',
                'viewCropX'              => '',
                'viewCropY'              => '',
                'thumbAutoCropType'      => '',
                'thumbCropX'             => '',
                'thumbCropY'             => '',
                'useAlbums'              => '',
            ],
            [
                'designBlockModel'       => [
                    'marginTop' => 0,
                ],
                'designImageSliderModel' => [
                    'bulletDesignBlockModel' => [
                        'marginTop' => 0
                    ],
                    'hasAutoPlay'            => false,
                    'playSpeed'              => 0,
                ],
                'designImageZoomModel'   => [
                    'designBlockModel' => [
                        'marginTop' => 0
                    ],
                    'effect'           => 0,
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
                'viewAutoCropType'       => 0,
                'viewCropX'              => 0,
                'viewCropY'              => 0,
                'thumbAutoCropType'      => 0,
                'thumbCropX'             => 0,
                'thumbCropY'             => 0,
                'useAlbums'              => false,
            ]
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
                'designBlockModel'       => [
                    'marginTop' => '',
                ],
                'designImageSliderModel' => [
                    'bulletDesignBlockModel' => [
                        'marginTop' => ''
                    ],
                ],
                'designImageZoomModel'   => [
                    'designBlockModel' => [
                        'marginTop' => ''
                    ],
                ],
                'designImageSimpleModel' => [
                    'containerDesignBlockModel' => [
                        'marginTop' => ''
                    ],
                    'alignment'                 => ''
                ],
            ],
            [
                'designBlockModel'       => [
                    'marginTop' => 0,
                ],
                'designImageSliderModel' => [
                    'bulletDesignBlockModel' => [
                        'marginTop' => 0
                    ],
                    'hasAutoPlay'            => false,
                    'playSpeed'              => 0,
                ],
                'designImageZoomModel'   => [
                    'designBlockModel' => [
                        'marginTop' => 0
                    ],
                    'effect'           => 0,
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
                'viewAutoCropType'       => 0,
                'viewCropX'              => 0,
                'viewCropY'              => 0,
                'thumbAutoCropType'      => 0,
                'thumbCropX'             => 0,
                'thumbCropY'             => 0,
                'useAlbums'              => false,
            ]
        ];
    }
}
