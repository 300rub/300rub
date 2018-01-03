<?php

// @codingStandardsIgnoreLine
namespace testS\tests\unit\models\blocks\helpers\field\_base\AbstractFieldGroupModel;

use testS\models\blocks\helpers\field\FieldGroupModel;
use testS\tests\unit\models\_abstract\_base\AbstractCorrectModelTest;

/**
 * Tests for the model AbstractFieldGroupModel
 */
class AbstractFieldGroupModelCorrectTest extends AbstractCorrectModelTest
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
     * Data provider for CRUD. Correct values
     *
     * @return array
     */
    protected function getDataProviderCorrect()
    {
        return [
            'correct1' => [
                [
                    'fieldId' => 1,
                ],
                [
                    'fieldId' => 1,
                ]
            ]
        ];
    }
}
