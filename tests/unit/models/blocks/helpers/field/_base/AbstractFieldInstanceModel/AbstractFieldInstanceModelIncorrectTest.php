<?php

// @codingStandardsIgnoreLine
namespace testS\tests\unit\models\blocks\helpers\field\_base\AbstractFieldInstanceModel;

use testS\models\blocks\helpers\field\FieldInstanceModel;
use testS\tests\unit\models\_abstract\_base\AbstractIncorrectModelTest;

/**
 * Tests for the model AbstractFieldInstanceModel
 */
class AbstractFieldInstanceModelIncorrectTest extends AbstractIncorrectModelTest
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
     * Data provider for CRUD. Incorrect values
     *
     * @return array
     */
    protected function getDataProviderIncorrect()
    {
        return [
            'incorrect1' => [
                [
                    'fieldGroupId'    => 'incorrect',
                    'fieldTemplateId' => 'incorrect',
                    'value'           => null,
                ],
                [],
                [],
                [],
                self::EXCEPTION_MODEL
            ],
            'incorrect2' => [
                [
                    'fieldGroupId'    => ' 1',
                    'fieldTemplateId' => ' 1',
                    'value'           => null,
                ],
                [
                    'fieldGroupId'    => 1,
                    'fieldTemplateId' => 1,
                    'value'           => '',
                ],
                [
                    'value'           => 123,
                ],
                [
                    'fieldGroupId'    => 1,
                    'fieldTemplateId' => 1,
                    'value'           => '123',
                ],
            ],
            'incorrect3' => [
                [
                    'fieldGroupId'    => ' 1asd',
                    'fieldTemplateId' => ' 1das',
                    'value'           => '<b>123<',
                ],
                [
                    'fieldGroupId'    => 1,
                    'fieldTemplateId' => 1,
                    'value'           => '123',
                ],
                [
                    'value'           => $this->generateStringWithLength(256),
                ],
                [
                    'value'    => ['maxLength']
                ],
            ],
        ];
    }
}
