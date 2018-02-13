<?php

namespace ss\tests\unit\models\blocks\helpers\file\_base\AbstractFileModel;

use ss\models\blocks\helpers\file\FileModel;
use ss\tests\unit\models\_abstract\_base\AbstractDuplicateModelTest;

/**
 * Tests for the model AbstractFileModel
 */
class AbstractFileModelDuplicateTest extends AbstractDuplicateModelTest
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

    /**
     * Data provider for CRUD. Duplicate
     *
     * @return void
     */
    public function testDuplicate()
    {
        $this->duplicate(
            [
                'originalName' => 'Original_name.jpg',
                'type'         => 'image/jpeg',
                'size'         => 1024000,
                'uniqueName'   => 'akr84ndkro.jpg',
            ],
            [
                'uniqueName' => ['required']
            ]
        );
    }
}
