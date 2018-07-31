<?php

namespace ss\tests\phpunit\models\blocks\search\_base\AbstractDesignSearchModel;

use ss\models\blocks\search\DesignSearchModel;
use ss\tests\phpunit\models\_abstract\_base\AbstractIncorrectModelTest;

/**
 * Tests for the model AbstractDesignSearchModel
 */
class AbstractDesignSearchModelIncorrectTest extends AbstractIncorrectModelTest
{

    /**
     * Gets model name
     *
     * @return DesignSearchModel
     */
    protected function getNewModel()
    {
        return new DesignSearchModel();
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
                    'containerDesignBlockModel'      => 'incorrect',
                    'titleDesignBlockModel'          => 'incorrect',
                    'titleDesignTextModel'           => 'incorrect',
                    'descriptionDesignBlockModel'    => 'incorrect',
                    'descriptionDesignTextModel'     => 'incorrect',
                    'paginationDesignBlockModel'     => 'incorrect',
                    'paginationItemDesignBlockModel' => 'incorrect',
                    'paginationItemDesignTextModel'  => 'incorrect',
                ],
                [
                    'containerDesignBlockModel'      => [
                        'marginTop' => 0
                    ],
                    'titleDesignBlockModel'          => [
                        'marginTop' => 0
                    ],
                    'titleDesignTextModel'           => [
                        'size' => 0
                    ],
                    'descriptionDesignBlockModel'    => [
                        'marginTop' => 0
                    ],
                    'descriptionDesignTextModel'     => [
                        'size' => 0
                    ],
                    'paginationDesignBlockModel'     => [
                        'marginTop' => 0
                    ],
                    'paginationItemDesignBlockModel' => [
                        'marginTop' => 0
                    ],
                    'paginationItemDesignTextModel'  => [
                        'size' => 0
                    ],
                ],
                [
                    'containerDesignBlockModel'      => [
                        'marginTop' => ' 500d '
                    ],
                    'titleDesignBlockModel'          => [
                        'marginTop' => '500d '
                    ],
                    'titleDesignTextModel'           => [
                        'size' => '500d '
                    ],
                    'descriptionDesignBlockModel'    => [
                        'marginTop' => '500d '
                    ],
                    'descriptionDesignTextModel'     => [
                        'size' => '500d '
                    ],
                    'paginationDesignBlockModel'     => [
                        'marginTop' => '500d '
                    ],
                    'paginationItemDesignBlockModel' => [
                        'marginTop' => '500d '
                    ],
                    'paginationItemDesignTextModel'  => [
                        'size' => '500d '
                    ],
                ],
                [
                    'containerDesignBlockModel'      => [
                        'marginTop' => 500
                    ],
                    'titleDesignBlockModel'          => [
                        'marginTop' => 500
                    ],
                    'titleDesignTextModel'           => [
                        'size' => 500
                    ],
                    'descriptionDesignBlockModel'    => [
                        'marginTop' => 500
                    ],
                    'descriptionDesignTextModel'     => [
                        'size' => 500
                    ],
                    'paginationDesignBlockModel'     => [
                        'marginTop' => 500
                    ],
                    'paginationItemDesignBlockModel' => [
                        'marginTop' => 500
                    ],
                    'paginationItemDesignTextModel'  => [
                        'size' => 500
                    ],
                ],
            ]
        ];
    }
}
