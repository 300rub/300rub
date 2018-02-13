<?php

namespace ss\tests\unit\models\_abstract\_base;

/**
 * Abstract class to test base models
 */
abstract class AbstractEmptyModelTest extends AbstractBaseModelTest
{

    /**
     * Data provider for CRUD. Empty values
     *
     * @return array
     */
    abstract protected function getDataProviderEmpty();

    /**
     * Data provider for CRUD
     *
     * @return array
     */
    public function dataProvider()
    {
        return $this->getDataProviderEmpty();
    }
}
