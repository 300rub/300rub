<?php

// @codingStandardsIgnoreLine
namespace ss\tests\phpunit\models\blocks\helpers\tab\_base\AbstractTabTemplateModel;

use ss\models\blocks\helpers\tab\TabTemplateModel;
use ss\tests\phpunit\models\_abstract\_base\AbstractIncorrectModelTest;

/**
 * Tests for the model AbstractTabTemplateModel
 */
class AbstractTabTemplateModelIncorrectTest extends AbstractIncorrectModelTest
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
                    'sort' => ' 40 asda',
                    'label' => 123
                ],
                [
                    'tabId' => 1,
                    'sort'  => 40,
                    'label' => '123',
                ],
                [
                    'label' => $this->generateStringWithLength(256),
                ],
                [
                    'label' => ['maxLength']
                ]
            ],
            'incorrect5' => [
                [
                    'tabId' => 1,
                    'label' => '<b> aaa </b>'
                ],
                [
                    'tabId' => 1,
                    'sort'  => 0,
                    'label' => 'aaa',
                ],
                [
                    'label' => '<strong> bbb <'
                ],
                [
                    'tabId' => 1,
                    'sort'  => 0,
                    'label' => 'bbb',
                ],
            ]
        ];
    }
}
