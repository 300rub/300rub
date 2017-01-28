<?php

namespace testS\tests\unit\models;

use testS\models\SiteMapModel;

/**
 * Tests for the model SiteMapModel
 *
 * @package testS\tests\unit\models
 */
class SiteMapModelTest extends AbstractModelTest
{

    /**
     * Gets model name
     *
     * @return SiteMapModel
     */
    protected function getNewModel()
    {
        return new SiteMapModel();
    }
}