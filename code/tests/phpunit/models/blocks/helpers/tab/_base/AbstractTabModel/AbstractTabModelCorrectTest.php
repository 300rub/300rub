<?php

namespace ss\tests\phpunit\models\blocks\helpers\tab\_base\AbstractTabModel;

use ss\models\blocks\helpers\tab\TabModel;
use ss\tests\phpunit\models\_abstract\_base\AbstractCorrectModelTest;

/**
 * Tests for the model AbstractTabModel
 */
class AbstractTabModelCorrectTest extends AbstractCorrectModelTest
{

    /**
     * Gets model name
     *
     * @return TabModel
     */
    protected function getNewModel()
    {
        return new TabModel();
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
            ]
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
            'designTabsModel' => [
                'containerDesignBlockModel' => [
                    'marginTop'                => 10,
                    'borderBottomWidth'        => 7,
                    'borderColorHover'         => 'rgb(0,255,0)',
                    'backgroundColorFromHover' => 'rgba(255,0,255,0.5)',
                ],
                'tabDesignBlockModel'       => [
                    'marginTop'                => 10,
                    'borderBottomWidth'        => 7,
                    'borderColorHover'         => 'rgb(0,255,0)',
                    'backgroundColorFromHover' => 'rgba(255,0,255,0.5)',
                ],
                'tabDesignTextModel'        => [
                    'size' => 20
                ],
                'contentDesignBlockModel'   => [
                    'marginTop'                => 10,
                    'borderBottomWidth'        => 7,
                    'borderColorHover'         => 'rgb(0,255,0)',
                    'backgroundColorFromHover' => 'rgba(255,0,255,0.5)',
                ],
            ],
            'textModel'       => [
                'designTextModel'  => [
                    'size' => 10
                ],
                'designBlockModel' => [
                    'marginTop'                => 10,
                    'borderBottomWidth'        => 7,
                    'borderColorHover'         => 'rgb(0,255,0)',
                    'backgroundColorFromHover' => 'rgba(255,0,255,0.5)',
                ],
                'type'             => 1,
                'hasEditor'        => false,
            ],
            'isShowEmpty'     => true,
            'isLazyLoad'      => true,
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
            'designTabsModel' => [
                'containerDesignBlockModel' => [
                    'marginTop'                => 10,
                    'borderBottomWidth'        => 7,
                    'borderColorHover'         => 'rgb(0,255,0)',
                    'backgroundColorFromHover' => 'rgba(255,0,255,0.5)',
                ],
                'tabDesignBlockModel'       => [
                    'marginTop'                => 10,
                    'borderBottomWidth'        => 7,
                    'borderColorHover'         => 'rgb(0,255,0)',
                    'backgroundColorFromHover' => 'rgba(255,0,255,0.5)',
                ],
                'tabDesignTextModel'        => [
                    'size' => 20
                ],
                'contentDesignBlockModel'   => [
                    'marginTop'                => 10,
                    'borderBottomWidth'        => 7,
                    'borderColorHover'         => 'rgb(0,255,0)',
                    'backgroundColorFromHover' => 'rgba(255,0,255,0.5)',
                ],
            ],
            'textModel'       => [
                'designTextModel'  => [
                    'size' => 10
                ],
                'designBlockModel' => [
                    'marginTop'                => 10,
                    'borderBottomWidth'        => 7,
                    'borderColorHover'         => 'rgb(0,255,0)',
                    'backgroundColorFromHover' => 'rgba(255,0,255,0.5)',
                ],
                'type'             => 1,
                'hasEditor'        => false,
            ],
            'isShowEmpty'     => true,
            'isLazyLoad'      => true,
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
            'designTabsModel' => [
                'containerDesignBlockModel' => [
                    'marginTop'                => 20,
                    'borderBottomWidth'        => 70,
                    'borderColorHover'         => 'rgb(255,255,0)',
                    'backgroundColorFromHover' => 'rgba(0,0,255,0.5)',
                ],
                'tabDesignBlockModel'       => [
                    'marginTop'                => 20,
                    'borderBottomWidth'        => 70,
                    'borderColorHover'         => 'rgb(255,255,0)',
                    'backgroundColorFromHover' => 'rgba(0,0,255,0.5)',
                ],
                'tabDesignTextModel'        => [
                    'size' => 30
                ],
                'contentDesignBlockModel'   => [
                    'marginTop'                => 20,
                    'borderBottomWidth'        => 70,
                    'borderColorHover'         => 'rgb(255,255,0)',
                    'backgroundColorFromHover' => 'rgba(0,0,255,0.5)',
                ],
            ],
            'textModel'       => [
                'designTextModel'  => [
                    'size' => 30
                ],
                'designBlockModel' => [
                    'marginTop'                => 20,
                    'borderBottomWidth'        => 70,
                    'borderColorHover'         => 'rgb(255,255,0)',
                    'backgroundColorFromHover' => 'rgba(0,0,255,0.5)',
                ],
                'type'             => 0,
                'hasEditor'        => false,
            ],
            'isShowEmpty'     => false,
            'isLazyLoad'      => false,
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
            'designTabsModel' => [
                'containerDesignBlockModel' => [
                    'marginTop'                => 20,
                    'borderBottomWidth'        => 70,
                    'borderColorHover'         => 'rgb(255,255,0)',
                    'backgroundColorFromHover' => 'rgba(0,0,255,0.5)',
                ],
                'tabDesignBlockModel'       => [
                    'marginTop'                => 20,
                    'borderBottomWidth'        => 70,
                    'borderColorHover'         => 'rgb(255,255,0)',
                    'backgroundColorFromHover' => 'rgba(0,0,255,0.5)',
                ],
                'tabDesignTextModel'        => [
                    'size' => 30
                ],
                'contentDesignBlockModel'   => [
                    'marginTop'                => 20,
                    'borderBottomWidth'        => 70,
                    'borderColorHover'         => 'rgb(255,255,0)',
                    'backgroundColorFromHover' => 'rgba(0,0,255,0.5)',
                ],
            ],
            'textModel'       => [
                'designTextModel'  => [
                    'size' => 30
                ],
                'designBlockModel' => [
                    'marginTop'                => 20,
                    'borderBottomWidth'        => 70,
                    'borderColorHover'         => 'rgb(255,255,0)',
                    'backgroundColorFromHover' => 'rgba(0,0,255,0.5)',
                ],
                'type'             => 0,
                'hasEditor'        => false,
            ],
            'isShowEmpty'     => false,
            'isLazyLoad'      => false,
        ];
    }
}
