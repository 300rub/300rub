<?php

// @codingStandardsIgnoreLine
namespace ss\tests\phpunit\models\blocks\helpers\tab\_base\AbstractTabGroupModel;

use ss\models\blocks\helpers\tab\TabGroupModel;
use ss\tests\phpunit\models\_abstract\_base\AbstractIncorrectModelTest;

/**
 * Tests for the model AbstractTabGroupModel
 */
class AbstractTabGroupModelIncorrectTest extends AbstractIncorrectModelTest
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
     * Data provider for CRUD. Incorrect values
     *
     * @return array
     */
    protected function getDataProviderIncorrect()
    {
        return [
            'incorrect1' => [
                [
                    'tabId' => 'incorrect',
                ],
                [],
                null,
                null,
                self::EXCEPTION_MODEL
            ],
            'incorrect2' => [
                [
                    'tabId' => 999,
                ],
                [],
                null,
                null,
                self::EXCEPTION_MODEL
            ],
            'incorrect3' => [
                [
                    'tabId' => -1,
                ],
                [],
                null,
                null,
                self::EXCEPTION_MODEL
            ],
            'incorrect4' => [
                [
                    'tabId' => '  1 gf',
                ],
                [
                    'tabId' => 1,
                ],
            ],
        ];
    }
}
