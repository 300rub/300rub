<?php

// @codingStandardsIgnoreLine
namespace ss\tests\phpunit\models\blocks\helpers\field\_base\AbstractFieldListValueModel;

use ss\models\blocks\helpers\field\FieldListValueModel;
use ss\tests\phpunit\models\_abstract\_base\AbstractIncorrectModelTest;

/**
 * Tests for the model AbstractFieldListValueModel
 */
// @codingStandardsIgnoreLine
class AbstractFieldListValueModelIncorrectTest extends AbstractIncorrectModelTest
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
     * Data provider for CRUD. Incorrect values
     *
     * @return array
     */
    protected function getDataProviderIncorrect()
    {
        return [
            'incorrect1' => [
                [
                    'fieldTemplateId' => 'incorrect',
                    'value'           => 123,
                    'sort'            => 'incorrect',
                    'isChecked'       => 'incorrect',
                ],
                [],
                [],
                [],
                self::EXCEPTION_MODEL
            ],
            'incorrect2' => [
                [
                    'fieldTemplateId' => ' 1 ',
                    'value'           => 123,
                    'sort'            => 'bla',
                    'isChecked'       => 'bla',
                ],
                [
                    'fieldTemplateId' => 1,
                    'value'           => '123',
                    'sort'            => 0,
                    'isChecked'       => false,
                ],
                [
                    'fieldTemplateId' => ' 2asd ',
                    'value'           => 3231,
                    'sort'            => ' 10 7',
                    'isChecked'       => '55',
                ],
                [
                    'fieldTemplateId' => 2,
                    'value'           => '3231',
                    'sort'            => 10,
                    'isChecked'       => false,
                ],
            ],
            'incorrect3' => [
                [
                    'fieldTemplateId' => 1,
                    'value'           => $this->generateStringWithLength(256),
                ],
                [
                    'value' => ['maxLength']
                ]
            ],
            'incorrect4' => [
                [
                    'fieldTemplateId' => 1,
                    'value'           => '<b> 123 </b> </'
                ],
                [
                    'fieldTemplateId' => 1,
                    'value'           => '123',
                    'sort'            => 0,
                    'isChecked'       => false,
                ]
            ]
        ];
    }
}
