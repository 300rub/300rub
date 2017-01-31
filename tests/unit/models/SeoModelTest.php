<?php

namespace testS\tests\unit\models;

use testS\models\SeoModel;

/**
 * Tests for the model SeoModel
 *
 * @package testS\tests\unit\models
 */
class SeoModelTest extends AbstractModelTest
{

    /**
     * Gets model name
     *
     * @return SeoModel
     */
    protected function getNewModel()
    {
        return new SeoModel();
    }

    public function testA()
    {
        $model = $this->getNewModel();
        $model->save();
        var_dump($model->getErrors());
    }
}