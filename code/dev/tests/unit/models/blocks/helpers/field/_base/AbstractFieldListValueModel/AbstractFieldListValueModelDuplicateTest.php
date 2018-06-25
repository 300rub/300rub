<?php

// @codingStandardsIgnoreLine
namespace ss\tests\unit\models\blocks\helpers\field\_base\AbstractFieldListValueModel;

use ss\models\blocks\helpers\field\FieldListValueModel;
use ss\tests\unit\models\_abstract\_base\AbstractDuplicateModelTest;

/**
 * Tests for the model AbstractFieldListValueModel
 */
// @codingStandardsIgnoreLine
class AbstractFieldListValueModelDuplicateTest extends AbstractDuplicateModelTest
{

    /**
     * Gets model name
     *
     * @return FieldListValueModel
     */
    protected function getNewModel()
    {
        return new FieldListValueModel();
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
                'fieldTemplateId' => 1,
                'value'           => 'Value 1',
                'sort'            => 10,
                'isChecked'       => true,
            ],
            [
                'fieldTemplateId' => 1,
                'value'           => 'Value 1',
                'sort'            => 10,
                'isChecked'       => true,
            ]
        );
    }
}
