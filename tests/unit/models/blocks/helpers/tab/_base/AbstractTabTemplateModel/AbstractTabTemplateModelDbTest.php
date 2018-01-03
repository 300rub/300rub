<?php

// @codingStandardsIgnoreLine
namespace testS\tests\unit\models\blocks\helpers\tab\_base\AbstractTabTemplateModel;

use testS\models\blocks\helpers\tab\TabTemplateModel;
use testS\tests\unit\models\_abstract\_base\AbstractDbModelTest;

/**
 * Tests for the model AbstractTabTemplateModel
 */
class AbstractTabTemplateModelDbTest extends AbstractDbModelTest
{

    /**
     * Gets model name
     *
     * @return TabTemplateModel
     */
    protected function getNewModel()
    {
        return new TabTemplateModel();
    }
}
