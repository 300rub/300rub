<?php

namespace ss\tests\phpunit\models\blocks\search\_base\AbstractDesignSearchModel;

use ss\models\blocks\search\DesignSearchModel;
use ss\tests\phpunit\models\_abstract\_base\AbstractDbModelTest;

/**
 * Tests for the model AbstractDesignSearchModel
 */
class AbstractDesignSearchModelDbTest extends AbstractDbModelTest
{

    /**
     * Gets model name
     *
     * @return DesignSearchModel
     */
    protected function getNewModel()
    {
        return new DesignSearchModel();
    }
}
