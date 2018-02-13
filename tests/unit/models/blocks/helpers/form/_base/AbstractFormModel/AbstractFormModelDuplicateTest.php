<?php

namespace ss\tests\unit\models\blocks\helpers\form\_base\AbstractFormModel;

use ss\models\blocks\helpers\form\FormModel;
use ss\tests\unit\models\_abstract\_base\AbstractDuplicateModelTest;

/**
 * Tests for the model AbstractFormModel
 */
class AbstractFormModelDuplicateTest extends AbstractDuplicateModelTest
{

    /**
     * Gets model name
     *
     * @return FormModel
     */
    protected function getNewModel()
    {
        return new FormModel();
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
                'designFormModel' => [
                    'containerDesignBlockModel' => [
                        'marginTop' => 400
                    ],
                    'lineDesignBlockModel'      => [
                        'marginTop' => 500
                    ],
                    'submitIcon'                => 'fa-lock',
                    'submitIconPosition'        => 1,
                    'submitAlignment'           => 1
                ],
                'hasLabel'        => true,
                'successText'     => 'Thanks!'
            ],
            [
                'designFormModel' => [
                    'containerDesignBlockModel' => [
                        'marginTop' => 400
                    ],
                    'lineDesignBlockModel'      => [
                        'marginTop' => 500
                    ],
                    'submitIcon'                => 'fa-lock',
                    'submitIconPosition'        => 1,
                    'submitAlignment'           => 1
                ],
                'hasLabel'        => true,
                'successText'     => 'Thanks!'
            ]
        );
    }
}
