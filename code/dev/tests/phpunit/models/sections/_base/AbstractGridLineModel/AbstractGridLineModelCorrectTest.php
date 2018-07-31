<?php

namespace ss\tests\phpunit\models\sections\_base\AbstractGridLineModel;

use ss\models\sections\GridLineModel;
use ss\tests\phpunit\models\_abstract\_base\AbstractCorrectModelTest;

/**
 * Tests for the model GridLineModel
 */
class AbstractGridLineModelCorrectTest extends AbstractCorrectModelTest
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
     * Data provider for CRUD. Correct values
     *
     * @return array
     */
    protected function getDataProviderCorrect()
    {
        return [
            'correct1' => [
                [
                    'sectionId'          => 1,
                    'outsideDesignModel' => [
                        'marginTop' => 10
                    ],
                    'insideDesignModel'  => [
                        'marginTop' => 20
                    ],
                    'sort'               => 30,
                ],
                [
                    'sectionId'          => 1,
                    'outsideDesignModel' => [
                        'marginTop' => 10
                    ],
                    'insideDesignModel'  => [
                        'marginTop' => 20
                    ],
                    'sort'               => 30,
                ],
                [
                    'sectionId'          => 1,
                    'outsideDesignModel' => [
                        'marginTop' => 50
                    ],
                    'insideDesignModel'  => [
                        'marginTop' => 60
                    ],
                    'sort'               => 70,
                ],
                [
                    'sectionId'          => 1,
                    'outsideDesignModel' => [
                        'marginTop' => 50
                    ],
                    'insideDesignModel'  => [
                        'marginTop' => 60
                    ],
                    'sort'               => 70,
                ]
            ]
        ];
    }
}
