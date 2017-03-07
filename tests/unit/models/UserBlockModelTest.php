<?php

namespace testS\tests\unit\models;

use testS\models\UserBlockModel;

/**
 * Tests for the model UserBlockModel
 *
 * @package testS\tests\unit\models
 */
class UserBlockModelTest extends AbstractModelTest
{

    /**
     * Gets model name
     *
     * @return UserBlockModel
     */
    protected function getNewModel()
    {
        return new UserBlockModel();
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