<?php

// @codingStandardsIgnoreLine
namespace testS\tests\unit\models\blocks\helpers\field\_base\AbstractFieldTemplateModel;

use testS\models\blocks\helpers\field\FieldTemplateModel;
use testS\tests\unit\models\_abstract\_base\AbstractDuplicateModelTest;

/**
 * Tests for the model AbstractFieldTemplateModel
 */
class AbstractFieldTemplateModelDuplicateTest extends AbstractDuplicateModelTest
{

    /**
     * Gets model name
     *
     * @return FieldTemplateModel
     */
    protected function getNewModel()
    {
        return new FieldTemplateModel();
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
                'fieldId'            => 1,
                'sort'               => 10,
                'label'              => 'Label',
                'type'               => 1,
                'validationType'     => 1,
                'isHideForShortCard' => true,
                'isShowEmpty'        => true,
            ],
            [
                'fieldId'            => 1,
                'sort'               => 10,
                'label'              => 'Label',
                'type'               => 1,
                'validationType'     => 1,
                'isHideForShortCard' => true,
                'isShowEmpty'        => true,
            ]
        );
    }
}
