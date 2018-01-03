<?php

namespace testS\tests\unit\models\blocks\helpers\tab\_base\AbstractTabModel;

use testS\models\blocks\helpers\tab\TabModel;
use testS\tests\unit\models\_abstract\_base\AbstractDbModelTest;

/**
 * Tests for the model AbstractTabModel
 */
class AbstractTabModelDbTest extends AbstractDbModelTest
{

    /**
     * Gets model name
     *
     * @return TabModel
     */
    protected function getNewModel()
    {
        return new TabModel();
    }
}
