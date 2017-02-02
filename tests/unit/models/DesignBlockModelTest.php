<?php

namespace testS\tests\unit\models;

use testS\models\DesignBlockModel;

/**
 * Tests for the model DesignBlockModel
 *
 * @package testS\tests\unit\models
 */
class DesignBlockModelTest extends AbstractModelTest
{

    /**
     * Gets model name
     *
     * @return DesignBlockModel
     */
    protected function getNewModel()
    {
        return new DesignBlockModel();
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