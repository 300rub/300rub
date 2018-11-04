<?php

// @codingStandardsIgnoreLine
namespace ss\tests\phpunit\models\blocks\record\_base\AbstractRecordCloneModel;

use ss\models\blocks\record\RecordCloneModel;
use ss\tests\phpunit\models\_abstract\_base\AbstractDuplicateModelTest;

/**
 * Tests for the model AbstractRecordCloneModel
 */
class AbstractRecordCloneModelDuplicateTest extends AbstractDuplicateModelTest
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
     * Data provider for CRUD. Duplicate
     *
     * @return void
     */
    public function testDuplicate()
    {
        $this->duplicate(
            [
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
                    'hasEditor'        => false
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
            ],
            [
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
                    'hasEditor'        => false
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
            ]
        );
    }
}
