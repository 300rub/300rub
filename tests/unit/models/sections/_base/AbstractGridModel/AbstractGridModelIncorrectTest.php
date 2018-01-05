<?php

namespace testS\tests\unit\models\sections\_base\AbstractGridModel;

use testS\models\sections\GridModel;
use testS\tests\unit\models\_abstract\_base\AbstractIncorrectModelTest;

/**
 * Tests for the model GridModel
 */
class AbstractGridModelIncorrectTest extends AbstractIncorrectModelTest
{

    /**
     * Gets model name
     *
     * @return GridModel
     */
    protected function getNewModel()
    {
        return new GridModel();
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
                    'blockId'    => 'incorrect',
                    'gridLineId' => 'incorrect',
                    'x'          => 'incorrect',
                    'y'          => 'incorrect',
                    'width'      => 'incorrect',
                ],
                [],
                [],
                [],
                self::EXCEPTION_MODEL
            ],
            'incorrect2' => [
                [
                    'blockId'    => ' 1',
                    'gridLineId' => ' 1',
                    'x'          => ' 2',
                    'y'          => ' 3',
                    'width'      => ' 4',
                ],
                [
                    'blockId'    => 1,
                    'gridLineId' => 1,
                    'x'          => 2,
                    'y'          => 3,
                    'width'      => 4,
                ],
            ],
            'incorrect3' => [
                [
                    'blockId'    => 1,
                    'gridLineId' => 1,
                    'x'          => 13,
                    'y'          => -5,
                    'width'      => 19,
                ],
                [
                    'blockId'    => 1,
                    'gridLineId' => 1,
                    'x'          => 11,
                    'y'          => 0,
                    'width'      => 1,
                ],
            ],
            'incorrect4' => [
                [
                    'blockId'    => 1,
                    'gridLineId' => 1,
                    'x'          => -4,
                    'width'      => 0,
                ],
                [
                    'blockId'    => 1,
                    'gridLineId' => 1,
                    'x'          => 0,
                    'y'          => 0,
                    'width'      => 3,
                ],
            ],
            'incorrect5' => [
                [
                    'blockId'    => 1,
                    'gridLineId' => 1,
                    'x'          => 10,
                    'width'      => 0,
                ],
                [
                    'blockId'    => 1,
                    'gridLineId' => 1,
                    'x'          => 10,
                    'y'          => 0,
                    'width'      => 2,
                ],
            ]
        ];
    }
}
