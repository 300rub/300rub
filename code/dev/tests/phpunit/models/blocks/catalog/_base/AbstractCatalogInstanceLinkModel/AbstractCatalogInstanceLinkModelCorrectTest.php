<?php

// @codingStandardsIgnoreLine
namespace ss\tests\phpunit\models\blocks\catalog\_base\AbstractCatalogInstanceLinkModel;

use ss\models\blocks\catalog\CatalogInstanceLinkModel;
use ss\tests\phpunit\models\_abstract\_base\AbstractCorrectModelTest;

/**
 * Tests for the model AbstractCatalogInstanceLinkModel
 */
// @codingStandardsIgnoreLine
class AbstractCatalogInstanceLinkModelCorrectTest extends AbstractCorrectModelTest
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
     * Data provider for CRUD. Correct values
     *
     * @return array
     */
    protected function getDataProviderCorrect()
    {
        return [
            'correct1' => [
                [
                    'catalogInstanceId'     => 1,
                    'linkCatalogInstanceId' => 2,
                ],
                [
                    'catalogInstanceId'     => 1,
                    'linkCatalogInstanceId' => 2,
                ],
            ]
        ];
    }
}
