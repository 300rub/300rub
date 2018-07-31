<?php

// @codingStandardsIgnoreLine
namespace ss\tests\phpunit\models\blocks\helpers\field\_base\AbstractFieldTemplateModel;

use ss\models\blocks\helpers\field\FieldTemplateModel;
use ss\tests\phpunit\models\_abstract\_base\AbstractEmptyModelTest;

/**
 * Tests for the model AbstractFieldTemplateModel
 */
class AbstractFieldTemplateModelEmptyTest extends AbstractEmptyModelTest
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
     * Data provider for CRUD. Empty values
     *
     * @return array
     */
    protected function getDataProviderEmpty()
    {
        return [
            'empty1' => [
                [
                    'label' => 'label',
                ],
                [],
                [],
                [],
                self::EXCEPTION_MODEL
            ],
            'empty2' => [
                [],
                [
                    'label' => ['required']
                ],
            ],
            'empty3' => [
                [
                    'fieldId'            => 1,
                    'sort'               => '',
                    'label'              => 'label',
                    'type'               => '',
                    'validationType'     => '',
                    'isHideForShortCard' => '',
                    'isShowEmpty'        => '',
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
                [
                    'fieldId'            => 1,
                    'sort'               => null,
                    'label'              => 'label',
                    'type'               => null,
                    'validationType'     => null,
                    'isHideForShortCard' => null,
                    'isShowEmpty'        => null,
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
