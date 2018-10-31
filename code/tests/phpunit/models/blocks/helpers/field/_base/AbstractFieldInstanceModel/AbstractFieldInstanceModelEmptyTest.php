<?php

// @codingStandardsIgnoreLine
namespace ss\tests\phpunit\models\blocks\helpers\field\_base\AbstractFieldInstanceModel;

use ss\models\blocks\helpers\field\FieldInstanceModel;
use ss\tests\phpunit\models\_abstract\_base\AbstractEmptyModelTest;

/**
 * Tests for the model AbstractFieldInstanceModel
 */
class AbstractFieldInstanceModelEmptyTest extends AbstractEmptyModelTest
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
                [],
                [],
                self::EXCEPTION_MODEL
            ],
            'empty2' => [
                [
                    'fieldGroupId'    => '',
                    'fieldTemplateId' => '',
                    'value'           => '',
                ],
                [],
                [],
                [],
                self::EXCEPTION_MODEL
            ],
            'empty3' => [
                [
                    'fieldGroupId'    => 1,
                    'fieldTemplateId' => '',
                    'value'           => '',
                ],
                [],
                [],
                [],
                self::EXCEPTION_MODEL
            ],
            'empty4' => [
                [
                    'fieldGroupId'    => '',
                    'fieldTemplateId' => 1,
                    'value'           => '',
                ],
                [],
                [],
                [],
                self::EXCEPTION_MODEL
            ],
            'empty5' => [
                [
                    'fieldGroupId'    => 1,
                    'fieldTemplateId' => 1,
                    'value'           => '',
                ],
                [
                    'fieldGroupId'    => 1,
                    'fieldTemplateId' => 1,
                    'value'           => '',
                ],
                [
                    'fieldGroupId'    => 1,
                    'fieldTemplateId' => 1,
                    'value'           => null,
                ],
                [
                    'fieldGroupId'    => 1,
                    'fieldTemplateId' => 1,
                    'value'           => '',
                ],
            ],
        ];
    }
}
