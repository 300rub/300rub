<?php

namespace testS\tests\unit\models;

use testS\models\UserBlockGroupModel;

/**
 * Tests for the model UserBlockGroupModel
 *
 * @package testS\tests\unit\models
 */
class UserBlockGroupModelTest extends AbstractModelTest
{

    /**
     * Gets model name
     *
     * @return UserBlockGroupModel
     */
    protected function getNewModel()
    {
        return new UserBlockGroupModel();
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