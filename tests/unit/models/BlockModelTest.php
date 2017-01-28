<?php

namespace testS\tests\unit\models;

use testS\models\BlockModel;

/**
 * Tests for the model BlockModel
 *
 * @package testS\tests\unit\models
 */
class BlockModelTest extends AbstractModelTest
{

    /**
     * Gets model name
     *
     * @return BlockModel
     */
    protected function getNewModel()
    {
        return new BlockModel();
    }
}