<?php

// @codingStandardsIgnoreLine
namespace testS\tests\unit\models\blocks\helpers\field\_base\AbstractFieldGroupModel;

use testS\models\blocks\helpers\field\FieldGroupModel;
use testS\tests\unit\models\_abstract\_base\AbstractDuplicateModelTest;

/**
 * Tests for the model AbstractFieldGroupModel
 */
class AbstractFieldGroupModelDuplicateTest extends AbstractDuplicateModelTest
{

    /**
     * Gets model name
     *
     * @return FieldGroupModel
     */
    protected function getNewModel()
    {
        return new FieldGroupModel();
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
                'fieldId' => 1,
            ],
            [
                'fieldId' => 1,
            ]
        );
    }
}
