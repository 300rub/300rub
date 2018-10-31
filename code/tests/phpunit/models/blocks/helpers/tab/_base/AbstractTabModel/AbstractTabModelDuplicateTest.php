<?php

namespace ss\tests\phpunit\models\blocks\helpers\tab\_base\AbstractTabModel;

use ss\models\blocks\helpers\tab\TabModel;
use ss\tests\phpunit\models\_abstract\_base\AbstractDuplicateModelTest;

/**
 * Tests for the model AbstractTabModel
 */
class AbstractTabModelDuplicateTest extends AbstractDuplicateModelTest
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
     * Data provider for CRUD. Duplicate
     *
     * @return void
     */
    public function testDuplicate()
    {
        $this->duplicate(
            [
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
                    'hasEditor'        => true,
                ],
                'isShowEmpty'     => true,
                'isLazyLoad'      => true,
            ],
            [
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
                    'hasEditor'        => true,
                ],
                'isShowEmpty'     => true,
                'isLazyLoad'      => true,
            ]
        );
    }
}
