<?php

// @codingStandardsIgnoreLine
namespace ss\tests\phpunit\models\blocks\helpers\field\_base\AbstractFieldModel;

use ss\models\blocks\helpers\field\FieldModel;
use ss\tests\phpunit\models\_abstract\_base\AbstractDuplicateModelTest;

/**
 * Tests for the model AbstractFieldModel
 */
class AbstractFieldModelDuplicateTest extends AbstractDuplicateModelTest
{

    /**
     * Gets model name
     *
     * @return FieldModel
     */
    protected function getNewModel()
    {
        return new FieldModel();
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
                'designFieldModel' => [
                    'shortCardContainerDesignBlockModel' => [
                        'marginTop' => 10
                    ],
                    'shortCardLabelDesignBlockModel'     => [
                        'marginTop' => 20
                    ],
                    'shortCardLabelDesignTextModel'      => [
                        'size' => 30
                    ],
                    'shortCardValueDesignBlockModel'     => [
                        'marginTop' => 40
                    ],
                ],
            ],
            [
                'designFieldModel' => [
                    'shortCardContainerDesignBlockModel' => [
                        'marginTop' => 10
                    ],
                    'shortCardLabelDesignBlockModel'     => [
                        'marginTop' => 20
                    ],
                    'shortCardLabelDesignTextModel'      => [
                        'size' => 30
                    ],
                    'shortCardValueDesignBlockModel'     => [
                        'marginTop' => 40
                    ],
                ],
            ]
        );
    }
}
