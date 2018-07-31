<?php

// @codingStandardsIgnoreLine
namespace ss\tests\phpunit\models\blocks\catalog\_base\AbstractCatalogInstanceLinkModel;

use ss\models\blocks\catalog\CatalogInstanceLinkModel;
use ss\tests\phpunit\models\_abstract\_base\AbstractIncorrectModelTest;

/**
 * Tests for the model AbstractCatalogInstanceLinkModel
 */
// @codingStandardsIgnoreLine
class AbstractCatalogInstanceLinkModelIncorrectTest extends AbstractIncorrectModelTest
{

    /**
     * Gets model name
     *
     * @return CatalogInstanceLinkModel
     */
    protected function getNewModel()
    {
        return new CatalogInstanceLinkModel();
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
                    'catalogInstanceId'     => 'incorrect',
                    'linkCatalogInstanceId' => 'incorrect',
                ],
                [],
                null,
                null,
                self::EXCEPTION_MODEL
            ],
            'incorrect2' => [
                [
                    'catalogInstanceId'     => 999,
                    'linkCatalogInstanceId' => 997,
                ],
                [],
                null,
                null,
                self::EXCEPTION_MODEL
            ],
            'incorrect3' => [
                [
                    'catalogInstanceId'     => ' 1a ',
                    'linkCatalogInstanceId' => ' 2a ',
                ],
                [
                    'catalogInstanceId'     => 1,
                    'linkCatalogInstanceId' => 2,
                ],
            ],
            'incorrect4' => [
                [
                    'catalogInstanceId'     => 1,
                    'linkCatalogInstanceId' => 2,
                ],
                [
                    'catalogInstanceId'     => 1,
                    'linkCatalogInstanceId' => 2,
                ],
                [
                    'catalogInstanceId'     => 2,
                    'linkCatalogInstanceId' => 1,
                ],
                [
                    'catalogInstanceId'     => 1,
                    'linkCatalogInstanceId' => 2,
                ],
            ]
        ];
    }
}
