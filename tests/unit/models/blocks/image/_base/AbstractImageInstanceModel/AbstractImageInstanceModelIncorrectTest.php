<?php

namespace testS\tests\unit\models\image\_base\AbstractImageInstanceModel;

use testS\models\blocks\image\ImageInstanceModel;
use testS\tests\unit\models\_abstract\_base\AbstractIncorrectModelTest;

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
                'imageGroupId' => 'incorrect',
                'originalFileModel' => [
                    'uniqueName' => 'incorrect',
                ],
                'viewFileModel' => [
                    'uniqueName' => 'view_incorrect.jpg',
                ],
                'thumbFileModel' => [
                    'uniqueName' => 'thumb_incorrect.jpg',
                ],
                'isCover'      => 'incorrect',
                'sort'         => 'incorrect',
                'alt'          => 'incorrect',
                'width'        => 'incorrect',
                'height'       => 'incorrect',
                'x1'           => 'incorrect',
                'y1'           => 'incorrect',
                'x2'           => 'incorrect',
                'y2'           => 'incorrect',
                'thumbX1'      => 'incorrect',
                'thumbY1'      => 'incorrect',
                'thumbX2'      => 'incorrect',
                'thumbY2'      => 'incorrect',
            ],
            [],
            null,
            null,
            self::EXCEPTION_MODEL
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
                'imageGroupId' => '1 ',
                'originalFileModel' => [
                    'uniqueName' => '<b> 123 </b>',
                ],
                'viewFileModel' => [
                    'uniqueName' => '<b> view_123 </b>',
                ],
                'thumbFileModel' => [
                    'uniqueName' => '<b> thumb_123 </b>',
                ],
                'isCover'      => 'incorrect',
                'sort'         => 'incorrect',
                'alt'          => 'incorrect',
                'width'        => 'incorrect',
                'height'       => 'incorrect',
                'x1'           => 'incorrect',
                'y1'           => 'incorrect',
                'x2'           => 'incorrect',
                'y2'           => 'incorrect',
                'thumbX1'      => 'incorrect',
                'thumbY1'      => 'incorrect',
                'thumbX2'      => 'incorrect',
                'thumbY2'      => 'incorrect',
            ],
            [
                'imageGroupId' => 1,
                'originalFileModel' => [
                    'uniqueName' => '123',
                ],
                'viewFileModel' => [
                    'uniqueName' => 'view_123',
                ],
                'thumbFileModel' => [
                    'uniqueName' => 'thumb_123',
                ],
                'isCover'      => false,
                'sort'         => 0,
                'alt'          => 'incorrect',
                'width'        => 0,
                'height'       => 0,
                'x1'           => 0,
                'y1'           => 0,
                'x2'           => 0,
                'y2'           => 0,
                'thumbX1'      => 0,
                'thumbY1'      => 0,
                'thumbX2'      => 0,
                'thumbY2'      => 0,
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
                'imageGroupId' => '1 ',
                'originalFileModel' => [
                    'uniqueName' => 12345
                ],
                'viewFileModel' => [
                    'uniqueName' => 11111
                ],
                'thumbFileModel' => [
                    'uniqueName' => 22222
                ],
                'isCover'      => 9999,
                'sort'         => 9999,
                'alt'          => 9999,
                'width'        => 9999,
                'height'       => 9999,
                'x1'           => 9999,
                'y1'           => 9999,
                'x2'           => 9999,
                'y2'           => 9999,
                'thumbX1'      => 9999,
                'thumbY1'      => 9999,
                'thumbX2'      => 9999,
                'thumbY2'      => 9999,
            ],
            [
                'imageGroupId' => 1,
                'originalFileModel' => [
                    'uniqueName' => '12345',
                ],
                'viewFileModel' => [
                    'uniqueName' => '11111',
                ],
                'thumbFileModel' => [
                    'uniqueName' => '22222',
                ],
                'isCover'      => true,
                'sort'         => 9999,
                'alt'          => '9999',
                'width'        => 9999,
                'height'       => 9999,
                'x1'           => 9999,
                'y1'           => 9999,
                'x2'           => 9999,
                'y2'           => 9999,
                'thumbX1'      => 9999,
                'thumbY1'      => 9999,
                'thumbX2'      => 9999,
                'thumbY2'      => 9999,
            ],
            [
                'isCover' => -10,
                'sort'    => -10,
                'alt'     => -10,
                'width'   => -10,
                'height'  => -10,
                'x1'      => -10,
                'y1'      => -10,
                'x2'      => -10,
                'y2'      => -10,
                'thumbX1' => -10,
                'thumbY1' => -10,
                'thumbX2' => -10,
                'thumbY2' => -10,
            ],
            [
                'imageGroupId' => 1,
                'originalFileModel' => [
                    'uniqueName' => '12345',
                ],
                'viewFileModel' => [
                    'uniqueName' => '11111',
                ],
                'thumbFileModel' => [
                    'uniqueName' => '22222',
                ],
                'isCover'      => false,
                'sort'         => -10,
                'alt'          => '-10',
                'width'        => 0,
                'height'       => 0,
                'x1'           => 0,
                'y1'           => 0,
                'x2'           => 0,
                'y2'           => 0,
                'thumbX1'      => 0,
                'thumbY1'      => 0,
                'thumbX2'      => 0,
                'thumbY2'      => 0,
            ],
        ];
    }
}
