<?php

// @codingStandardsIgnoreLine
namespace testS\tests\unit\models\blocks\helpers\field\_base\AbstractFieldTemplateModel;

use testS\models\blocks\helpers\field\FieldTemplateModel;
use testS\tests\unit\models\_abstract\_base\AbstractIncorrectModelTest;

/**
 * Tests for the model AbstractFieldTemplateModel
 */
class AbstractFieldTemplateModelIncorrectTest extends AbstractIncorrectModelTest
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
     * Data provider for CRUD. Incorrect values
     *
     * @return array
     */
    protected function getDataProviderIncorrect()
    {
        return [
            'incorrect1' => [
                [
                    'fieldId' => 9999,
                    'label'   => 111,
                ],
                [],
                [],
                [],
                self::EXCEPTION_MODEL
            ],
            'incorrect2' => [
                [
                    'fieldId'            => ' 1 ',
                    'sort'               => ' 10a ',
                    'label'              => 111,
                    'type'               => 999,
                    'validationType'     => 999,
                    'isHideForShortCard' => 999,
                    'isShowEmpty'        => 999,
                ],
                [
                    'fieldId'            => 1,
                    'sort'               => 10,
                    'label'              => '111',
                    'type'               => 0,
                    'validationType'     => 0,
                    'isHideForShortCard' => true,
                    'isShowEmpty'        => true,
                ],
                [
                    'fieldId'            => ' 1',
                    'sort'               => 'incorrect',
                    'label'              => 'label',
                    'type'               => 'incorrect',
                    'validationType'     => 'incorrect',
                    'isHideForShortCard' => 0,
                    'isShowEmpty'        => 0,
                ],
                [
                    'fieldId'            => 1,
                    'sort'               => 0,
                    'label'              => 'label',
                    'type'               => 0,
                    'validationType'     => 0,
                    'isHideForShortCard' => false,
                    'isShowEmpty'        => false,
                ],
            ]
        ];
    }
}
