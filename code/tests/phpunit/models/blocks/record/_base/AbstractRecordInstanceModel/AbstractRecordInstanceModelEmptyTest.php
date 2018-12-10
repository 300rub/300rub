<?php

// @codingStandardsIgnoreLine
namespace ss\tests\phpunit\models\blocks\record\_base\AbstractRecordInstanceModel;

use ss\models\blocks\record\RecordInstanceModel;
use ss\tests\phpunit\models\_abstract\_base\AbstractEmptyModelTest;

/**
 * Tests for the model AbstractRecordInstanceModel
 */
class AbstractRecordInstanceModelEmptyTest extends AbstractEmptyModelTest
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
     * Data provider for CRUD. Empty values
     *
     * @return array
     */
    protected function getDataProviderEmpty()
    {
        return [
            'empty1' => $this->_getDataProviderEmpty1(),
            'empty2' => $this->_getDataProviderEmpty2(),
            'empty3' => $this->_getDataProviderEmpty3(),
            'empty4' => $this->_getDataProviderEmpty4(),
            'empty5' => $this->_getDataProviderEmpty5(),
        ];
    }

    /**
     * Data provider for CRUD. Empty values
     *
     * @return array
     */
    private function _getDataProviderEmpty1()
    {
        return [
            [],
            [],
            null,
            null,
            self::EXCEPTION_MODEL
        ];
    }

    /**
     * Data provider for CRUD. Empty values
     *
     * @return array
     */
    private function _getDataProviderEmpty2()
    {
        return [
            [
                'recordId'                     => '',
                'seoModel'                     => '',
                'textTextInstanceModel'        => '',
                'descriptionTextInstanceModel' => '',
                'imageGroupModel'              => '',
                'coverImageInstanceModel'      => '',
                'date'                         => '',
                'sort'                         => '',
            ],
            [],
            null,
            null,
            self::EXCEPTION_MODEL
        ];
    }

    /**
     * Data provider for CRUD. Empty values
     *
     * @return array
     */
    private function _getDataProviderEmpty3()
    {
        return [
            [
                'recordId'                     => 1,
                'seoModel'                     => '',
                'textTextInstanceModel'        => '',
                'descriptionTextInstanceModel' => '',
                'imageGroupModel'              => '',
                'coverImageInstanceModel'      => '',
                'date'                         => '',
                'sort'                         => '',
            ],
            [
                'seoModel' => [
                    'name' => ['required'],
                    'alias'  => ['required', 'alias'],
                ],
            ],
        ];
    }

    /**
     * Data provider for CRUD. Empty values
     *
     * @return array
     */
    private function _getDataProviderEmpty4()
    {
        return [
            [
                'recordId'                     => 1,
                'seoModel'                     => '',
                'textTextInstanceModel'        => [
                    'textId' => 1,
                ],
                'descriptionTextInstanceModel' => [
                    'textId' => 1,
                ],
                'imageGroupModel'              => [
                    'imageId' => 1,
                ],
                'coverImageInstanceModel'      => '',
                'date'                         => '',
                'sort'                         => '',
            ],
            [
                'seoModel' => [
                    'name' => ['required'],
                    'alias'  => ['required', 'alias'],
                ],
                'imageGroupModel'              => [
                    'seoModel' => [
                        'name' => ['required'],
                        'alias'  => ['required', 'alias'],
                    ],
                ],
            ],
        ];
    }

    /**
     * Data provider for CRUD. Empty values
     *
     * @return array
     */
    private function _getDataProviderEmpty5()
    {
        return [
            [
                'recordId'                     => 1,
                'seoModel'                     => [
                    'name' => 'name',
                ],
                'textTextInstanceModel'        => [
                    'textId' => 1,
                ],
                'descriptionTextInstanceModel' => [
                    'textId' => 1,
                ],
                'imageGroupModel'              => [
                    'imageId' => 1,
                    'seoModel' => [
                        'name'    => 'Name'
                    ]
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
                ],
            ],
            [
                'recordId'                     => 1,
                'seoModel'                     => [
                    'name'        => 'name',
                    'alias'         => 'name',
                    'title'       => '',
                    'keywords'    => '',
                    'description' => '',
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
                        'name'    => 'Name'
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
                    'x1'                => 0,
                    'y1'                => 0,
                    'viewWidth'                => 0,
                    'viewHeight'                => 0,
                    'thumbX'            => 0,
                    'thumbY'            => 0,
                    'thumbWidth'        => 0,
                    'thumbHeight'       => 0,
                ],
                'sort'                         => 0,
            ],
        ];
    }
}
