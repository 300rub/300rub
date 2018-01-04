<?php

namespace testS\tests\unit\models\blocks\search\_base\AbstractSearchModel;

use testS\models\blocks\search\SearchModel;
use testS\tests\unit\models\_abstract\_base\AbstractCorrectModelTest;

/**
 * Tests for the model AbstractSearchModel
 */
class AbstractSearchModelCorrectTest extends AbstractCorrectModelTest
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
     * Data provider for CRUD. Correct values
     *
     * @return array
     */
    protected function getDataProviderCorrect()
    {
        return [
            'correct1' => [
                $this->_createData(),
                $this->_createExpectedData(),
                $this->_updateData(),
                $this->_updateExpectedData(),
            ],
        ];
    }

    /**
     * Data provider for CRUD. Correct values
     *
     * @return array
     */
    private function _createData()
    {
        return [
            'formModel'         => [
                'designFormModel' => [
                    'containerDesignBlockModel' => [
                        'marginTop' => 400
                    ],
                    'lineDesignBlockModel'      => [
                        'marginTop' => 500
                    ],
                    'submitIcon'                => 'fa-lock',
                    'submitIconPosition'        => 1,
                    'submitAlignment'           => 1
                ],
                'hasLabel'        => true,
                'successText'     => 'Thanks!'
            ],
            'searchDesignModel' => [
                'containerDesignBlockModel'      => [
                    'marginTop'                => 10,
                    'borderBottomWidth'        => 7,
                    'borderColorHover'         => 'rgb(0,255,0)',
                    'backgroundColorFromHover' => 'rgba(255,0,255,0.5)',
                ],
                'titleDesignBlockModel'          => [
                    'marginTop'                => 10,
                    'borderBottomWidth'        => 7,
                    'borderColorHover'         => 'rgb(0,255,0)',
                    'backgroundColorFromHover' => 'rgba(255,0,255,0.5)',
                ],
                'titleDesignTextModel'           => [
                    'size' => 10
                ],
                'descriptionDesignBlockModel'    => [
                    'marginTop'                => 10,
                    'borderBottomWidth'        => 7,
                    'borderColorHover'         => 'rgb(0,255,0)',
                    'backgroundColorFromHover' => 'rgba(255,0,255,0.5)',
                ],
                'descriptionDesignTextModel'     => [
                    'size' => 10
                ],
                'paginationDesignBlockModel'     => [
                    'marginTop'                => 10,
                    'borderBottomWidth'        => 7,
                    'borderColorHover'         => 'rgb(0,255,0)',
                    'backgroundColorFromHover' => 'rgba(255,0,255,0.5)',
                ],
                'paginationItemDesignBlockModel' => [
                    'marginTop'                => 10,
                    'borderBottomWidth'        => 7,
                    'borderColorHover'         => 'rgb(0,255,0)',
                    'backgroundColorFromHover' => 'rgba(255,0,255,0.5)',
                ],
                'paginationItemDesignTextModel'  => [
                    'size' => 10
                ],
            ],
        ];
    }

    /**
     * Data provider for CRUD. Correct values
     *
     * @return array
     */
    private function _createExpectedData()
    {
        return [
            'formModel'         => [
                'designFormModel' => [
                    'containerDesignBlockModel' => [
                        'marginTop' => 400
                    ],
                    'lineDesignBlockModel'      => [
                        'marginTop' => 500
                    ],
                    'submitIcon'                => 'fa-lock',
                    'submitIconPosition'        => 1,
                    'submitAlignment'           => 1
                ],
                'hasLabel'        => true,
                'successText'     => 'Thanks!'
            ],
            'searchDesignModel' => [
                'containerDesignBlockModel'      => [
                    'marginTop'                => 10,
                    'borderBottomWidth'        => 7,
                    'borderColorHover'         => 'rgb(0,255,0)',
                    'backgroundColorFromHover' => 'rgba(255,0,255,0.5)',
                ],
                'titleDesignBlockModel'          => [
                    'marginTop'                => 10,
                    'borderBottomWidth'        => 7,
                    'borderColorHover'         => 'rgb(0,255,0)',
                    'backgroundColorFromHover' => 'rgba(255,0,255,0.5)',
                ],
                'titleDesignTextModel'           => [
                    'size' => 10
                ],
                'descriptionDesignBlockModel'    => [
                    'marginTop'                => 10,
                    'borderBottomWidth'        => 7,
                    'borderColorHover'         => 'rgb(0,255,0)',
                    'backgroundColorFromHover' => 'rgba(255,0,255,0.5)',
                ],
                'descriptionDesignTextModel'     => [
                    'size' => 10
                ],
                'paginationDesignBlockModel'     => [
                    'marginTop'                => 10,
                    'borderBottomWidth'        => 7,
                    'borderColorHover'         => 'rgb(0,255,0)',
                    'backgroundColorFromHover' => 'rgba(255,0,255,0.5)',
                ],
                'paginationItemDesignBlockModel' => [
                    'marginTop'                => 10,
                    'borderBottomWidth'        => 7,
                    'borderColorHover'         => 'rgb(0,255,0)',
                    'backgroundColorFromHover' => 'rgba(255,0,255,0.5)',
                ],
                'paginationItemDesignTextModel'  => [
                    'size' => 10
                ],
            ],
        ];
    }

    /**
     * Data provider for CRUD. Correct values
     *
     * @return array
     */
    private function _updateData()
    {
        return [
            'formModel'         => [
                'designFormModel' => [
                    'containerDesignBlockModel' => [
                        'marginTop' => 300
                    ],
                    'lineDesignBlockModel'      => [
                        'marginTop' => 200
                    ],
                    'submitIcon'                => 'fa-check',
                    'submitIconPosition'        => 0,
                    'submitAlignment'           => 0
                ],
                'hasLabel'        => false,
                'successText'     => 'Text'
            ],
            'searchDesignModel' => [
                'containerDesignBlockModel'      => [
                    'marginTop'                => 5,
                    'borderBottomWidth'        => 4,
                    'borderColorHover'         => 'rgb(255,0,0)',
                    'backgroundColorFromHover' => 'rgba(0,0,255,0.7)',
                ],
                'titleDesignBlockModel'          => [
                    'marginTop'                => 5,
                    'borderBottomWidth'        => 4,
                    'borderColorHover'         => 'rgb(255,0,0)',
                    'backgroundColorFromHover' => 'rgba(0,0,255,0.7)',
                ],
                'titleDesignTextModel'           => [
                    'size' => 20
                ],
                'descriptionDesignBlockModel'    => [
                    'marginTop'                => 5,
                    'borderBottomWidth'        => 4,
                    'borderColorHover'         => 'rgb(255,0,0)',
                    'backgroundColorFromHover' => 'rgba(0,0,255,0.7)',
                ],
                'descriptionDesignTextModel'     => [
                    'size' => 20
                ],
                'paginationDesignBlockModel'     => [
                    'marginTop'                => 5,
                    'borderBottomWidth'        => 4,
                    'borderColorHover'         => 'rgb(255,0,0)',
                    'backgroundColorFromHover' => 'rgba(0,0,255,0.7)',
                ],
                'paginationItemDesignBlockModel' => [
                    'marginTop'                => 5,
                    'borderBottomWidth'        => 4,
                    'borderColorHover'         => 'rgb(255,0,0)',
                    'backgroundColorFromHover' => 'rgba(0,0,255,0.7)',
                ],
                'paginationItemDesignTextModel'  => [
                    'size' => 20
                ],
            ],
        ];
    }

    /**
     * Data provider for CRUD. Correct values
     *
     * @return array
     */
    private function _updateExpectedData()
    {
        return [
            'formModel'         => [
                'designFormModel' => [
                    'containerDesignBlockModel' => [
                        'marginTop' => 300
                    ],
                    'lineDesignBlockModel'      => [
                        'marginTop' => 200
                    ],
                    'submitIcon'                => 'fa-check',
                    'submitIconPosition'        => 0,
                    'submitAlignment'           => 0
                ],
                'hasLabel'        => false,
                'successText'     => 'Text'
            ],
            'searchDesignModel' => [
                'containerDesignBlockModel'      => [
                    'marginTop'                => 5,
                    'borderBottomWidth'        => 4,
                    'borderColorHover'         => 'rgb(255,0,0)',
                    'backgroundColorFromHover' => 'rgba(0,0,255,0.7)',
                ],
                'titleDesignBlockModel'          => [
                    'marginTop'                => 5,
                    'borderBottomWidth'        => 4,
                    'borderColorHover'         => 'rgb(255,0,0)',
                    'backgroundColorFromHover' => 'rgba(0,0,255,0.7)',
                ],
                'titleDesignTextModel'           => [
                    'size' => 20
                ],
                'descriptionDesignBlockModel'    => [
                    'marginTop'                => 5,
                    'borderBottomWidth'        => 4,
                    'borderColorHover'         => 'rgb(255,0,0)',
                    'backgroundColorFromHover' => 'rgba(0,0,255,0.7)',
                ],
                'descriptionDesignTextModel'     => [
                    'size' => 20
                ],
                'paginationDesignBlockModel'     => [
                    'marginTop'                => 5,
                    'borderBottomWidth'        => 4,
                    'borderColorHover'         => 'rgb(255,0,0)',
                    'backgroundColorFromHover' => 'rgba(0,0,255,0.7)',
                ],
                'paginationItemDesignBlockModel' => [
                    'marginTop'                => 5,
                    'borderBottomWidth'        => 4,
                    'borderColorHover'         => 'rgb(255,0,0)',
                    'backgroundColorFromHover' => 'rgba(0,0,255,0.7)',
                ],
                'paginationItemDesignTextModel'  => [
                    'size' => 20
                ],
            ],
        ];
    }
}
