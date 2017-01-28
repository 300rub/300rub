<?php

namespace testS\tests\unit\models;

use testS\models\CatalogInstanceModel;

/**
 * Tests for the model CatalogInstanceModel
 *
 * @package testS\tests\unit\models
 */
class CatalogInstanceModelTest extends AbstractModelTest
{

    /**
     * Gets model name
     *
     * @return CatalogInstanceModel
     */
    protected function getNewModel()
    {
        return new CatalogInstanceModel();
    }
}