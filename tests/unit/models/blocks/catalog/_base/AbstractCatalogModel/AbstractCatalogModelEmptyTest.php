<?php

namespace ss\tests\unit\models\blocks\catalog\_base\AbstractCatalogModel;

use ss\models\blocks\catalog\CatalogModel;
use ss\tests\unit\models\_abstract\_base\AbstractEmptyModelTest;

/**
 * Tests for the model AbstractCatalogModel
 */
class AbstractCatalogModelEmptyTest extends AbstractEmptyModelTest
{

    /**
     * Gets model name
     *
     * @return CatalogModel
     */
    protected function getNewModel()
    {
        return new CatalogModel();
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
                    'hasImages'            => false,
                    'useAutoload'          => false,
                    'pageNavigationSize'   => 0,
                    'shortCardDateType'    => 0,
                    'fullCardDateType'     => 0,
                    'hasRelations'         => false,
                    'relationsLabel'       => '',
                    'hasBin'               => false,
                ],
                null,
                null,
                null,
                null,
                [
                    'imageModel',
                    'tabModel',
                    'fieldModel',
                    'descriptionTextModel',
                    'designCatalogModel',
                ]
            ],
        ];
    }
}
