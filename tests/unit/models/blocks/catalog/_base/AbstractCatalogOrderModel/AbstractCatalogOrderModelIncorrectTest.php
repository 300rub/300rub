<?php

// @codingStandardsIgnoreLine
namespace testS\tests\unit\models\blocks\catalog\_base\AbstractCatalogOrderModel;

use testS\models\blocks\catalog\CatalogOrderModel;
use testS\tests\unit\models\_abstract\_base\AbstractIncorrectModelTest;

/**
 * Tests for the model AbstractCatalogOrderModel
 */
class AbstractCatalogOrderModelIncorrectTest extends AbstractIncorrectModelTest
{

    /**
     * Gets model name
     *
     * @return CatalogOrderModel
     */
    protected function getNewModel()
    {
        return new CatalogOrderModel();
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
                    'catalogBinId' => 'incorrect',
                    'formId'       => 'incorrect',
                    'email'        => 'incorrect',
                ],
                [
                    'email' => ['email']
                ],
            ],
            'incorrect2' => [
                [
                    'catalogBinId' => ' 1 s',
                    'formId'       => ' 1 s',
                    'email'        => '   email@email.com   ',
                ],
                [
                    'catalogBinId' => 1,
                    'formId'       => 1,
                    'email'        => 'email@email.com',
                ],
                [
                    'catalogBinId' => 3,
                    'formId'       => 3,
                    'email'        => 'email2@email.com',
                ],
                [
                    'catalogBinId' => 1,
                    'formId'       => 1,
                    'email'        => 'email2@email.com',
                ],
            ],
            'incorrect3' => [
                [
                    'catalogBinId' => 999,
                    'formId'       => 999,
                    'email'        => 'email2@email.com',
                ],
                [],
                null,
                null,
                self::EXCEPTION_MODEL
            ],
        ];
    }
}
