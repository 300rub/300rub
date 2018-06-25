<?php

namespace ss\tests\unit\models\blocks\helpers\file\_base\AbstractFileModel;

use ss\models\blocks\helpers\file\FileModel;
use ss\tests\unit\models\_abstract\_base\AbstractDbModelTest;

/**
 * Tests for the model AbstractFileModel
 */
class AbstractFileModelDbTest extends AbstractDbModelTest
{

    /**
     * Gets model name
     *
     * @return FileModel
     */
    protected function getNewModel()
    {
        return new FileModel();
    }
}
