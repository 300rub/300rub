<?php

namespace ss\tests\phpunit\models\blocks\helpers\tab\_base\AbstractTabModel;

use ss\models\blocks\helpers\tab\TabModel;
use ss\tests\phpunit\models\_abstract\_base\AbstractDbModelTest;

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
