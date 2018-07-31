<?php

// @codingStandardsIgnoreLine
namespace ss\tests\phpunit\models\blocks\catalog\_base\AbstractCatalogInstanceLinkModel;

use ss\models\blocks\catalog\CatalogInstanceLinkModel;
use ss\tests\phpunit\models\_abstract\_base\AbstractEmptyModelTest;

/**
 * Tests for the model AbstractCatalogInstanceLinkModel
 */
class AbstractCatalogInstanceLinkModelEmptyTest extends AbstractEmptyModelTest
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
                    'catalogInstanceId'     => '',
                    'linkCatalogInstanceId' => '',
                ],
                [],
                null,
                null,
                self::EXCEPTION_MODEL
            ],
        ];
    }
}
