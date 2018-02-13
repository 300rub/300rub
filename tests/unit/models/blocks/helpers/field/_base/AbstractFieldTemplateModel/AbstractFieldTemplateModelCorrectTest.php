<?php

// @codingStandardsIgnoreLine
namespace ss\tests\unit\models\blocks\helpers\field\_base\AbstractFieldTemplateModel;

use ss\models\blocks\helpers\field\FieldTemplateModel;
use ss\tests\unit\models\_abstract\_base\AbstractCorrectModelTest;

/**
 * Tests for the model AbstractFieldTemplateModel
 */
class AbstractFieldTemplateModelCorrectTest extends AbstractCorrectModelTest
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
     * Data provider for CRUD. Correct values
     *
     * @return array
     */
    protected function getDataProviderCorrect()
    {
        return [
            'correct1' => [
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
                ],
                [
                    'fieldId'            => 1,
                    'sort'               => 20,
                    'label'              => 'New Label',
                    'type'               => 0,
                    'validationType'     => 0,
                    'isHideForShortCard' => false,
                    'isShowEmpty'        => false,
                ],
                [
                    'fieldId'            => 1,
                    'sort'               => 20,
                    'label'              => 'New Label',
                    'type'               => 0,
                    'validationType'     => 0,
                    'isHideForShortCard' => false,
                    'isShowEmpty'        => false,
                ],
            ]
        ];
    }
}
