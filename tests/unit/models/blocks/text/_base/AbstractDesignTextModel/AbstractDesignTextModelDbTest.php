<?php

namespace ss\tests\unit\models\blocks\text\_base\AbstractDesignTextModel;

use ss\models\blocks\text\DesignTextModel;
use ss\tests\unit\models\_abstract\_base\AbstractDbModelTest;

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
