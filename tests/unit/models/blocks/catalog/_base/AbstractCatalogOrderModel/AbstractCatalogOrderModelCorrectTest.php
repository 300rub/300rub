<?php

// @codingStandardsIgnoreLine
namespace testS\tests\unit\models\blocks\catalog\_base\AbstractCatalogOrderModel;

use testS\models\blocks\catalog\CatalogOrderModel;
use testS\tests\unit\models\_abstract\_base\AbstractCorrectModelTest;

/**
 * Tests for the model AbstractCatalogOrderModel
 */
class AbstractCatalogOrderModelCorrectTest extends AbstractCorrectModelTest
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
     * Data provider for CRUD. Correct values
     *
     * @return array
     */
    protected function getDataProviderCorrect()
    {
        return [
            'correct1' => [
                [
                    'catalogBinId' => 1,
                    'formId'       => 1,
                    'email'        => 'email@email.com',
                ],
                [
                    'catalogBinId' => 1,
                    'formId'       => 1,
                    'email'        => 'email@email.com',
                ],
                [
                    'email' => 'email2@email.com',
                ],
                [
                    'catalogBinId' => 1,
                    'formId'       => 1,
                    'email'        => 'email2@email.com',
                ],
            ]
        ];
    }
}
