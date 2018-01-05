<?php

namespace testS\tests\unit\models\blocks\text\_base\AbstractDesignTextModel;

use testS\models\blocks\text\DesignTextModel;
use testS\tests\unit\models\_abstract\_base\AbstractDbModelTest;

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
