<?php

// @codingStandardsIgnoreLine
namespace ss\tests\phpunit\models\blocks\record\_base\AbstractRecordCloneModel;

use ss\models\blocks\record\RecordCloneModel;
use ss\tests\phpunit\models\_abstract\_base\AbstractCorrectModelTest;

/**
 * Tests for the model AbstractRecordCloneModel
 */
class AbstractRecordCloneModelCorrectTest extends AbstractCorrectModelTest
{

    /**
     * Gets model name
     *
     * @return RecordCloneModel
     */
    protected function getNewModel()
    {
        return new RecordCloneModel();
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
            'recordId'               => 1,
            'coverImageModel'       => [
                'designBlockModel' => [
                    'marginTop' => 10,
                ],
                'type'             => 1,
                'useAlbums'        => true,
            ],
            'descriptionTextModel'   => [
                'designTextModel'  => [
                    'size' => 10
                ],
                'designBlockModel' => [
                    'marginTop' => 10
                ],
                'type'             => 1,
                'hasEditor'        => true
            ],
            'designRecordCloneModel' => [
                'containerDesignBlockModel' => [
                    'marginTop' => 10
                ],
                'viewType'                  => 1,
            ],
            'hasCover'               => true,
            'hasCoverZoom'           => true,
            'hasDescription'         => true,
            'dateType'               => 1,
            'maxCount'               => 1
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
            'recordId'               => 1,
            'coverImageModel'       => [
                'designBlockModel' => [
                    'marginTop' => 10,
                ],
                'type'             => 1,
                'useAlbums'        => true,
            ],
            'descriptionTextModel'   => [
                'designTextModel'  => [
                    'size' => 10
                ],
                'designBlockModel' => [
                    'marginTop' => 10
                ],
                'type'             => 1,
                'hasEditor'        => true
            ],
            'designRecordCloneModel' => [
                'containerDesignBlockModel' => [
                    'marginTop' => 10
                ],
                'viewType'                  => 1,
            ],
            'hasCover'               => true,
            'hasCoverZoom'           => true,
            'hasDescription'         => true,
            'dateType'               => 1,
            'maxCount'               => 1
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
            'recordId'               => 1,
            'coverImageModel'       => [
                'designBlockModel' => [
                    'marginTop' => 20,
                ],
                'type'             => 0,
                'useAlbums'        => false,
            ],
            'descriptionTextModel'   => [
                'designTextModel'  => [
                    'size' => 20
                ],
                'designBlockModel' => [
                    'marginTop' => 20
                ],
                'type'             => 1,
                'hasEditor'        => false
            ],
            'designRecordCloneModel' => [
                'containerDesignBlockModel' => [
                    'marginTop' => 20
                ],
                'viewType'                  => 1,
            ],
            'hasCover'               => false,
            'hasCoverZoom'           => false,
            'hasDescription'         => false,
            'dateType'               => 0,
            'maxCount'               => 0
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
            'recordId'               => 1,
            'coverImageModel'       => [
                'designBlockModel' => [
                    'marginTop' => 20,
                ],
                'type'             => 0,
                'useAlbums'        => false,
            ],
            'descriptionTextModel'   => [
                'designTextModel'  => [
                    'size' => 20
                ],
                'designBlockModel' => [
                    'marginTop' => 20
                ],
                'type'             => 1,
                'hasEditor'        => false
            ],
            'designRecordCloneModel' => [
                'containerDesignBlockModel' => [
                    'marginTop' => 20
                ],
                'viewType'                  => 1,
            ],
            'hasCover'               => false,
            'hasCoverZoom'           => false,
            'hasDescription'         => false,
            'dateType'               => 0,
            'maxCount'               => 0
        ];
    }
}
