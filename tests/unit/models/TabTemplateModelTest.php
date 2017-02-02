<?php

namespace testS\tests\unit\models;

use testS\models\TabTemplateModel;

/**
 * Tests for the model TabTemplateModel
 *
 * @package testS\tests\unit\models
 */
class TabTemplateModelTest extends AbstractModelTest
{

    /**
     * Gets model name
     *
     * @return TabTemplateModel
     */
    protected function getNewModel()
    {
        return new TabTemplateModel();
    }

    /**
     * Data provider for CRUD. Empty values
     *
     * @return array
     */
    protected function getDataProviderCRUDEmpty()
    {
        $this->markTestSkipped();
        return [];
    }

    /**
     * Data provider for CRUD. Correct values
     *
     * @return array
     */
    protected function getDataProviderCRUDCorrect()
    {
        $this->markTestSkipped();
        return [];
    }

    /**
     * Data provider for CRUD. Incorrect values
     *
     * @return array
     */
    protected function getDataProviderCRUDIncorrect()
    {
        $this->markTestSkipped();
        return [];
    }

    /**
     * Data provider for CRUD. Duplicate
     *
     * @return array
     */
    public function getDataProviderDuplicate()
    {
        $this->markTestSkipped();
        return [];
    }
}