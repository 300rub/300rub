<?php

namespace ss\tests\unit\models\blocks\search\_base\AbstractSearchModel;

use ss\models\blocks\search\SearchModel;
use ss\tests\unit\models\_abstract\_base\AbstractIncorrectModelTest;

/**
 * Tests for the model AbstractSearchModel
 */
class AbstractSearchModelIncorrectTest extends AbstractIncorrectModelTest
{

    /**
     * Gets model name
     *
     * @return SearchModel
     */
    protected function getNewModel()
    {
        return new SearchModel();
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
                    'formModelId'    => 0,
                    'searchDesignId' => 0,
                ],
                [
                    'formModel'         => [
                        'designFormModel' => [
                            'containerDesignBlockModel' => [
                                'marginTop' => 0
                            ],
                            'lineDesignBlockModel'      => [
                                'marginTop' => 0
                            ],
                            'submitIcon'                => '',
                            'submitIconPosition'        => 0,
                            'submitAlignment'           => 0
                        ],
                        'hasLabel'        => false,
                        'successText'     => ''
                    ],
                    'searchDesignModel' => [
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
                ],
                [
                    'formModel' => [
                        'designFormModel'   => [
                            'containerDesignBlockModel' => [
                                'marginTop' => ' 10a '
                            ],
                        ],
                        'hasLabel'                  => 'asadasd',
                    ],
                    'searchDesignModel' => [
                        'containerDesignBlockModel' => [
                            'marginTop' => '120 a'
                        ],
                    ]
                ],
                [
                    'formModel' => [
                        'designFormModel'   => [
                            'containerDesignBlockModel' => [
                                'marginTop' => 10
                            ],
                        ],
                        'hasLabel'                  => false,
                    ],
                    'searchDesignModel' => [
                        'containerDesignBlockModel' => [
                            'marginTop' => 120
                        ],
                    ]
                ]
            ]
        ];
    }
}
