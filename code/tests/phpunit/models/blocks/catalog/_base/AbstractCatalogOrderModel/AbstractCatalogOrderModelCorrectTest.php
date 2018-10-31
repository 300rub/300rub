<?php

// @codingStandardsIgnoreLine
namespace ss\tests\phpunit\models\blocks\catalog\_base\AbstractCatalogOrderModel;

use ss\models\blocks\catalog\CatalogOrderModel;
use ss\tests\phpunit\models\_abstract\_base\AbstractCorrectModelTest;

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
