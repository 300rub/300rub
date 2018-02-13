<?php

// @codingStandardsIgnoreLine
namespace ss\tests\unit\models\blocks\record\_base\AbstractRecordInstanceModel;

use ss\models\blocks\record\RecordInstanceModel;
use ss\tests\unit\models\_abstract\_base\AbstractCorrectModelTest;

/**
 * Tests for the model AbstractRecordInstanceModel
 */
class AbstractRecordInstanceModelCorrectTest extends AbstractCorrectModelTest
{

    /**
     * Gets model name
     *
     * @return RecordInstanceModel
     */
    protected function getNewModel()
    {
        return new RecordInstanceModel();
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
                $this->_updateExpectedData(),
            ],
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
            'recordId'                     => 1,
            'seoModel'                     => [
                'name'        => 'name 1',
                'url'         => 'url-1',
                'title'       => 'title 1',
                'keywords'    => 'keywords 1',
                'description' => 'description 1',
            ],
            'textTextInstanceModel'        => [
                'textId' => 1,
                'text'   => ''
            ],
            'descriptionTextInstanceModel' => [
                'textId' => 1,
                'text'   => ''
            ],
            'imageGroupModel'              => [
                'imageId' => 1,
                'name'    => 'record',
                'sort'    => 0,
            ],
            'coverImageInstanceModel'      => [
                'imageGroupId' => 1,
                'originalFileModel' => [
                    'uniqueName' => 'name'
                ],
                'viewFileModel' => [
                    'uniqueName' => 'view_name'
                ],
                'thumbFileModel' => [
                    'uniqueName' => 'thumb_name'
                ],
                'isCover'      => false,
                'sort'         => 0,
                'alt'          => '',
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
            'sort'                         => 0,
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
            'recordId'                     => 1,
            'seoModel'                     => [
                'name'        => 'name 1',
                'url'         => 'url-1',
                'title'       => 'title 1',
                'keywords'    => 'keywords 1',
                'description' => 'description 1',
            ],
            'textTextInstanceModel'        => [
                'textId' => 1,
                'text'   => ''
            ],
            'descriptionTextInstanceModel' => [
                'textId' => 1,
                'text'   => ''
            ],
            'imageGroupModel'              => [
                'imageId' => 1,
                'name'    => 'record',
                'sort'    => 0,
            ],
            'coverImageInstanceModel'      => [
                'imageGroupId' => 1,
                'originalFileModel' => [
                    'uniqueName' => 'name'
                ],
                'viewFileModel' => [
                    'uniqueName' => 'view_name'
                ],
                'thumbFileModel' => [
                    'uniqueName' => 'thumb_name'
                ],
                'isCover'      => false,
                'sort'         => 0,
                'alt'          => '',
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
            'sort'                         => 0,
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
            'recordId'                     => 1,
            'seoModel'                     => [
                'name'        => 'name 2',
                'url'         => 'url-2',
                'title'       => 'title 2',
                'keywords'    => 'keywords 2',
                'description' => 'description 2',
            ],
            'textTextInstanceModel'        => [
                'textId' => 1,
                'text'   => 'Text 2'
            ],
            'descriptionTextInstanceModel' => [
                'textId' => 1,
                'text'   => 'Text 3'
            ],
            'imageGroupModel'              => [
                'imageId' => 1,
                'name'    => 'Name 2',
                'sort'    => 10,
            ],
            'coverImageInstanceModel'      => [
                'imageGroupId' => 1,
                'originalFileModel' => [
                    'uniqueName' => 'name'
                ],
                'viewFileModel' => [
                    'uniqueName' => 'view_name'
                ],
                'thumbFileModel' => [
                    'uniqueName' => 'thumb_name'
                ],
                'isCover'      => false,
                'sort'         => 10,
                'alt'          => '123',
                'width'        => 10,
                'height'       => 10,
                'x1'           => 10,
                'y1'           => 10,
                'x2'           => 10,
                'y2'           => 10,
                'thumbX1'      => 10,
                'thumbY1'      => 10,
                'thumbX2'      => 10,
                'thumbY2'      => 10,
            ],
            'sort'                         => 10,
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
            'recordId'                     => 1,
            'seoModel'                     => [
                'name'        => 'name 2',
                'url'         => 'url-2',
                'title'       => 'title 2',
                'keywords'    => 'keywords 2',
                'description' => 'description 2',
            ],
            'textTextInstanceModel'        => [
                'textId' => 1,
                'text'   => 'Text 2'
            ],
            'descriptionTextInstanceModel' => [
                'textId' => 1,
                'text'   => 'Text 3'
            ],
            'imageGroupModel'              => [
                'imageId' => 1,
                'name'    => 'Name 2',
                'sort'    => 10,
            ],
            'coverImageInstanceModel'      => [
                'imageGroupId' => 1,
                'originalFileModel' => [
                    'uniqueName' => 'name'
                ],
                'viewFileModel' => [
                    'uniqueName' => 'view_name'
                ],
                'thumbFileModel' => [
                    'uniqueName' => 'thumb_name'
                ],
                'isCover'      => false,
                'sort'         => 10,
                'alt'          => '123',
                'width'        => 10,
                'height'       => 10,
                'x1'           => 10,
                'y1'           => 10,
                'x2'           => 10,
                'y2'           => 10,
                'thumbX1'      => 10,
                'thumbY1'      => 10,
                'thumbX2'      => 10,
                'thumbY2'      => 10,
            ],
            'sort'                         => 10,
        ];
    }
}
