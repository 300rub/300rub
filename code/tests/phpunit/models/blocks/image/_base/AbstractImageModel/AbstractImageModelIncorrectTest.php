<?php

namespace ss\tests\phpunit\models\blocks\image\_base\AbstractImageModel;

use ss\models\blocks\image\ImageModel;
use ss\tests\phpunit\models\_abstract\_base\AbstractIncorrectModelTest;

/**
 * Tests for the model AbstractImageModel
 */
class AbstractImageModelIncorrectTest extends AbstractIncorrectModelTest
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
     * Data provider for CRUD. Incorrect values
     *
     * @return array
     */
    protected function getDataProviderIncorrect()
    {
        return [
            'incorrect1' => $this->_getDataProviderIncorrect1(),
            'incorrect2' => $this->_getDataProviderIncorrect2()
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
                'designBlockModel'       => 'incorrect',
                'designImageSliderModel' => 'incorrect',
                'type'                   => 'incorrect',
                'viewAutoCropType'       => 'incorrect',
                'viewCropX'              => 'incorrect',
                'viewCropY'              => 'incorrect',
                'thumbAutoCropType'      => 'incorrect',
                'thumbCropX'             => 'incorrect',
                'thumbCropY'             => 'incorrect',
                'useAlbums'              => 'incorrect',
            ],
            [
                'designBlockModel'       => [
                    'marginTop' => 0,
                ],
                'designImageSliderModel' => [
                    'bulletDesignBlockModel' => [
                        'marginTop' => 0
                    ],
                ],
                'designImageZoomModel'   => [
                    'designBlockModel' => [
                        'marginTop' => 0
                    ],
                ],
                'designImageSimpleModel' => [
                    'containerDesignBlockModel' => [
                        'marginTop' => 0
                    ],
                ],
                'type'                   => 0,
                'viewAutoCropType'       => 0,
                'viewCropX'              => 0,
                'viewCropY'              => 0,
                'thumbAutoCropType'      => 0,
                'thumbCropX'             => 0,
                'thumbCropY'             => 0,
                'useAlbums'              => false,
            ],
            [
                'designBlockModel'       => [
                    'marginTop' => ' 20 a',
                ],
                'designImageSliderModel' => [
                    'bulletDesignBlockModel' => [
                        'marginTop' => ' 20 a',
                    ],
                ],
                'designImageZoomModel'   => [
                    'designBlockModel' => [
                        'marginTop' => ' 20 a',
                    ],
                ],
                'designImageSimpleModel' => [
                    'containerDesignBlockModel' => [
                        'marginTop' => ' 20 a',
                    ],
                ],
            ],
            [
                'designBlockModel'       => [
                    'marginTop' => 20,
                ],
                'designImageSliderModel' => [
                    'bulletDesignBlockModel' => [
                        'marginTop' => 20
                    ],
                ],
                'designImageZoomModel'   => [
                    'designBlockModel' => [
                        'marginTop' => 20
                    ],
                ],
                'designImageSimpleModel' => [
                    'containerDesignBlockModel' => [
                        'marginTop' => 20
                    ],
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
     * Data provider for CRUD. Incorrect values
     *
     * @return array
     */
    private function _getDataProviderIncorrect2()
    {
        return [
            [
                'type'              => ' 1 a ',
                'viewAutoCropType'  => ' 1 a ',
                'viewCropX'         => ' 1 a ',
                'viewCropY'         => ' 1 a ',
                'thumbAutoCropType' => ' 1 a ',
                'thumbCropX'        => ' 1 a ',
                'thumbCropY'        => ' 1 a ',
                'useAlbums'         => ' 1 a ',
            ],
            [
                'type'              => 1,
                'viewAutoCropType'  => 1,
                'viewCropX'         => 1,
                'viewCropY'         => 1,
                'thumbAutoCropType' => 1,
                'thumbCropX'        => 1,
                'thumbCropY'        => 1,
                'useAlbums'         => false,
            ],
            [
                'type'              => 999,
                'viewAutoCropType'  => 999,
                'viewCropX'         => 999,
                'viewCropY'         => 999,
                'thumbAutoCropType' => 999,
                'thumbCropX'        => 999,
                'thumbCropY'        => 999,
                'useAlbums'         => 1,
            ],
            [
                'type'              => 0,
                'viewAutoCropType'  => 0,
                'viewCropX'         => 999,
                'viewCropY'         => 999,
                'thumbAutoCropType' => 0,
                'thumbCropX'        => 999,
                'thumbCropY'        => 999,
                'useAlbums'         => true,
            ]
        ];
    }
}
