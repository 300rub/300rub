<?php

// @codingStandardsIgnoreLine
namespace testS\tests\unit\models\blocks\helpers\field\_base\AbstractFieldModel;

use testS\models\blocks\helpers\field\FieldModel;
use testS\tests\unit\models\_abstract\_base\AbstractEmptyModelTest;

/**
 * Tests for the model AbstractFieldModel
 */
class AbstractFieldModelEmptyTest extends AbstractEmptyModelTest
{

    /**
     * Gets model name
     *
     * @return FieldModel
     */
    protected function getNewModel()
    {
        return new FieldModel();
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
                    'designFieldModel' => [
                        'shortCardContainerDesignBlockModel' => [
                            'marginTop' => 0
                        ],
                        'shortCardLabelDesignBlockModel'     => [
                            'marginTop' => 0
                        ],
                        'shortCardLabelDesignTextModel'      => [
                            'size' => 0
                        ],
                        'shortCardValueDesignBlockModel'     => [
                            'marginTop' => 0
                        ],
                        'shortCardValueDesignTextModel'      => [
                            'size' => 0
                        ],
                        'fullCardContainerDesignBlockModel'  => [
                            'marginTop' => 0
                        ],
                        'fullCardLabelDesignBlockModel'      => [
                            'marginTop' => 0
                        ],
                        'fullCardLabelDesignTextModel'       => [
                            'size' => 0
                        ],
                        'fullCardValueDesignBlockModel'      => [
                            'marginTop' => 0
                        ],
                        'fullCardValueDesignTextModel'       => [
                            'size' => 0
                        ],
                    ]
                ],
                [
                    'designFieldModel' => ''
                ],
                [
                    'designFieldModel' => [
                        'shortCardContainerDesignBlockModel' => [
                            'marginTop' => 0
                        ],
                    ]
                ]
            ],
            'empty2' => [
                [
                    'designFieldModel' => null,
                ],
                [
                    'designFieldModel' => [
                        'shortCardContainerDesignBlockModel' => [
                            'marginTop' => 0
                        ],
                    ]
                ],
                [
                    'designFieldModel' => [
                        'shortCardContainerDesignBlockModel' => [
                            'marginTop' => ' '
                        ],
                    ]
                ],
                [
                    'designFieldModel' => [
                        'shortCardContainerDesignBlockModel' => [
                            'marginTop' => 0
                        ],
                    ]
                ]
            ]
        ];
    }
}
