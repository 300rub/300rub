<?php

namespace testS\tests\unit\models;

use testS\models\UserSectionModel;

/**
 * Tests for the model UserSectionModel
 *
 * @package testS\tests\unit\models
 */
class UserSectionModelTest extends AbstractModelTest
{

    /**
     * Gets model name
     *
     * @return UserSectionModel
     */
    protected function getNewModel()
    {
        return new UserSectionModel();
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