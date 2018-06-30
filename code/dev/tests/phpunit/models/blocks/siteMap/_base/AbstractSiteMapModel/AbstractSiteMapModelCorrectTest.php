<?php

namespace ss\tests\unit\models\blocks\siteMap\_base\AbstractSiteMapModel;

use ss\models\blocks\siteMap\SiteMapModel;
use ss\tests\unit\models\_abstract\_base\AbstractCorrectModelTest;

/**
 * Tests for the model SiteMapModel
 */
class AbstractSiteMapModelCorrectTest extends AbstractCorrectModelTest
{

    /**
     * Gets model name
     *
     * @return SiteMapModel
     */
    protected function getNewModel()
    {
        return new SiteMapModel();
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
                [
                    'containerDesignBlockModel' => [
                        'marginTop'                => 10,
                        'borderBottomWidth'        => 7,
                        'borderColorHover'         => 'rgb(0,255,0)',
                        'backgroundColorFromHover' => 'rgba(255,0,255,0.5)',
                    ],
                    'itemDesignBlockModel'      => [
                        'marginTop'                => 10,
                        'borderBottomWidth'        => 7,
                        'borderColorHover'         => 'rgb(0,255,0)',
                        'backgroundColorFromHover' => 'rgba(255,0,255,0.5)',
                    ],
                    'itemDesignTextModel'       => [
                        'size' => 20
                    ],
                    'style'                     => 1
                ],
                [
                    'containerDesignBlockModel' => [
                        'marginTop'                => 10,
                        'borderBottomWidth'        => 7,
                        'borderColorHover'         => 'rgb(0,255,0)',
                        'backgroundColorFromHover' => 'rgba(255,0,255,0.5)',
                    ],
                    'itemDesignBlockModel'      => [
                        'marginTop'                => 10,
                        'borderBottomWidth'        => 7,
                        'borderColorHover'         => 'rgb(0,255,0)',
                        'backgroundColorFromHover' => 'rgba(255,0,255,0.5)',
                    ],
                    'itemDesignTextModel'       => [
                        'size' => 20
                    ],
                    'style'                     => 1
                ],
                [
                    'containerDesignBlockModel' => [
                        'marginTop'                => 5,
                        'borderBottomWidth'        => 4,
                        'borderColorHover'         => 'rgb(255,0,0)',
                        'backgroundColorFromHover' => 'rgba(0,0,255,0.7)',
                    ],
                    'itemDesignBlockModel'      => [
                        'marginTop'                => 5,
                        'borderBottomWidth'        => 4,
                        'borderColorHover'         => 'rgb(255,0,0)',
                        'backgroundColorFromHover' => 'rgba(0,0,255,0.7)',
                    ],
                    'itemDesignTextModel'       => [
                        'size' => 30
                    ],
                    'style'                     => 0
                ],
                [
                    'containerDesignBlockModel' => [
                        'marginTop'                => 5,
                        'borderBottomWidth'        => 4,
                        'borderColorHover'         => 'rgb(255,0,0)',
                        'backgroundColorFromHover' => 'rgba(0,0,255,0.7)',
                    ],
                    'itemDesignBlockModel'      => [
                        'marginTop'                => 5,
                        'borderBottomWidth'        => 4,
                        'borderColorHover'         => 'rgb(255,0,0)',
                        'backgroundColorFromHover' => 'rgba(0,0,255,0.7)',
                    ],
                    'itemDesignTextModel'       => [
                        'size' => 30
                    ],
                    'style'                     => 0
                ],
            ],
        ];
    }
}
