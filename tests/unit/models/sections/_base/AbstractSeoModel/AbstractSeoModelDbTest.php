<?php

namespace ss\tests\unit\models\sections\_base\AbstractSeoModel;

use ss\models\sections\SeoModel;
use ss\tests\unit\models\_abstract\_base\AbstractDbModelTest;

/**
 * Tests for the model SeoModel
 */
class AbstractSeoModelDbTest extends AbstractDbModelTest
{

    /**
     * Gets model name
     *
     * @return SeoModel
     */
    protected function getNewModel()
    {
        return new SeoModel();
    }
}
