<?php

namespace testS\tests\unit\models;

use testS\models\DesignImageSimpleModel;

/**
 * Tests for the model DesignImageSimpleModel
 *
 * @package testS\tests\unit\models
 */
class DesignImageSimpleModelTest extends AbstractModelTest
{

    /**
     * Gets model name
     *
     * @return DesignImageSimpleModel
     */
    protected function getNewModel()
    {
        return new DesignImageSimpleModel();
    }

    public function testA()
    {
        var_dump($this->getNewModel()->get("containerDesignBlockId"));
    }
}