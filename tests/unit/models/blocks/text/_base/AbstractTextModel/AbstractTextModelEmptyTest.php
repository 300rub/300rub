<?php

namespace testS\tests\unit\models\blocks\text\_base\AbstractTextModel;

use testS\models\blocks\text\TextModel;
use testS\tests\unit\models\_abstract\_base\AbstractEmptyModelTest;

/**
 * Tests for the model TextModel
 */
class AbstractTextModelEmptyTest extends AbstractEmptyModelTest
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
     * Data provider for CRUD. Empty values
     *
     * @return array
     */
    protected function getDataProviderEmpty()
    {
        return [
            'empty1' => [
                [],
                [
                    'designTextModel'  => [
                        'size' => 0
                    ],
                    'designBlockModel' => [
                        'marginTop' => 0
                    ],
                    'type'             => 0,
                    'hasEditor'        => false
                ]
            ],
            'empty2' => [
                [
                    'designTextModel'  => '',
                    'designBlockModel' => '',
                    'type'             => '',
                    'hasEditor'        => '',
                ],
                [
                    'designTextModel'  => [
                        'size' => 0
                    ],
                    'designBlockModel' => [
                        'marginTop' => 0
                    ],
                    'type'             => 0,
                    'hasEditor'        => false
                ]
            ],
            'empty3' => [
                [
                    'designTextId'  => '',
                    'designBlockId' => '',
                    'type'          => '',
                    'hasEditor'     => '',
                ],
                [
                    'designTextModel'  => [
                        'size' => 0
                    ],
                    'designBlockModel' => [
                        'marginTop' => 0
                    ],
                    'type'             => 0,
                    'hasEditor'        => false
                ]
            ],
            'empty4' => [
                [
                    'designTextId'  => null,
                    'designBlockId' => null,
                    'type'          => null,
                    'hasEditor'     => null,
                ],
                [
                    'designTextModel'  => [
                        'size' => 0
                    ],
                    'designBlockModel' => [
                        'marginTop' => 0
                    ],
                    'type'             => 0,
                    'hasEditor'        => false
                ],
                [
                    'designTextModel'  => '',
                    'designBlockModel' => '',
                    'type'             => '',
                    'hasEditor'        => '',
                ],
                [
                    'designTextModel'  => [
                        'size' => 0
                    ],
                    'designBlockModel' => [
                        'marginTop' => 0
                    ],
                    'type'             => 0,
                    'hasEditor'        => false
                ]
            ],
        ];
    }
}
