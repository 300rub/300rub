<?php

namespace ss\tests\unit\models\_abstract\_base;

/**
 * Abstract class to test base models
 */
abstract class AbstractIncorrectModelTest extends AbstractBaseModelTest
{

    /**
     * Data provider for CRUD. Incorrect values
     *
     * @return array
     */
    abstract protected function getDataProviderIncorrect();

    /**
     * Data provider for CRUD
     *
     * @return array
     */
    public function dataProvider()
    {
        return $this->getDataProviderIncorrect();
    }
}
