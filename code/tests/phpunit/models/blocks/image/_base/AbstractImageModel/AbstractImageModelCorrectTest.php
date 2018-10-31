<?php

namespace ss\tests\phpunit\models\blocks\image\_base\AbstractImageModel;

use ss\models\blocks\image\ImageModel;
use ss\tests\phpunit\models\_abstract\_base\AbstractCorrectModelTest;

/**
 * Tests for the model AbstractImageModel
 */
class AbstractImageModelCorrectTest extends AbstractCorrectModelTest
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
     * Data provider for CRUD. Correct values
     *
     * @return array
     */
    protected function getDataProviderCorrect()
    {
        return [
            'correct1' => [
                $this->_createData(),
                $this->_createExpectedData()
            ]
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
            'designBlockModel'       => [
                'marginTop' => 10,
            ],
            'designImageSliderModel' => [
                'bulletDesignBlockModel'   => [
                    'marginTop' => 10
                ],
                'hasAutoPlay'                 => true,
                'playSpeed'                   => 10,
            ],
            'designImageZoomModel'   => [
                'designBlockModel'     => [
                    'marginTop' => 20
                ],
                'effect'               => 0,
            ],
            'designImageSimpleModel' => [
                'containerDesignBlockModel' => [
                    'marginTop' => 20
                ],
                'imageDesignBlockModel'     => [
                    'marginTop' => 30
                ],
                'alignment'                 => 1
            ],
            'type'                   => 1,
            'autoCropType'           => 1,
            'cropX'                  => 30,
            'cropY'                  => 40,
            'thumbAutoCropType'      => 1,
            'thumbCropX'             => 20,
            'thumbCropY'             => 30,
            'useAlbums'              => true,
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
            'designBlockModel'       => [
                'marginTop' => 10,
            ],
            'designImageSliderModel' => [
                'bulletDesignBlockModel'   => [
                    'marginTop' => 10
                ],
                'hasAutoPlay'                 => true,
                'playSpeed'                   => 10,
            ],
            'designImageZoomModel'   => [
                'designBlockModel'     => [
                    'marginTop' => 20
                ],
                'effect'               => 0,
            ],
            'designImageSimpleModel' => [
                'containerDesignBlockModel' => [
                    'marginTop' => 20
                ],
                'imageDesignBlockModel'     => [
                    'marginTop' => 30
                ],
                'alignment'                 => 1
            ],
            'type'                   => 1,
            'autoCropType'           => 1,
            'cropX'                  => 30,
            'cropY'                  => 40,
            'thumbAutoCropType'      => 1,
            'thumbCropX'             => 20,
            'thumbCropY'             => 30,
            'useAlbums'              => true,
        ];
    }
}
