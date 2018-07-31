<?php

namespace ss\tests\phpunit\models\_abstract\_base;

/**
 * Abstract class to test base models
 */
abstract class AbstractCorrectModelTest extends AbstractBaseModelTest
{

    /**
     * Data provider for CRUD. Correct values
     *
     * @return array
     */
    abstract protected function getDataProviderCorrect();

    /**
     * Data provider for CRUD
     *
     * @return array
     */
    public function dataProvider()
    {
        return $this->getDataProviderCorrect();
    }
}
