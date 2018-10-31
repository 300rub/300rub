<?php

// @codingStandardsIgnoreLine
namespace ss\tests\phpunit\models\blocks\helpers\tab\_base\AbstractTabInstanceModel;

use ss\models\blocks\helpers\tab\TabInstanceModel;
use ss\tests\phpunit\models\_abstract\_base\AbstractEmptyModelTest;

/**
 * Tests for the model AbstractTabInstanceModel
 */
class AbstractTabInstanceModelEmptyTest extends AbstractEmptyModelTest
{

    /**
     * Gets model name
     *
     * @return TabInstanceModel
     */
    protected function getNewModel()
    {
        return new TabInstanceModel();
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
                    'tabGroupId'     => '',
                    'textInstanceId' => '',
                    'tabTemplateId'  => '',
                ],
                [],
                null,
                null,
                self::EXCEPTION_MODEL
            ],
            'empty3' => [
                [
                    'tabGroupId'     => null,
                    'textInstanceId' => null,
                    'tabTemplateId'  => null,
                ],
                [],
                null,
                null,
                self::EXCEPTION_MODEL
            ],
            'empty4' => [
                [
                    'tabGroupId' => 1,
                ],
                [],
                null,
                null,
                self::EXCEPTION_MODEL
            ],
            'empty5' => [
                [
                    'tabTemplateId' => 1,
                ],
                [],
                null,
                null,
                self::EXCEPTION_MODEL
            ],
            'empty6' => [
                [
                    'tabGroupId'    => 1,
                    'tabTemplateId' => 1,
                ],
                [],
                null,
                null,
                self::EXCEPTION_MODEL
            ],
            'empty7' => [
                [
                    'tabGroupId'        => 1,
                    'tabTemplateId'     => 1,
                    'textInstanceModel' => [
                        'textId' => '',
                        'text'   => '',
                    ],
                ],
                [],
                null,
                null,
                self::EXCEPTION_MODEL
            ]
        ];
    }
}
