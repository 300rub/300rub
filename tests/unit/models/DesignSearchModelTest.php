<?php

namespace testS\tests\unit\models;

use testS\models\DesignSearchModel;

/**
 * Tests for the model DesignSearchModel
 *
 * @package testS\tests\unit\models
 */
class DesignSearchModelTest extends AbstractModelTest
{

    /**
     * Gets model name
     *
     * @return DesignSearchModel
     */
    protected function getNewModel()
    {
        return new DesignSearchModel();
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
    public function testDuplicate()
    {
        $this->markTestSkipped();
        return [];
    }
}