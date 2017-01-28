<?php

namespace testS\tests\unit\models;

use testS\models\ImageModel;

/**
 * Tests for the model ImageModel
 *
 * @package testS\tests\unit\models
 */
class ImageModelTest extends AbstractModelTest
{

    /**
     * Gets model name
     *
     * @return ImageModel
     */
    protected function getNewModel()
    {
        return new ImageModel();
    }
}