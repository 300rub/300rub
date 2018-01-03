<?php

// @codingStandardsIgnoreLine
namespace testS\tests\unit\models\blocks\helpers\field\_base\AbstractFieldGroupModel;

use testS\models\blocks\helpers\field\FieldGroupModel;
use testS\tests\unit\models\_abstract\_base\AbstractEmptyModelTest;

/**
 * Tests for the model AbstractFieldGroupModel
 */
class AbstractFieldGroupModelEmptyTest extends AbstractEmptyModelTest
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
     * Data provider for CRUD. Empty values
     *
     * @return array
     */
    protected function getDataProviderEmpty()
    {
        return [
            'empty1' => [
                [],
                [],
                null,
                null,
                self::EXCEPTION_MODEL
            ],
            'empty2' => [
                [
                    'fieldId' => '',
                ],
                [],
                null,
                null,
                self::EXCEPTION_MODEL
            ],
            'empty3' => [
                [
                    'fieldId' => null,
                ],
                [],
                null,
                null,
                self::EXCEPTION_MODEL
            ],
        ];
    }
}
