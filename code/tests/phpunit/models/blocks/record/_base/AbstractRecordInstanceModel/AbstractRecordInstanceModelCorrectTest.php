<?php

// @codingStandardsIgnoreLine
namespace ss\tests\phpunit\models\blocks\record\_base\AbstractRecordInstanceModel;

use ss\models\blocks\record\RecordInstanceModel;
use ss\tests\phpunit\models\_abstract\_base\AbstractCorrectModelTest;

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
                'alias'         => 'alias-1',
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
                'seoModel' => [
                    'name'    => 'record',
                ],
                'sort'    => 0,
            ],
            'coverImageInstanceModel' => [
                'imageGroupId'      => 1,
                'originalFileModel' => [
                    'uniqueName' => 'name'
                ],
                'viewFileModel'     => [
                    'uniqueName' => 'view_name'
                ],
                'thumbFileModel'    => [
                    'uniqueName' => 'thumb_name'
                ],
                'isCover'           => false,
                'sort'              => 0,
                'alt'               => '',
                'width'             => 0,
                'height'            => 0,
                'viewX'             => 0,
                'viewY'             => 0,
                'viewWidth'         => 0,
                'viewHeight'        => 0,
                'thumbX'            => 0,
                'thumbY'            => 0,
                'thumbWidth'        => 0,
                'thumbHeight'       => 0,
            ],
            'sort'                    => 0,
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
                'alias'         => 'alias-1',
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
                'seoModel' => [
                    'name' => 'record',
                ],
                'sort'    => 0,
            ],
            'coverImageInstanceModel' => [
                'imageGroupId'      => 1,
                'originalFileModel' => [
                    'uniqueName' => 'name'
                ],
                'viewFileModel'     => [
                    'uniqueName' => 'view_name'
                ],
                'thumbFileModel'    => [
                    'uniqueName' => 'thumb_name'
                ],
                'isCover'           => false,
                'sort'              => 0,
                'alt'               => '',
                'width'             => 0,
                'height'            => 0,
                'viewX'             => 0,
                'viewY'             => 0,
                'viewWidth'         => 0,
                'viewHeight'        => 0,
                'thumbX'            => 0,
                'thumbY'            => 0,
                'thumbWidth'        => 0,
                'thumbHeight'       => 0,
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
                'alias'         => 'alias-2',
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
                'seoModel' => [
                    'name' => 'Name 2',
                ],
                'sort'    => 10,
            ],
            'coverImageInstanceModel' => [
                'imageGroupId'      => 1,
                'originalFileModel' => [
                    'uniqueName' => 'name'
                ],
                'viewFileModel'     => [
                    'uniqueName' => 'view_name'
                ],
                'thumbFileModel'    => [
                    'uniqueName' => 'thumb_name'
                ],
                'isCover'           => false,
                'sort'              => 10,
                'alt'               => '123',
                'width'             => 10,
                'height'            => 10,
                'viewX'             => 10,
                'viewY'             => 10,
                'viewWidth'         => 10,
                'viewHeight'        => 10,
                'thumbX'            => 10,
                'thumbY'            => 10,
                'thumbWidth'        => 10,
                'thumbHeight'       => 10,
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
                'alias'         => 'alias-2',
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
                'seoModel' => [
                    'name' => 'Name 2',
                ],
                'sort'    => 10,
            ],
            'coverImageInstanceModel' => [
                'imageGroupId'      => 1,
                'originalFileModel' => [
                    'uniqueName' => 'name'
                ],
                'viewFileModel'     => [
                    'uniqueName' => 'view_name'
                ],
                'thumbFileModel'    => [
                    'uniqueName' => 'thumb_name'
                ],
                'isCover'           => false,
                'sort'              => 10,
                'alt'               => '123',
                'width'             => 10,
                'height'            => 10,
                'viewX'             => 10,
                'viewY'             => 10,
                'viewWidth'         => 10,
                'viewHeight'        => 10,
                'thumbX'            => 10,
                'thumbY'            => 10,
                'thumbWidth'        => 10,
                'thumbHeight'       => 10,
            ],
            'sort'                         => 10,
        ];
    }
}
