<?php

namespace testS\tests\unit\models\blocks\search\_base\AbstractSearchModel;

use testS\models\blocks\search\SearchModel;
use testS\tests\unit\models\_abstract\_base\AbstractDuplicateModelTest;

/**
 * Tests for the model AbstractSearchModel
 */
class AbstractSearchModelDuplicateTest extends AbstractDuplicateModelTest
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
     * Data provider for CRUD. Duplicate
     *
     * @return void
     */
    public function testDuplicate()
    {
        $this->duplicate(
            $this->_createData(),
            $this->_createExpectData()
        );
    }

    /**
     * Data provider for CRUD. Duplicate
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
     * Data provider for CRUD. Duplicate
     *
     * @return array
     */
    private function _createExpectData()
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
}
