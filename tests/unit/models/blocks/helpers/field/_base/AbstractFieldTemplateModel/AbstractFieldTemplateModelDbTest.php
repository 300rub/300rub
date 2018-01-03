<?php

// @codingStandardsIgnoreLine
namespace testS\tests\unit\models\blocks\helpers\field\_base\AbstractFieldTemplateModel;

use testS\models\blocks\helpers\field\FieldTemplateModel;
use testS\tests\unit\models\_abstract\_base\AbstractDbModelTest;

/**
 * Tests for the model AbstractFieldTemplateModel
 */
class AbstractFieldTemplateModelDbTest extends AbstractDbModelTest
{

    /**
     * Gets model name
     *
     * @return FieldTemplateModel
     */
    protected function getNewModel()
    {
        return new FieldTemplateModel();
    }
}
