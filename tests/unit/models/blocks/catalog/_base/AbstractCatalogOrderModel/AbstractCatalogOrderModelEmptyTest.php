<?php

// @codingStandardsIgnoreLine
namespace testS\tests\unit\models\blocks\catalog\_base\AbstractCatalogOrderModel;

use testS\models\blocks\catalog\CatalogOrderModel;
use testS\tests\unit\models\_abstract\_base\AbstractEmptyModelTest;

/**
 * Tests for the model AbstractCatalogOrderModel
 */
class AbstractCatalogOrderModelEmptyTest extends AbstractEmptyModelTest
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
     * Data provider for CRUD. Empty values
     *
     * @return array
     */
    protected function getDataProviderEmpty()
    {
        return [
            'empty1' => [
                [],
                [
                    'email' => ['email']
                ],
            ],
            'empty2' => [
                [
                    'catalogOrderId' => '',
                    'formId'       => '',
                    'email'        => '',
                ],
                [
                    'email' => ['email']
                ],
            ],
            'empty3' => [
                [
                    'email' => 'email@email.com',
                ],
                [],
                null,
                null,
                self::EXCEPTION_MODEL
            ]
        ];
    }
}
