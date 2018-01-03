<?php

namespace testS\tests\unit\models\image\_base\AbstractImageInstanceModel;

use testS\models\blocks\image\ImageInstanceModel;
use testS\tests\unit\models\_abstract\_base\AbstractCorrectModelTest;

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
            'imageGroupId' => 1,
            'originalFileModel' => [
                'uniqueName' => 'file.jpg',
            ],
            'viewFileModel' => [
                'uniqueName' => 'view_file.jpg',
            ],
            'thumbFileModel' => [
                'uniqueName' => 'thumb_file.jpg',
            ],
            'isCover'      => true,
            'sort'         => 10,
            'alt'          => 'Alt 1',
            'width'        => 800,
            'height'       => 600,
            'x1'           => 10,
            'y1'           => 30,
            'x2'           => 70,
            'y2'           => 80,
            'thumbX1'      => 5,
            'thumbY1'      => 15,
            'thumbX2'      => 35,
            'thumbY2'      => 45,
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
            'originalFileModel' => [
                'uniqueName' => 'file.jpg',
            ],
            'viewFileModel' => [
                'uniqueName' => 'view_file.jpg',
            ],
            'thumbFileModel' => [
                'uniqueName' => 'thumb_file.jpg',
            ],
            'isCover'      => true,
            'sort'         => 10,
            'alt'          => 'Alt 1',
            'width'        => 800,
            'height'       => 600,
            'x1'           => 10,
            'y1'           => 30,
            'x2'           => 70,
            'y2'           => 80,
            'thumbX1'      => 5,
            'thumbY1'      => 15,
            'thumbX2'      => 35,
            'thumbY2'      => 45,
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
            'imageGroupId' => 1,
            'originalFileModel' => [
                'uniqueName' => 'file2.jpg',
            ],
            'viewFileModel' => [
                'uniqueName' => 'view_file2.jpg',
            ],
            'thumbFileModel' => [
                'uniqueName' => 'thumb_file2.jpg',
            ],
            'isCover'      => false,
            'sort'         => 20,
            'alt'          => 'Alt 2',
            'width'        => 1024,
            'height'       => 768,
            'x1'           => 100,
            'y1'           => 300,
            'x2'           => 700,
            'y2'           => 800,
            'thumbX1'      => 50,
            'thumbY1'      => 115,
            'thumbX2'      => 135,
            'thumbY2'      => 145,
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
            'imageGroupId' => 1,
            'originalFileModel' => [
                'uniqueName' => 'file2.jpg',
            ],
            'viewFileModel' => [
                'uniqueName' => 'view_file2.jpg',
            ],
            'thumbFileModel' => [
                'uniqueName' => 'thumb_file2.jpg',
            ],
            'isCover'      => false,
            'sort'         => 20,
            'alt'          => 'Alt 2',
            'width'        => 1024,
            'height'       => 768,
            'x1'           => 100,
            'y1'           => 300,
            'x2'           => 700,
            'y2'           => 800,
            'thumbX1'      => 50,
            'thumbY1'      => 115,
            'thumbX2'      => 135,
            'thumbY2'      => 145,
        ];
    }
}
