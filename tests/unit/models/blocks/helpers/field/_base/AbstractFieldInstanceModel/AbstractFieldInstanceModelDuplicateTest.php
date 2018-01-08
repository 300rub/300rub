<?php

// @codingStandardsIgnoreLine
namespace testS\tests\unit\models\blocks\helpers\field\_base\AbstractFieldInstanceModel;

use testS\models\blocks\helpers\field\FieldInstanceModel;
use testS\tests\unit\models\_abstract\_base\AbstractDuplicateModelTest;

/**
 * Tests for the model AbstractFieldInstanceModel
 */
class AbstractFieldInstanceModelDuplicateTest extends AbstractDuplicateModelTest
{

    /**
     * Gets model name
     *
     * @return FieldInstanceModel
     */
    protected function getNewModel()
    {
        return new FieldInstanceModel();
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
                'fieldGroupId'    => 1,
                'fieldTemplateId' => 1,
                'value'           => 'Value 1',
            ],
            [
                'fieldGroupId'    => 1,
                'fieldTemplateId' => 1,
                'value'           => 'Value 1',
            ]
        );
    }
}