<?php

// @codingStandardsIgnoreLine
namespace ss\tests\unit\models\blocks\helpers\field\_base\AbstractFieldListValueModel;

use ss\models\blocks\helpers\field\FieldListValueModel;
use ss\tests\unit\models\_abstract\_base\AbstractCorrectModelTest;

/**
 * Tests for the model AbstractFieldListValueModel
 */
class AbstractFieldListValueModelCorrectTest extends AbstractCorrectModelTest
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
     * Data provider for CRUD. Correct values
     *
     * @return array
     */
    protected function getDataProviderCorrect()
    {
        return [
            'correct1' => [
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
                ],
                [
                    'fieldTemplateId' => 2,
                    'value'           => 'Value 2',
                    'sort'            => 20,
                    'isChecked'       => false,
                ],
                [
                    'fieldTemplateId' => 2,
                    'value'           => 'Value 2',
                    'sort'            => 20,
                    'isChecked'       => false,
                ]
            ]
        ];
    }
}
