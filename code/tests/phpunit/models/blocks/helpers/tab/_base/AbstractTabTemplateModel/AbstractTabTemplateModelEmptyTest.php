<?php

// @codingStandardsIgnoreLine
namespace ss\tests\phpunit\models\blocks\helpers\tab\_base\AbstractTabTemplateModel;

use ss\models\blocks\helpers\tab\TabTemplateModel;
use ss\tests\phpunit\models\_abstract\_base\AbstractEmptyModelTest;

/**
 * Tests for the model AbstractTabTemplateModel
 */
class AbstractTabTemplateModelEmptyTest extends AbstractEmptyModelTest
{

    /**
     * Gets model name
     *
     * @return TabTemplateModel
     */
    protected function getNewModel()
    {
        return new TabTemplateModel();
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
                    'tabId' => '',
                    'sort'  => '',
                    'label' => '',
                ],
                [],
                null,
                null,
                self::EXCEPTION_MODEL
            ],
            'empty3' => [
                [
                    'tabId' => null,
                    'sort'  => null,
                    'label' => null,
                ],
                [],
                null,
                null,
                self::EXCEPTION_MODEL
            ],
            'empty4' => [
                [
                    'tabId' => 1,
                ],
                [
                    'tabId' => 1,
                    'sort'  => 0,
                    'label' => '',
                ],
            ]
        ];
    }
}
