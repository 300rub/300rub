<?php

// @codingStandardsIgnoreLine
namespace ss\tests\phpunit\models\blocks\record\_base\AbstractRecordCloneModel;

use ss\models\blocks\record\RecordCloneModel;
use ss\tests\phpunit\models\_abstract\_base\AbstractIncorrectModelTest;

/**
 * Tests for the model AbstractRecordCloneModel
 */
class AbstractRecordCloneModelIncorrectTest extends AbstractIncorrectModelTest
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
     * Data provider for CRUD. Incorrect values
     *
     * @return array
     */
    protected function getDataProviderIncorrect()
    {
        return [
            'incorrect1' => [
                [
                    'recordId'               => 'incorrect',
                    'coverImageModel'       => 'incorrect',
                    'descriptionTextModel'   => 'incorrect',
                    'designRecordCloneModel' => 'incorrect',
                    'hasCover'               => 'incorrect',
                    'hasCoverZoom'           => 'incorrect',
                    'hasDescription'         => 'incorrect',
                    'dateType'               => 'incorrect',
                    'maxCount'               => 'incorrect'
                ],
                [],
                null,
                null,
                self::EXCEPTION_MODEL
            ],
            'incorrect2' => [
                [
                    'recordId'               => ' 1a ',
                    'coverImageModel'       => [
                        'designBlockModel' => [
                            'marginTop' => ' 10 s',
                        ],
                        'type'             => '1',
                        'useAlbums'        => 1,
                    ],
                    'descriptionTextModel'   => [
                        'designTextModel'  => [
                            'size' => '10s'
                        ],
                        'designBlockModel' => [
                            'marginTop' => '10d'
                        ],
                        'type'             => '1a',
                        'hasEditor'        => 1
                    ],
                    'designRecordCloneModel' => [
                        'containerDesignBlockModel' => [
                            'marginTop' => '10asd'
                        ],
                        'viewType'                  => '1f',
                    ],
                    'hasCover'               => 1,
                    'hasCoverZoom'           => 1,
                    'hasDescription'         => 1,
                    'dateType'               => true,
                    'maxCount'               => true
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
                ],
                [
                    'dateType'               => 999,
                ],
                [
                    'dateType'               => 0,
                ]
            ]
        ];
    }
}
