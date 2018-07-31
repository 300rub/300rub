<?php

namespace ss\tests\phpunit\models\blocks\search\_base\AbstractSearchModel;

use ss\models\blocks\search\SearchModel;
use ss\tests\phpunit\models\_abstract\_base\AbstractEmptyModelTest;

/**
 * Tests for the model AbstractSearchModel
 */
class AbstractSearchModelEmptyTest extends AbstractEmptyModelTest
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
                ]
            ],
            'empty2' => [
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
                ]
            ]
        ];
    }
}
