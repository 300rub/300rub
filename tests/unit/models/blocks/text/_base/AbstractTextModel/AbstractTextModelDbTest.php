<?php

namespace testS\tests\unit\models\blocks\text\_base\AbstractTextModel;

use testS\models\blocks\text\TextModel;
use testS\tests\unit\models\_abstract\_base\AbstractDbModelTest;

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
