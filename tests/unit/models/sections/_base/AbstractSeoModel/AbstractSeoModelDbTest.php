<?php

namespace testS\tests\unit\models\sections\_base\AbstractSeoModel;

use testS\models\sections\SeoModel;
use testS\tests\unit\models\_abstract\_base\AbstractDbModelTest;

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
