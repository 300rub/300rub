<?php

namespace ss\tests\phpunit\models\blocks\text\_base\AbstractTextInstanceModel;

use ss\models\blocks\text\TextInstanceModel;
use ss\tests\phpunit\models\_abstract\_base\AbstractDbModelTest;

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
