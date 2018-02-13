<?php

namespace ss\tests\unit\models\blocks\text\_base\AbstractTextModel;

use ss\models\blocks\text\TextModel;
use ss\tests\unit\models\_abstract\_base\AbstractDbModelTest;

/**
 * Tests for the model TextModel
 */
class AbstractTextModelDbTest extends AbstractDbModelTest
{

    /**
     * Gets model name
     *
     * @return TextModel
     */
    protected function getNewModel()
    {
        return new TextModel();
    }
}
