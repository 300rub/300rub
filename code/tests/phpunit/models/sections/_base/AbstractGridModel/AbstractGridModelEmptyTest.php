<?php

namespace ss\tests\phpunit\models\sections\_base\AbstractGridModel;

use ss\models\sections\GridModel;
use ss\tests\phpunit\models\_abstract\_base\AbstractEmptyModelTest;

/**
 * Tests for the model GridModel
 */
class AbstractGridModelEmptyTest extends AbstractEmptyModelTest
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
                [],
                [],
                self::EXCEPTION_MODEL
            ],
            'empty2' => [
                [
                    'blockId'    => '',
                    'gridLineId' => '',
                    'x'          => '',
                    'y'          => '',
                    'width'      => '',
                ],
                [],
                [],
                [],
                self::EXCEPTION_MODEL
            ],
            'empty3' => [
                [
                    'blockId'    => 1,
                    'gridLineId' => '',
                    'x'          => '',
                    'y'          => '',
                    'width'      => '',
                ],
                [],
                [],
                [],
                self::EXCEPTION_MODEL
            ],
            'empty4' => [
                [
                    'blockId'    => '',
                    'gridLineId' => 1,
                    'x'          => '',
                    'y'          => '',
                    'width'      => '',
                ],
                [],
                [],
                [],
                self::EXCEPTION_MODEL
            ],
            'empty5' => [
                [
                    'blockId'    => 1,
                    'gridLineId' => 1,
                    'x'          => '',
                    'y'          => '',
                    'width'      => '',
                ],
                [
                    'blockId'    => 1,
                    'gridLineId' => 1,
                    'x'          => 0,
                    'y'          => 0,
                    'width'      => 3,
                ],
            ]
        ];
    }
}
