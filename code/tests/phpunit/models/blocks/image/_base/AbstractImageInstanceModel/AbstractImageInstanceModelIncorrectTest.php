<?php

namespace ss\tests\phpunit\models\blocks\image\_base\AbstractImageInstanceModel;

use ss\models\blocks\image\ImageInstanceModel;
use ss\tests\phpunit\models\_abstract\_base\AbstractIncorrectModelTest;

/**
 * Tests for the model AbstractImageInstanceModel
 */
class AbstractImageInstanceModelIncorrectTest extends AbstractIncorrectModelTest
{

    /**
     * Gets model name
     *
     * @return ImageInstanceModel
     */
    protected function getNewModel()
    {
        return new ImageInstanceModel();
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
            'incorrect3' => $this->_getDataProviderIncorrect3()
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
                'imageGroupId'      => 'incorrect',
                'originalFileModel' => [
                    'uniqueName' => 'incorrect',
                ],
                'viewFileModel'     => [
                    'uniqueName' => 'view_incorrect.jpg',
                ],
                'thumbFileModel'    => [
                    'uniqueName' => 'thumb_incorrect.jpg',
                ],
                'isCover'           => 'incorrect',
                'sort'              => 'incorrect',
                'alt'               => 'incorrect',
                'width'             => 'incorrect',
                'height'            => 'incorrect',
                'x1'                => 'incorrect',
                'y1'                => 'incorrect',
                'viewWidth'                => 'incorrect',
                'viewHeight'                => 'incorrect',
                'thumbX'            => 'incorrect',
                'thumbY'            => 'incorrect',
                'thumbWidth'        => 'incorrect',
                'thumbHeight'       => 'incorrect',
            ],
            [
                'originalFileModel' => [
                    'uniqueName' => 'incorrect',
                ],
                'viewFileModel'     => [
                    'uniqueName' => 'view_incorrect.jpg',
                ],
                'thumbFileModel'    => [
                    'uniqueName' => 'thumb_incorrect.jpg',
                ],
                'isCover'           => false,
                'sort'              => 0,
                'alt'               => 'incorrect',
                'width'             => 0,
                'height'            => 0,
                'x1'                => 0,
                'y1'                => 0,
                'viewWidth'                => 0,
                'viewHeight'                => 0,
                'thumbX'            => 0,
                'thumbY'            => 0,
                'thumbWidth'        => 0,
                'thumbHeight'       => 0,
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
                'imageGroupId'      => '1 ',
                'originalFileModel' => [
                    'uniqueName' => '<b> 123 </b>',
                ],
                'viewFileModel'     => [
                    'uniqueName' => '<b> view_123 </b>',
                ],
                'thumbFileModel'    => [
                    'uniqueName' => '<b> thumb_123 </b>',
                ],
                'isCover'           => 'incorrect',
                'sort'              => 'incorrect',
                'alt'               => 'incorrect',
                'width'             => 'incorrect',
                'height'            => 'incorrect',
                'x1'                => 'incorrect',
                'y1'                => 'incorrect',
                'viewWidth'                => 'incorrect',
                'viewHeight'                => 'incorrect',
                'thumbX'            => 'incorrect',
                'thumbY'            => 'incorrect',
                'thumbWidth'        => 'incorrect',
                'thumbHeight'       => 'incorrect',
            ],
            [
                'imageGroupId'      => 1,
                'originalFileModel' => [
                    'uniqueName' => '123',
                ],
                'viewFileModel'     => [
                    'uniqueName' => 'view_123',
                ],
                'thumbFileModel'    => [
                    'uniqueName' => 'thumb_123',
                ],
                'isCover'           => false,
                'sort'              => 0,
                'alt'               => 'incorrect',
                'width'             => 0,
                'height'            => 0,
                'x1'                => 0,
                'y1'                => 0,
                'viewWidth'                => 0,
                'viewHeight'                => 0,
                'thumbX'            => 0,
                'thumbY'            => 0,
                'thumbWidth'        => 0,
                'thumbHeight'       => 0,
            ],
            [
                'originalFileModel' => [
                    'uniqueName' => $this->generateStringWithLength(26),
                ],
                'viewFileModel' => [
                    'uniqueName' => $this->generateStringWithLength(26),
                ],
                'thumbFileModel' => [
                    'uniqueName' => $this->generateStringWithLength(26),
                ],
            ],
            [
                'originalFileModel' => [
                    'uniqueName' => ['maxLength']
                ],
                'viewFileModel' => [
                    'uniqueName' => ['maxLength']
                ],
                'thumbFileModel' => [
                    'uniqueName' => ['maxLength']
                ],
            ]
        ];
    }

    /**
     * Data provider for CRUD. Incorrect values
     *
     * @return array
     */
    private function _getDataProviderIncorrect3()
    {
        return [
            [
                'imageGroupId'      => '1 ',
                'originalFileModel' => [
                    'uniqueName' => 12345
                ],
                'viewFileModel'     => [
                    'uniqueName' => 11111
                ],
                'thumbFileModel'    => [
                    'uniqueName' => 22222
                ],
                'isCover'           => 9999,
                'sort'              => 9999,
                'alt'               => 9999,
                'width'             => 9999,
                'height'            => 9999,
                'x1'                => 9999,
                'y1'                => 9999,
                'viewWidth'                => 9999,
                'viewHeight'                => 9999,
                'thumbX'            => 9999,
                'thumbY'            => 9999,
                'thumbWidth'        => 9999,
                'thumbHeight'       => 9999,
            ],
            [
                'imageGroupId'      => 1,
                'originalFileModel' => [
                    'uniqueName' => '12345',
                ],
                'viewFileModel'     => [
                    'uniqueName' => '11111',
                ],
                'thumbFileModel'    => [
                    'uniqueName' => '22222',
                ],
                'isCover'           => true,
                'sort'              => 9999,
                'alt'               => '9999',
                'width'             => 9999,
                'height'            => 9999,
                'x1'                => 9999,
                'y1'                => 9999,
                'viewWidth'                => 9999,
                'viewHeight'                => 9999,
                'thumbX'            => 9999,
                'thumbY'            => 9999,
                'thumbWidth'        => 9999,
                'thumbHeight'       => 9999,
            ],
            [
                'isCover'     => -10,
                'sort'        => -10,
                'alt'         => -10,
                'width'       => -10,
                'height'      => -10,
                'x1'          => -10,
                'y1'          => -10,
                'viewWidth'          => -10,
                'viewHeight'          => -10,
                'thumbX'      => -10,
                'thumbY'      => -10,
                'thumbWidth'  => -10,
                'thumbHeight' => -10,
            ],
            [
                'imageGroupId'      => 1,
                'originalFileModel' => [
                    'uniqueName' => '12345',
                ],
                'viewFileModel'     => [
                    'uniqueName' => '11111',
                ],
                'thumbFileModel'    => [
                    'uniqueName' => '22222',
                ],
                'isCover'           => false,
                'sort'              => -10,
                'alt'               => '-10',
                'width'             => 0,
                'height'            => 0,
                'x1'                => 0,
                'y1'                => 0,
                'viewWidth'                => 0,
                'viewHeight'                => 0,
                'thumbX'            => 0,
                'thumbY'            => 0,
                'thumbWidth'        => 0,
                'thumbHeight'       => 0,
            ],
        ];
    }
}
