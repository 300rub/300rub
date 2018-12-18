<?php

namespace ss\tests\phpunit\models\blocks\image\_base\AbstractImageInstanceModel;

use ss\models\blocks\image\ImageInstanceModel;
use ss\tests\phpunit\models\_abstract\_base\AbstractCorrectModelTest;

/**
 * Tests for the model AbstractImageInstanceModel
 */
class AbstractImageInstanceModelCorrectTest extends AbstractCorrectModelTest
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
                $this->_updateExpectedData()
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
            'imageGroupId'      => 1,
            'originalFileModel' => [
                'uniqueName' => uniqid() . '.jpg',
            ],
            'viewFileModel'     => [
                'uniqueName' => uniqid(). '.jpg',
            ],
            'thumbFileModel'    => [
                'uniqueName' => uniqid() . '.jpg',
            ],
            'isCover'           => true,
            'sort'              => 10,
            'alt'               => 'Alt 1',
            'width'             => 800,
            'height'            => 600,
            'viewX'             => 10,
            'viewY'             => 30,
            'viewWidth'         => 70,
            'viewHeight'        => 80,
            'thumbX'            => 5,
            'thumbY'            => 15,
            'thumbWidth'        => 35,
            'thumbHeight'       => 45,
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
            'imageGroupId' => 1,
            'isCover'      => true,
            'sort'         => 10,
            'alt'          => 'Alt 1',
            'width'        => 800,
            'height'       => 600,
            'viewX'        => 10,
            'viewY'        => 30,
            'viewWidth'    => 70,
            'viewHeight'   => 80,
            'thumbX'       => 5,
            'thumbY'       => 15,
            'thumbWidth'   => 35,
            'thumbHeight'  => 45,
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
            'imageGroupId'      => 1,
            'originalFileModel' => [
                'uniqueName' => 'file2.jpg',
            ],
            'viewFileModel'     => [
                'uniqueName' => 'view_file2.jpg',
            ],
            'thumbFileModel'    => [
                'uniqueName' => 'thumb_file2.jpg',
            ],
            'isCover'           => false,
            'sort'              => 20,
            'alt'               => 'Alt 2',
            'width'             => 1024,
            'height'            => 768,
            'viewX'             => 100,
            'viewY'             => 300,
            'viewWidth'         => 700,
            'viewHeight'        => 800,
            'thumbX'            => 50,
            'thumbY'            => 115,
            'thumbWidth'        => 135,
            'thumbHeight'       => 145,
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
            'imageGroupId'      => 1,
            'originalFileModel' => [
                'uniqueName' => 'file2.jpg',
            ],
            'viewFileModel'     => [
                'uniqueName' => 'view_file2.jpg',
            ],
            'thumbFileModel'    => [
                'uniqueName' => 'thumb_file2.jpg',
            ],
            'isCover'           => false,
            'sort'              => 20,
            'alt'               => 'Alt 2',
            'width'             => 1024,
            'height'            => 768,
            'viewX'             => 100,
            'viewY'             => 300,
            'viewWidth'         => 700,
            'viewHeight'        => 800,
            'thumbX'            => 50,
            'thumbY'            => 115,
            'thumbWidth'        => 135,
            'thumbHeight'       => 145,
        ];
    }
}
