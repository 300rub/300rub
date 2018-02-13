<?php

namespace ss\tests\unit\models\sections\_base\AbstractSectionModel;

use ss\models\sections\SectionModel;
use ss\tests\unit\models\_abstract\_base\AbstractDbModelTest;

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
