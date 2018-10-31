<?php

namespace ss\tests\phpunit\models\blocks\siteMap\_base\AbstractSiteMapModel;

use ss\models\blocks\siteMap\SiteMapModel;
use ss\tests\phpunit\models\_abstract\_base\AbstractDuplicateModelTest;

/**
 * Tests for the model SiteMapModel
 */
class AbstractSiteMapModelDuplicateTest extends AbstractDuplicateModelTest
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
     * Data provider for CRUD. Duplicate
     *
     * @return void
     */
    public function testDuplicate()
    {
        $this->duplicate(
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
            ]
        );
    }
}
