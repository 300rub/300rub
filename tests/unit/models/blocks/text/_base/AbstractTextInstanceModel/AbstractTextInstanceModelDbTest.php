<?php

namespace testS\tests\unit\models\blocks\text\_base\AbstractTextInstanceModel;

use testS\models\blocks\text\TextInstanceModel;
use testS\tests\unit\models\_abstract\_base\AbstractDbModelTest;

/**
 * Tests for the model TextInstanceModel
 */
class AbstractTextInstanceModelDbTest extends AbstractDbModelTest
{

    /**
     * Gets model name
     *
     * @return TextInstanceModel
     */
    protected function getNewModel()
    {
        return new TextInstanceModel();
    }
}
