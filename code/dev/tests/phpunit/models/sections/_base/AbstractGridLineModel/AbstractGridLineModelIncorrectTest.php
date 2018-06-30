<?php

namespace ss\tests\unit\models\sections\_base\AbstractGridLineModel;

use ss\models\sections\GridLineModel;
use ss\tests\unit\models\_abstract\_base\AbstractIncorrectModelTest;

/**
 * Tests for the model GridLineModel
 */
class AbstractGridLineModelIncorrectTest extends AbstractIncorrectModelTest
{

    /**
     * Gets model name
     *
     * @return GridLineModel
     */
    protected function getNewModel()
    {
        return new GridLineModel();
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
                    'sectionId'       => 'incorrect',
                    'outsideDesignId' => 'incorrect',
                    'insideDesignId'  => 'incorrect',
                    'sort'            => 'incorrect',
                ],
                [],
                [],
                [],
                self::EXCEPTION_MODEL
            ],
            'incorrect2' => [
                [
                    'sectionId'       => '1',
                    'outsideDesignId' => 'incorrect',
                    'insideDesignId'  => 'incorrect',
                    'sort'            => 'incorrect',
                ],
                [
                    'sectionId'          => 1,
                    'outsideDesignModel' => [
                        'marginTop' => 0
                    ],
                    'insideDesignModel'  => [
                        'marginTop' => 0
                    ],
                    'sort'               => 0,
                ],
                [
                    'sectionId'          => ' 1 ',
                    'outsideDesignModel' => [
                        'marginTop' => ' 500 '
                    ],
                    'insideDesignModel'  => [
                        'marginTop' => ' 200 a'
                    ],
                    'sort'               => ' 32 as',
                ],
                [
                    'sectionId'          => 1,
                    'outsideDesignModel' => [
                        'marginTop' => 500
                    ],
                    'insideDesignModel'  => [
                        'marginTop' => 200
                    ],
                    'sort'               => 32,
                ],
            ]
        ];
    }
}
