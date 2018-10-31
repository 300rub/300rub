<?php

// @codingStandardsIgnoreLine
namespace ss\tests\phpunit\models\blocks\record\_base\AbstractDesignRecordCloneModel;

use ss\models\blocks\record\DesignRecordCloneModel;
use ss\tests\phpunit\models\_abstract\_base\AbstractIncorrectModelTest;

/**
 * Tests for the model AbstractDesignRecordCloneModel
 */
// @codingStandardsIgnoreLine
class AbstractDesignRecordCloneModelIncorrectTest extends AbstractIncorrectModelTest
{

    /**
     * Gets model name
     *
     * @return DesignRecordCloneModel
     */
    protected function getNewModel()
    {
        return new DesignRecordCloneModel();
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
                    'containerDesignBlockModel'   => 'incorrect',
                    'instanceDesignBlockModel'    => 'incorrect',
                    'titleDesignBlockModel'       => 'incorrect',
                    'titleDesignTextModel'        => 'incorrect',
                    'dateDesignTextModel'         => 'incorrect',
                    'descriptionDesignBlockModel' => 'incorrect',
                    'descriptionDesignTextModel'  => 'incorrect',
                    'viewType'                    => 'incorrect',
                ],
                [
                    'containerDesignBlockModel'   => [
                        'marginTop' => 0
                    ],
                    'instanceDesignBlockModel'    => [
                        'marginTop' => 0
                    ],
                    'titleDesignBlockModel'       => [
                        'marginTop' => 0
                    ],
                    'titleDesignTextModel'        => [
                        'size' => 0
                    ],
                    'dateDesignTextModel'         => [
                        'size' => 0
                    ],
                    'descriptionDesignBlockModel' => [
                        'marginTop' => 0
                    ],
                    'descriptionDesignTextModel'  => [
                        'size' => 0
                    ],
                    'viewType'                    => 0,
                ],
                [
                    'viewType' => 999,
                ],
                [
                    'viewType' => 0,
                ],
            ],
            'incorrect2' => [
                [
                    'viewType' => ' 1 ',
                ],
                [
                    'viewType' => 1,
                ],
                [
                    'titleDesignBlockModel'       => [
                        'marginTop' => ' 500g '
                    ],
                    'titleDesignTextModel'        => [
                        'size' => ' 500px '
                    ],
                    'dateDesignTextModel'         => [
                        'size' => ' 500g '
                    ],
                    'descriptionDesignBlockModel' => [
                        'marginTop' => ' 500g '
                    ],
                    'descriptionDesignTextModel'  => [
                        'size' => ' 500g '
                    ],
                    'viewType'                    => true,
                ],
                [
                    'titleDesignBlockModel'       => [
                        'marginTop' => 500
                    ],
                    'titleDesignTextModel'        => [
                        'size' => 500
                    ],
                    'dateDesignTextModel'         => [
                        'size' => 500
                    ],
                    'descriptionDesignBlockModel' => [
                        'marginTop' => 500
                    ],
                    'descriptionDesignTextModel'  => [
                        'size' => 500
                    ],
                    'viewType'                    => 1,
                ],
            ]
        ];
    }
}
