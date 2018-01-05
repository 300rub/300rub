<?php

namespace testS\tests\unit\models\sections\_base\AbstractSectionModel;

use testS\models\sections\SectionModel;
use testS\tests\unit\models\_abstract\_base\AbstractDbModelTest;

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
