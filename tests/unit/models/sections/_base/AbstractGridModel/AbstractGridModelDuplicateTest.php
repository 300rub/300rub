<?php

namespace ss\tests\unit\models\sections\_base\AbstractGridModel;

use ss\models\sections\GridModel;
use ss\tests\unit\models\_abstract\_base\AbstractDuplicateModelTest;

/**
 * Tests for the model GridModel
 */
class AbstractGridModelDuplicateTest extends AbstractDuplicateModelTest
{

    /**
     * Gets model name
     *
     * @return GridModel
     */
    protected function getNewModel()
    {
        return new GridModel();
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
                'blockId'    => 1,
                'gridLineId' => 1,
                'x'          => 4,
                'y'          => 1,
                'width'      => 6,
            ],
            [
                'blockId'    => 1,
                'gridLineId' => 1,
                'x'          => 4,
                'y'          => 1,
                'width'      => 6,
            ]
        );
    }
}
