<?php

namespace testS\tests\unit\models\blocks\text\_base\AbstractTextModel;

use testS\models\blocks\text\TextModel;
use testS\tests\unit\models\_abstract\_base\AbstractCorrectModelTest;

/**
 * Tests for the model TextModel
 */
class AbstractTextModelCorrectTest extends AbstractCorrectModelTest
{

    /**
     * Gets model name
     *
     * @return TextModel
     */
    protected function getNewModel()
    {
        return new TextModel();
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
                [
                    'type'      => 0,
                    'hasEditor' => true,
                ],
                [
                    'designTextModel'  => [
                        'size' => 0
                    ],
                    'designBlockModel' => [
                        'marginTop' => 0
                    ],
                    'type'             => 0,
                    'hasEditor'        => true
                ],
                [
                    'designTextModel'  => [
                        'size' => 10
                    ],
                    'designBlockModel' => [
                        'marginTop' => 20
                    ],
                    'type'             => 1,
                    'hasEditor'        => false
                ],
                [
                    'designTextModel'  => [
                        'size' => 10
                    ],
                    'designBlockModel' => [
                        'marginTop' => 20
                    ],
                    'type'             => 1,
                    'hasEditor'        => false
                ]
            ],
            'correct2' => [
                [
                    'type'      => 1,
                    'hasEditor' => false,
                ],
                [
                    'designTextModel'  => [
                        'size' => 0
                    ],
                    'designBlockModel' => [
                        'marginTop' => 0
                    ],
                    'type'             => 1,
                    'hasEditor'        => false
                ],
                [
                    'designTextModel'  => [
                        'size' => 100
                    ],
                    'designBlockModel' => [
                        'marginTop' => 2
                    ],
                    'type'             => 0,
                    'hasEditor'        => true
                ],
                [
                    'designTextModel'  => [
                        'size' => 100
                    ],
                    'designBlockModel' => [
                        'marginTop' => 2
                    ],
                    'type'             => 0,
                    'hasEditor'        => true
                ]
            ]
        ];
    }
}
