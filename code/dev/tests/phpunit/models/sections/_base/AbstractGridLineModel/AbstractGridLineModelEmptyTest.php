<?php

namespace ss\tests\unit\models\sections\_base\AbstractGridLineModel;

use ss\models\sections\GridLineModel;
use ss\tests\unit\models\_abstract\_base\AbstractEmptyModelTest;

/**
 * Tests for the model GridLineModel
 */
class AbstractGridLineModelEmptyTest extends AbstractEmptyModelTest
{

    /**
     * Gets model name
     *
     * @return GridLineModel
     */
    protected function getNewModel()
    {
        return new GridLineModel();
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
                [],
                [],
                [],
                self::EXCEPTION_MODEL
            ],
            'empty2' => [
                [
                    'sectionId'       => '',
                    'outsideDesignId' => '',
                    'insideDesignId'  => '',
                    'sort'            => '',
                ],
                [],
                [],
                [],
                self::EXCEPTION_MODEL
            ],
            'empty3' => [
                [
                    'sectionModel'       => '',
                    'outsideDesignModel' => '',
                    'insideDesignModel'  => '',
                    'sort'               => '',
                ],
                [],
                [],
                [],
                self::EXCEPTION_MODEL
            ],
            'empty4' => [
                [
                    'sectionId'          => 1,
                    'outsideDesignModel' => '',
                    'insideDesignModel'  => '',
                    'sort'               => '',
                ],
                [
                    'sectionId'          => 1,
                    'outsideDesignModel' => [
                        'marginTop' => 0
                    ],
                    'insideDesignModel'  => [
                        'marginTop' => 0
                    ],
                    'sort'               => 0,
                ],
                [
                    'sectionId'          => 1,
                    'outsideDesignModel' => [
                        'marginTop' => ' '
                    ],
                    'insideDesignModel'  => [
                        'marginTop' => ' '
                    ],
                    'sort'               => ' ',
                ],
                [
                    'sectionId'          => 1,
                    'outsideDesignModel' => [
                        'marginTop' => 0
                    ],
                    'insideDesignModel'  => [
                        'marginTop' => 0
                    ],
                    'sort'               => 0,
                ],
            ],
        ];
    }
}
