<?php

namespace ss\tests\phpunit\models\sections\_base\AbstractSectionModel;

use ss\models\sections\SectionModel;
use ss\tests\phpunit\models\_abstract\_base\AbstractDbModelTest;

/**
 * Tests for the model SectionModel
 */
class AbstractSectionModelDbTest extends AbstractDbModelTest
{

    /**
     * Gets model name
     *
     * @return SectionModel
     */
    protected function getNewModel()
    {
        return new SectionModel();
    }
}
