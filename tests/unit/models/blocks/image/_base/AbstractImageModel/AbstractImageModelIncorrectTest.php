<?php

namespace testS\tests\unit\models\blocks\image\_base\AbstractImageModel;

use testS\models\blocks\image\ImageModel;
use testS\tests\unit\models\_abstract\_base\AbstractIncorrectModelTest;

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
                'autoCropType'           => 'incorrect',
                'cropWidth'              => 'incorrect',
                'cropHeight'             => 'incorrect',
                'cropX'                  => 'incorrect',
                'cropY'                  => 'incorrect',
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
                    'containerDesignBlockModel'   => [
                        'marginTop' => 0
                    ],
                ],
                'designImageZoomModel'   => [
                    'designBlockModel'     => [
                        'marginTop' => 0
                    ],
                ],
                'designImageSimpleModel' => [
                    'containerDesignBlockModel' => [
                        'marginTop' => 0
                    ],
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
            ],
            [
                'designBlockModel'       => [
                    'marginTop' => ' 20 a',
                ],
                'designImageSliderModel' => [
                    'containerDesignBlockModel'   => [
                        'marginTop' => ' 20 a',
                    ],
                ],
                'designImageZoomModel'   => [
                    'designBlockModel'     => [
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
                    'containerDesignBlockModel'   => [
                        'marginTop' => 20
                    ],
                ],
                'designImageZoomModel'   => [
                    'designBlockModel'     => [
                        'marginTop' => 20
                    ],
                ],
                'designImageSimpleModel' => [
                    'containerDesignBlockModel' => [
                        'marginTop' => 20
                    ],
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
                'type'                   => ' 1 a ',
                'autoCropType'           => ' 1 a ',
                'cropWidth'              => ' 1 a ',
                'cropHeight'             => ' 1 a ',
                'cropX'                  => ' 1 a ',
                'cropY'                  => ' 1 a ',
                'thumbAutoCropType'      => ' 1 a ',
                'thumbCropX'             => ' 1 a ',
                'thumbCropY'             => ' 1 a ',
                'useAlbums'              => ' 1 a ',
            ],
            [
                'type'                   => 1,
                'autoCropType'           => 1,
                'cropWidth'              => 1,
                'cropHeight'             => 1,
                'cropX'                  => 1,
                'cropY'                  => 1,
                'thumbAutoCropType'      => 1,
                'thumbCropX'             => 1,
                'thumbCropY'             => 1,
                'useAlbums'              => false,
            ],
            [
                'type'                   => 999,
                'autoCropType'           => 999,
                'cropWidth'              => 999,
                'cropHeight'             => 999,
                'cropX'                  => 999,
                'cropY'                  => 999,
                'thumbAutoCropType'      => 999,
                'thumbCropX'             => 999,
                'thumbCropY'             => 999,
                'useAlbums'              => 1,
            ],
            [
                'type'                   => 0,
                'autoCropType'           => 0,
                'cropWidth'              => 999,
                'cropHeight'             => 999,
                'cropX'                  => 999,
                'cropY'                  => 999,
                'thumbAutoCropType'      => 0,
                'thumbCropX'             => 999,
                'thumbCropY'             => 999,
                'useAlbums'              => true,
            ]
        ];
    }
}
