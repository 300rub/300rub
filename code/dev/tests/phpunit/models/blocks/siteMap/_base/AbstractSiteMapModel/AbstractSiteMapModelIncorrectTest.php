<?php

namespace ss\tests\phpunit\models\blocks\siteMap\_base\AbstractSiteMapModel;

use ss\models\blocks\siteMap\SiteMapModel;
use ss\tests\phpunit\models\_abstract\_base\AbstractIncorrectModelTest;

/**
 * Tests for the model SiteMapModel
 */
class AbstractSiteMapModelIncorrectTest extends AbstractIncorrectModelTest
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
                    'itemDesignBlockModel'      => 'incorrect',
                    'itemDesignTextModel'       => 'incorrect',
                    'style'                     => 'incorrect',
                ],
                [
                    'containerDesignBlockModel' => [
                        'marginTop' => 0
                    ],
                    'itemDesignBlockModel'      => [
                        'marginTop' => 0
                    ],
                    'itemDesignTextModel'       => [
                        'size' => 0
                    ],
                    'style'                     => 0
                ],
                [
                    'style' => 999,
                ],
                [
                    'style' => 0,
                ],
            ],
            'incorrect2' => [
                [
                    'style' => ' 1 ',
                ],
                [
                    'style' => 1,
                ],
                [
                    'containerDesignBlockModel' => [
                        'marginTop' => ' 500 '
                    ],
                    'style'                     => true,
                ],
                [
                    'containerDesignBlockModel' => [
                        'marginTop' => 500
                    ],
                    'style'                     => 1,
                ],
            ],
            'incorrect3' => [
                [
                    'containerDesignBlockId' => 99999,
                ],
                [],
                [],
                [],
                self::EXCEPTION_MODEL
            ]
        ];
    }
}
