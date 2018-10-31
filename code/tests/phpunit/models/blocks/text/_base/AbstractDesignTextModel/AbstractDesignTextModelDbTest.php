<?php

namespace ss\tests\phpunit\models\blocks\text\_base\AbstractDesignTextModel;

use ss\models\blocks\text\DesignTextModel;
use ss\tests\phpunit\models\_abstract\_base\AbstractDbModelTest;

/**
 * Tests for the model DesignTextModel
 */
class AbstractDesignTextModelDbTest extends AbstractDbModelTest
{

    /**
     * Gets model name
     *
     * @return DesignTextModel
     */
    protected function getNewModel()
    {
        return new DesignTextModel();
    }
}
