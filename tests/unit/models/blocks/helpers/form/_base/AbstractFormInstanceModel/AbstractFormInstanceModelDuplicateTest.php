<?php

// @codingStandardsIgnoreLine
namespace ss\tests\unit\models\blocks\helpers\form\_base\AbstractFormInstanceModel;

use ss\models\blocks\helpers\form\FormInstanceModel;
use ss\tests\unit\models\_abstract\_base\AbstractDuplicateModelTest;

/**
 * Tests for the model AbstractFormInstanceModel
 */
class AbstractFormInstanceModelDuplicateTest extends AbstractDuplicateModelTest
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
     * Data provider for CRUD. Duplicate
     *
     * @return void
     */
    public function testDuplicate()
    {
        $this->duplicate(
            [
                'formModel'      => [
                    'designFormModel' => [
                        'containerDesignBlockModel' => [
                            'marginTop' => 10
                        ],
                        'lineDesignBlockModel'      => [
                            'marginTop' => 10
                        ],
                        'submitIcon'                => 'fa-lock',
                        'submitIconPosition'        => 1,
                        'submitAlignment'           => 1
                    ],
                    'hasLabel'        => true,
                    'successText'     => 'Success'
                ],
                'sort'           => 10,
                'label'          => 'Label 1',
                'isRequired'     => true,
                'validationType' => 1,
                'type'           => 1,
            ],
            [
                'formModel'      => [
                    'designFormModel' => [
                        'containerDesignBlockModel' => [
                            'marginTop' => 10
                        ],
                        'lineDesignBlockModel'      => [
                            'marginTop' => 10
                        ],
                        'submitIcon'                => 'fa-lock',
                        'submitIconPosition'        => 1,
                        'submitAlignment'           => 1
                    ],
                    'hasLabel'        => true,
                    'successText'     => 'Success'
                ],
                'sort'           => 10,
                'label'          => 'Label 1',
                'isRequired'     => true,
                'validationType' => 1,
                'type'           => 1,
            ]
        );
    }
}
