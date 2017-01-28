<?php

namespace testS\tests\unit\models;

use testS\models\CatalogOrderModel;

/**
 * Tests for the model CatalogOrderModel
 *
 * @package testS\tests\unit\models
 */
class CatalogOrderModelTest extends AbstractModelTest
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
}