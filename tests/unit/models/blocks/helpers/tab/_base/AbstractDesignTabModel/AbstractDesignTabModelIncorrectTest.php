<?php

// @codingStandardsIgnoreLine
namespace ss\tests\unit\models\blocks\helpers\tab\_base\AbstractDesignTabModel;

use ss\models\blocks\helpers\tab\DesignTabModel;
use ss\tests\unit\models\_abstract\_base\AbstractIncorrectModelTest;

/**
 * Tests for the model AbstractDesignTabModel
 */
class AbstractDesignTabModelIncorrectTest extends AbstractIncorrectModelTest
{

    /**
     * Gets model name
     *
     * @return DesignTabModel
     */
    protected function getNewModel()
    {
        return new DesignTabModel();
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
                    'containerDesignBlockModel' => 'incorrect',
                    'tabDesignBlockModel'       => 'incorrect',
                    'tabDesignTextModel'        => 'incorrect',
                    'contentDesignBlockModel'   => 'incorrect',
                ],
                [
                    'containerDesignBlockModel' => [
                        'marginTop' => 0
                    ],
                    'tabDesignBlockModel'       => [
                        'marginTop' => 0
                    ],
                    'tabDesignTextModel'        => [
                        'size' => 0
                    ],
                    'contentDesignBlockModel'   => [
                        'marginTop' => 0
                    ],
                ],
                [
                    'containerDesignBlockModel' => [
                        'marginTop' => ' 500 '
                    ],
                    'tabDesignBlockModel'       => [
                        'marginTop' => ' 500 '
                    ],
                    'tabDesignTextModel'        => [
                        'size' => ' 500 '
                    ],
                    'contentDesignBlockModel'   => [
                        'marginTop' => ' 500 '
                    ],
                ],
                [
                    'containerDesignBlockModel' => [
                        'marginTop' => 500
                    ],
                    'tabDesignBlockModel'       => [
                        'marginTop' => 500
                    ],
                    'tabDesignTextModel'        => [
                        'size' => 500
                    ],
                    'contentDesignBlockModel'   => [
                        'marginTop' => 500
                    ],
                ],
            ]
        ];
    }
}
