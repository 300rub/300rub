<?php

// @codingStandardsIgnoreLine
namespace ss\tests\phpunit\models\blocks\record\_base\AbstractRecordInstanceModel;

use ss\models\blocks\record\RecordInstanceModel;
use ss\tests\phpunit\models\_abstract\_base\AbstractIncorrectModelTest;

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
                'alias'         => '<b> alias-1 <b>',
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
                'seoModel' => [
                    'name'    => ' <b> record ',
                ],
                'sort'    => '25',
            ],
            'coverImageInstanceModel' => [
                'imageGroupId'      => '1asd',
                'originalFileModel' => [
                    'uniqueName' => '<b> ' . uniqid()
                ],
                'viewFileModel'     => [
                    'uniqueName' => '<b>' . uniqid()
                ],
                'thumbFileModel'    => [
                    'uniqueName' => '<b>' . uniqid()
                ],
                'isCover'           => 0,
                'sort'              => 'incorrect',
                'alt'               => 333,
                'width'             => '10s',
                'height'            => '10s',
                'viewX'             => '10s',
                'viewY'             => '10s',
                'viewWidth'         => '10s',
                'viewHeight'        => '10s',
                'thumbX'            => '10s',
                'thumbY'            => '10s',
                'thumbWidth'        => '10s',
                'thumbHeight'       => '10s',
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
                'alias'         => 'alias-1',
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
                'seoModel' => [
                    'name'    => 'record',
                ],
                'sort'    => 25,
            ],
            'coverImageInstanceModel' => [
                'imageGroupId'      => 1,
                'isCover'           => false,
                'sort'              => 0,
                'alt'               => '333',
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
            'sort'                         => 45,
        ];
    }
}
