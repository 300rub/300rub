<?php

// @codingStandardsIgnoreLine
namespace testS\tests\unit\models\blocks\helpers\tab\_base\AbstractTabGroupModel;

use testS\models\blocks\helpers\tab\TabGroupModel;
use testS\tests\unit\models\_abstract\_base\AbstractDuplicateModelTest;

/**
 * Tests for the model AbstractTabGroupModel
 */
class AbstractTabGroupModelDuplicateTest extends AbstractDuplicateModelTest
{

    /**
     * Gets model name
     *
     * @return TabGroupModel
     */
    protected function getNewModel()
    {
        return new TabGroupModel();
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
                'tabId' => 1,
            ],
            [
                'tabId' => 1,
            ]
        );
    }
}
