<?php

namespace ss\tests\unit\models\blocks\image\_base\AbstractImageModel;

use ss\models\blocks\image\ImageModel;
use ss\tests\unit\models\_abstract\_base\AbstractDuplicateModelTest;

/**
 * Tests for the model AbstractImageModel
 */
class AbstractImageModelDuplicateTest extends AbstractDuplicateModelTest
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
     * Data provider for CRUD. Duplicate
     *
     * @return void
     */
    public function testDuplicate()
    {
        $this->duplicate(
            $this->_createData(),
            $this->_createExpectedData()
        );
    }

    /**
     * Data provider for CRUD. Duplicate
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
            'cropWidth'              => 10,
            'cropHeight'             => 20,
            'cropX'                  => 30,
            'cropY'                  => 40,
            'thumbAutoCropType'      => 1,
            'thumbCropX'             => 20,
            'thumbCropY'             => 30,
            'useAlbums'              => true,
        ];
    }

    /**
     * Data provider for CRUD. Duplicate
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
            'cropWidth'              => 10,
            'cropHeight'             => 20,
            'cropX'                  => 30,
            'cropY'                  => 40,
            'thumbAutoCropType'      => 1,
            'thumbCropX'             => 20,
            'thumbCropY'             => 30,
            'useAlbums'              => true,
        ];
    }
}
