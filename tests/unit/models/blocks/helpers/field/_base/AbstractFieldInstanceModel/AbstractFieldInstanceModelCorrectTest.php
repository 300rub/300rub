<?php

// @codingStandardsIgnoreLine
namespace ss\tests\unit\models\blocks\helpers\field\_base\AbstractFieldInstanceModel;

use ss\models\blocks\helpers\field\FieldInstanceModel;
use ss\tests\unit\models\_abstract\_base\AbstractCorrectModelTest;

/**
 * Tests for the model AbstractFieldInstanceModel
 */
class AbstractFieldInstanceModelCorrectTest extends AbstractCorrectModelTest
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
     * Data provider for CRUD. Correct values
     *
     * @return array
     */
    protected function getDataProviderCorrect()
    {
        return [
            'correct1' => [
                [
                    'fieldGroupId'    => 1,
                    'fieldTemplateId' => 1,
                    'value'           => 'Value 1',
                ],
                [
                    'fieldGroupId'    => 1,
                    'fieldTemplateId' => 1,
                    'value'           => 'Value 1',
                ],
                [
                    'fieldGroupId'    => 1,
                    'fieldTemplateId' => 2,
                    'value'           => 'Value 2',
                ],
                [
                    'fieldGroupId'    => 1,
                    'fieldTemplateId' => 2,
                    'value'           => 'Value 2',
                ],
            ]
        ];
    }
}
