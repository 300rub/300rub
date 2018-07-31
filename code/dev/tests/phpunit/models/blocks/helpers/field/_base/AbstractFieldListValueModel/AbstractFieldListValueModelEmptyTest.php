<?php

// @codingStandardsIgnoreLine
namespace ss\tests\phpunit\models\blocks\helpers\field\_base\AbstractFieldListValueModel;

use ss\models\blocks\helpers\field\FieldListValueModel;
use ss\tests\phpunit\models\_abstract\_base\AbstractEmptyModelTest;

/**
 * Tests for the model AbstractFieldListValueModel
 */
class AbstractFieldListValueModelEmptyTest extends AbstractEmptyModelTest
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
     * Data provider for CRUD. Empty values
     *
     * @return array
     */
    protected function getDataProviderEmpty()
    {
        return [
            'empty1' => [
                [],
                [
                    'value' => ['required']
                ],
            ],
            'empty2' => [
                [
                    'fieldTemplateId' => '',
                    'value'           => '',
                    'sort'            => '',
                    'isChecked'       => '',
                ],
                [
                    'value' => ['required']
                ],
            ],
            'empty3' => [
                [
                    'fieldTemplateId' => 1,
                    'value'           => '',
                    'sort'            => '',
                    'isChecked'       => '',
                ],
                [
                    'value' => ['required']
                ],
            ],
        ];
    }
}
