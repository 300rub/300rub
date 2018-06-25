<?php

// @codingStandardsIgnoreLine
namespace ss\tests\unit\models\blocks\record\_base\AbstractRecordCloneModel;

use ss\models\blocks\record\RecordCloneModel;
use ss\tests\unit\models\_abstract\_base\AbstractEmptyModelTest;

/**
 * Tests for the model AbstractRecordCloneModel
 */
class AbstractRecordCloneModelEmptyTest extends AbstractEmptyModelTest
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
     * Data provider for CRUD. Empty values
     *
     * @return array
     */
    protected function getDataProviderEmpty()
    {
        return [
            'empty1' => [
                [],
                [],
                null,
                null,
                self::EXCEPTION_MODEL
            ],
            'empty2' => [
                [
                    'recordId'               => '',
                    'coverImageModel'       => '',
                    'descriptionTextModel'   => '',
                    'designRecordCloneModel' => '',
                    'hasCover'               => '',
                    'hasCoverZoom'           => '',
                    'hasDescription'         => '',
                    'dateType'               => '',
                    'maxCount'               => ''
                ],
                [],
                null,
                null,
                self::EXCEPTION_MODEL
            ],
            'empty3' => [
                [
                    'recordId' => 1,
                ],
                [
                    'recordId'               => 1,
                    'coverImageModel'       => [
                        'designBlockModel' => [
                            'marginTop' => 0,
                        ],
                        'type'             => 0,
                        'useAlbums'        => false,
                    ],
                    'descriptionTextModel'   => [
                        'designTextModel'  => [
                            'size' => 0
                        ],
                        'designBlockModel' => [
                            'marginTop' => 0
                        ],
                        'type'             => 0,
                        'hasEditor'        => false
                    ],
                    'designRecordCloneModel' => [
                        'containerDesignBlockModel' => [
                            'marginTop' => 0
                        ],
                        'viewType'                  => 0,
                    ],
                    'hasCover'               => false,
                    'hasCoverZoom'           => false,
                    'hasDescription'         => false,
                    'dateType'               => 0,
                    'maxCount'               => 0
                ],
            ]
        ];
    }
}
