<?php

// @codingStandardsIgnoreLine
namespace testS\tests\unit\models\blocks\helpers\form\_base\AbstractFormInstanceModel;

use testS\models\blocks\helpers\form\FormInstanceModel;
use testS\tests\unit\models\_abstract\_base\AbstractEmptyModelTest;

/**
 * Tests for the model AbstractFormInstanceModel
 */
class AbstractFormInstanceModelEmptyTest extends AbstractEmptyModelTest
{

    /**
     * Gets model name
     *
     * @return FormInstanceModel
     */
    protected function getNewModel()
    {
        return new FormInstanceModel();
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
                    'label' => ['required'],
                ]
            ],
            'empty2' => [
                [
                    'formModel'      => '',
                    'sort'           => '',
                    'label'          => '',
                    'isRequired'     => '',
                    'validationType' => '',
                    'type'           => '',
                ],
                [
                    'label' => ['required'],
                ]
            ],
            'empty3' => [
                [
                    'formModel'      => '',
                    'sort'           => '',
                    'label'          => 'Label',
                    'isRequired'     => '',
                    'validationType' => '',
                    'type'           => '',
                ],
                [
                    'formModel'      => [
                        'designFormModel' => [
                            'containerDesignBlockModel' => [
                                'marginTop' => 0
                            ],
                            'lineDesignBlockModel'      => [
                                'marginTop' => 0
                            ],
                            'submitIcon'                => '',
                            'submitIconPosition'        => 0,
                            'submitAlignment'           => 0
                        ],
                        'hasLabel'        => false,
                        'successText'     => ''
                    ],
                    'sort'           => 0,
                    'label'          => 'Label',
                    'isRequired'     => false,
                    'validationType' => 0,
                    'type'           => 0,
                ]
            ]
        ];
    }
}
