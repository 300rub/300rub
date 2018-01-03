<?php

// @codingStandardsIgnoreLine
namespace testS\tests\unit\models\blocks\helpers\tab\_base\AbstractTabGroupModel;

use testS\models\blocks\helpers\tab\TabGroupModel;
use testS\tests\unit\models\_abstract\_base\AbstractEmptyModelTest;

/**
 * Tests for the model AbstractTabGroupModel
 */
class AbstractTabGroupModelEmptyTest extends AbstractEmptyModelTest
{

    /**
     * Gets model name
     *
     * @return TabGroupModel
     */
    protected function getNewModel()
    {
        return new TabGroupModel();
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
                ],
                [],
                null,
                null,
                self::EXCEPTION_MODEL
            ],
            'empty3' => [
                [
                    'tabId' => null,
                ],
                [],
                null,
                null,
                self::EXCEPTION_MODEL
            ],
        ];
    }
}
