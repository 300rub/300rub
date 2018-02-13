<?php

// @codingStandardsIgnoreLine
namespace ss\tests\unit\models\blocks\record\_base\AbstractRecordInstanceModel;

use ss\models\blocks\record\RecordInstanceModel;
use ss\tests\unit\models\_abstract\_base\AbstractIncorrectModelTest;

/**
 * Tests for the model AbstractRecordInstanceModel
 */
// @codingStandardsIgnoreLine
class AbstractRecordInstanceModelIncorrectTest extends AbstractIncorrectModelTest
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
     * Data provider for CRUD. Incorrect values
     *
     * @return array
     */
    protected function getDataProviderIncorrect()
    {
        return [
            'incorrect1' => $this->_getDataProviderIncorrect1(),
            'incorrect2' => $this->_getDataProviderIncorrect2(),
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
                'recordId'                     => 'incorrect',
                'seoModel'                     => 'incorrect',
                'textTextInstanceModel'        => 'incorrect',
                'descriptionTextInstanceModel' => 'incorrect',
                'imageGroupModel'              => 'incorrect',
                'coverImageInstanceModel'      => 'incorrect',
                'date'                         => 'incorrect',
                'sort'                         => 'incorrect',
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
            $this->_createData2(),
            $this->_createExpectedData2(),
        ];
    }

    /**
     * Data provider for CRUD. Incorrect values
     *
     * @return array
     */
    private function _createData2()
    {
        return [
            'recordId'                     => ' 1 ',
            'seoModel'                     => [
                'name'        => '<b> name 1 </b>',
                'url'         => '<b> url-1 <b>',
                'title'       => '<b> title 1 <b>',
                'keywords'    => '<b> keywords 1 <b>',
                'description' => '<b> description 1<b> ',
            ],
            'textTextInstanceModel'        => [
                'textId' => '1asd',
                'text'   => 123
            ],
            'descriptionTextInstanceModel' => [
                'textId' => ' 1 asd',
                'text'   => 321
            ],
            'imageGroupModel'              => [
                'imageId' => ' 1 ds',
                'name'    => ' <b> record ',
                'sort'    => '25',
            ],
            'coverImageInstanceModel'      => [
                'imageGroupId' => '1asd',
                'originalFileModel' => [
                    'uniqueName' => '<b> record'
                ],
                'viewFileModel' => [
                    'uniqueName' => '<b>view_record'
                ],
                'thumbFileModel' => [
                    'uniqueName' => '<b>thumb_record'
                ],
                'isCover'      => 0,
                'sort'         => 'incorrect',
                'alt'          => 333,
                'width'        => '10s',
                'height'       => '10s',
                'x1'           => '10s',
                'y1'           => '10s',
                'x2'           => '10s',
                'y2'           => '10s',
                'thumbX1'      => '10s',
                'thumbY1'      => '10s',
                'thumbX2'      => '10s',
                'thumbY2'      => '10s',
            ],
            'sort'                         => '45asd',
        ];
    }

    /**
     * Data provider for CRUD. Incorrect values
     *
     * @return array
     */
    private function _createExpectedData2()
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
                'text'   => '123'
            ],
            'descriptionTextInstanceModel' => [
                'textId' => 1,
                'text'   => '321'
            ],
            'imageGroupModel'              => [
                'imageId' => 1,
                'name'    => 'record',
                'sort'    => 25,
            ],
            'coverImageInstanceModel'      => [
                'imageGroupId' => 1,
                'originalFileModel' => [
                    'uniqueName' => 'record'
                ],
                'viewFileModel' => [
                    'uniqueName' => 'view_record'
                ],
                'thumbFileModel' => [
                    'uniqueName' => 'thumb_record'
                ],
                'isCover'      => false,
                'sort'         => 0,
                'alt'          => '333',
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
            'sort'                         => 45,
        ];
    }
}
