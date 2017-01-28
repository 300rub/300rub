<?php

namespace testS\tests\unit\models;

use testS\models\CatalogModel;

/**
 * Tests for the model CatalogModel
 *
 * @package testS\tests\unit\models
 */
class CatalogModelTest extends AbstractModelTest
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
}