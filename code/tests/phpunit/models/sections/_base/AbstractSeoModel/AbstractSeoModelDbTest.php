<?php

namespace ss\tests\phpunit\models\sections\_base\AbstractSeoModel;

use ss\models\sections\SeoModel;
use ss\tests\phpunit\models\_abstract\_base\AbstractDbModelTest;

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
