<?php

namespace testS\tests\unit\models\sections\_base\AbstractGridLineModel;

use testS\models\sections\GridLineModel;
use testS\tests\unit\models\_abstract\_base\AbstractDuplicateModelTest;

/**
 * Tests for the model GridLineModel
 */
class AbstractGridLineModelDuplicateTest extends AbstractDuplicateModelTest
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
     * Data provider for CRUD. Duplicate
     *
     * @return void
     */
    public function testDuplicate()
    {
        $this->duplicate(
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
            ]
        );
    }
}
